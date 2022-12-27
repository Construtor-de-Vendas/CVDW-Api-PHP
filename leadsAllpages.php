<?php

// Rodando no terminal: for i in {1..300}; do php leads.php; done
include("includes/conexao.php");

$chave = 'numero';
$quantidadeRegistros = 500;
$pagina = 1;
$paginas = 1;
$email = "gabriel@cvcrm.com.br";
$token = "f3f2ebfbb4e4fb620c3f1e8a5031117d63095c4d";

for($pagina = 1; $pagina <= $paginas; $pagina++) {

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
                                    "pagina": '. $pagina .',
                                    "registros_por_pagina": '. $quantidadeRegistros .'
                                }',
        CURLOPT_HTTPHEADER => array(
            'email: '.$email.'',
            'token: '.$token.'',
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
    echo "Página: $pagina de " . $json['total_de_paginas'] . "\n";
    $paginas = $json['total_de_paginas'];

    //echo "Processando os primeiros $quantidadeRegistros... \n";

    if(isset($json['dados']) && is_array($json['dados'])) {
        foreach($json['dados'] as $lead) {

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
                //echo " --> Lead salvo com sucesso!";
            } else {
                echo $lead[$chave];
                echo " --> Ocorreu algum erro ao processar o Lead.";
                echo $sql;
                echo "\n";
                print_r($conexao->errorInfo());
                exit();
            }
        }
    }

}

$conexao = null;