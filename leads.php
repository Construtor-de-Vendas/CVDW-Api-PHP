<?php

// Rodando no terminal: for i in {1..300}; do php leads.php; done
include("includes/conexao.php");

$chave = 'numero';
$quantidadeRegistros = 500;
$email = "gabriel@cvcrm.com.br";
$token = "f3f2ebfbb4e4fb620c3f1e8a5031117d63095c4d";

echo "Buscando ultima data de alteração na base... \n";
$sqlUltima = $conexao->query('SELECT data_ultima_alteracao from leads order by data_ultima_alteracao desc limit 1');
$ultimaAlteracao = $sqlUltima->fetch();
if(!isset($ultimaAlteracao["data_ultima_alteracao"])) {
    $ultimaAlteracao["data_ultima_alteracao"] = null;
    $ultimaAlteracao1Seg = null;
} else {
    $time = new DateTime($ultimaAlteracao["data_ultima_alteracao"]);
    $time->modify("-1 second");
    $ultimaAlteracao1Seg = $time->format("Y-m-d H:i:s");
}
echo "Data retornada: ". $ultimaAlteracao["data_ultima_alteracao"] ." -> $ultimaAlteracao1Seg \n";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://dev.cvcrm.com.br/api/v1/cvdw/leads',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_POSTFIELDS => '	{    
                                "pagina": 1,
                                "registros_por_pagina": '. $quantidadeRegistros .',
                                "a_partir_data_modificacao": "'. $ultimaAlteracao1Seg .'"
                            }',
    CURLOPT_HTTPHEADER => array(
        'email: ' . $email . '',
        'token: ' . $token . '',
        'Content-Type: application/json'
    ),
));

echo "Conectando a api do CV... \n";
$resposta = curl_exec($curl);
curl_close($curl);

$json = json_decode($resposta, true);

if(!isset($json['total_de_registros'])) $json['total_de_registros'] = 0;
echo "Leads encontrados: ". $json['total_de_registros'] ."\n";

if (!isset($json['total_de_paginas'])) $json['total_de_paginas'] = 0;
echo "Páginas: " . $json['total_de_paginas'] . "\n";

echo "Processando os primeiros $quantidadeRegistros... \n";

if(isset($json['dados']) && is_array($json['dados'])) {
    foreach($json['dados'] as $lead) {
        echo $lead[$chave];

        $campos = "$chave";
        $valores = $lead[$chave];
        $camposValores = " $chave = ". $lead[$chave];
        foreach($lead as $ind => $valor) {
            if($ind == $chave) continue;
            $valor = $conexao->quote($valor);
            $campos .= ", $ind";
            $valores .= ", $valor";
            $camposValores .= ", $ind = $valor";
        }

        $sql = 'INSERT INTO leads ('.$campos. ') 
                        VALUES('.$valores.') 
                        ON DUPLICATE KEY UPDATE    
                        '.$camposValores.'';

        $salvar = $conexao->query($sql);
        if($salvar){
            echo " --> Lead salvo com sucesso!";
        } else {
            echo " --> Ocorreu algum erro ao processar o Lead.";
            echo $sql;
            print_r($conexao->errorInfo());
            exit();
        }
        echo "\n";
    }
}

$conexao = null;