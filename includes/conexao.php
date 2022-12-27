<?php

$host = "127.0.0.1";
$usuario = "cvdw";
$senha = "cvdw";
$database = "cvdw";

try {
    $conexao = new PDO('mysql:host=' . $host . ';dbname=' . $database . '', $usuario, $senha);
    echo "Conectando a base de dados... \n";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage() . "<br/>";
    die();
}
echo "Conectado! \n";