<?php
function criarConexaoBanco(): mysqli {
    $bancoCredenciais = parse_ini_file(__DIR__ . '/../.env');

    $conn = new mysqli(
        $bancoCredenciais['DB_HOST'],
        $bancoCredenciais['DB_USER'],
        $bancoCredenciais['DB_PASS'],
        $bancoCredenciais['DB_NAME']
    );

    if ($conn->connect_error) {
        error_log("Erro de conexão: " . $conn->connect_error);
        die("Erro ao conectar ao banco de dados.");
    }

    return $conn;
}