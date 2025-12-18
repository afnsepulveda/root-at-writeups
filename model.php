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
        die("Erro ao ligar à base de dados.");
    }

    return $conexao;
}

// Função para buscar todos os posts
function obterTodosPosts() {
    $conn = estabelecerConexao();
    // Ordenar por data decrescente (o mais recente primeiro)
    $stmt = $conn->query("SELECT * FROM posts ORDER BY data_criacao DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar um post específico por ID
function obterPostPorId($id) {
    $conn = estabelecerConexao();
    // Usamos prepare para prevenir SQL Injection!
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>