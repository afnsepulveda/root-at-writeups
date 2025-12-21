<?php
// Iniciar a sessão no topo para estar disponível em todo o site
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estabelecerConexao()
{
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

// --- Funções de Posts ---

function obterTodosPosts() {
    $conn = estabelecerConexao();
    $stmt = $conn->query("SELECT * FROM posts ORDER BY data_criacao DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obterPostPorId($id) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// NOVA: Criar Post (Apenas Admin)
function criarPost($titulo, $conteudo) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("INSERT INTO posts (titulo, conteudo, data_criacao) VALUES (?, ?, NOW())");
    return $stmt->execute([$titulo, $conteudo]);
}

// --- Funções de Utilizador (Auth) ---

// NOVA: Registar Utilizador
function registarUtilizador($username, $password) {
    $conn = estabelecerConexao();
    // Hash da password para segurança
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hash]);
    } catch (PDOException $e) {
        // Código 23000 geralmente é violação de chave única (user duplicado)
        if ($e->getCode() == 23000) {
            return "O utilizador já existe.";
        }
        return "Erro ao registar.";
    }
}

// NOVA: Verificar Login
function verificarLogin($username, $password) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se user existe e se a password bate certo com o hash
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}
?>