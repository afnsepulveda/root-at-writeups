<?php

function estabelecerConexao()
{
    // Tenta carregar as configurações
    $configFile = __DIR__ . '/db_config.php';
    
    if (!file_exists($configFile)) {
        die("Erro Crítico: Ficheiro de configuração não encontrado.");
    }

    $config = require $configFile;

    try {
        $conexao = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
            $config['username'],
            $config['password']
        );
        
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch (PDOException $e) {
        // Não mostres $e->getMessage() em produção!
        die("Erro ao ligar à base de dados.");
    }

    return $conexao;
}
?>