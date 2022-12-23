<?php

$host = "127.0.0.1";
$usuario = "root";
$senha = "Mancape#86";
$database = "cvdw";

$quantidadeRegistros = 5;

try {
    $conexao = new PDO('mysql:host='.$host.';dbname=' . $database . '', $usuario, $senha);
    echo "Conectando a base de dados... \n";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage() . "<br/>";
    die();
}
echo "Conectado! \n";

echo "Buscando ultima data de alteração na base... \n";
$sqlUltima = $conexao->query('SELECT data_ultima_alteracao_lead from leads order by data_ultima_alteracao_lead desc limit 1');
$ultimaAlteracao = $sqlUltima->fetch();
if(!isset($ultimaAlteracao["data_ultima_alteracao_lead"])) $ultimaAlteracao["data_ultima_alteracao_lead"] = null;
echo "Data retornada: ". $ultimaAlteracao["data_ultima_alteracao_lead"] ."\n";

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
                                "a_partir_data_modificacao": "'. $ultimaAlteracao["data_ultima_alteracao_lead"] .'"
                            }',
    CURLOPT_HTTPHEADER => array(
        'email: gabriel@cvcrm.com.br',
        'token: f3f2ebfbb4e4fb620c3f1e8a5031117d63095c4d',
        'Content-Type: application/json',
        'Cookie: CVid=kjvludjdri84lpihru83pkdm1r'
    ),
));

echo "Conectando a api do CV... \n";
$resposta = curl_exec($curl);
curl_close($curl);

$json = json_decode($resposta, true);

echo "Leads encontrados: ". $json['total_de_registros'] ."\n";
echo "Processando os primeiros $quantidadeRegistros... \n";

foreach($json['dados'] as $lead) {
    echo $lead['numero'];
    echo "\n";
}

$conexao = null;