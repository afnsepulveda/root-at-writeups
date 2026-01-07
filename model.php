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

// Criar Post (Apenas Admin)
function criarPost($titulo, $conteudo) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("INSERT INTO posts (titulo, conteudo, data_criacao) VALUES (?, ?, NOW())");
    return $stmt->execute([$titulo, $conteudo]);
}

function apagarPost($id) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([$id]);
}

// --- Funções de Utilizador (Auth) ---

// Registar Utilizador
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

// Verificar Login
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

// --- Funções de Comentários ---

function adicionarComentario($postId, $userId, $conteudo) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, conteudo, data_criacao) VALUES (?, ?, ?, NOW())");
    return $stmt->execute([$postId, $userId, $conteudo]);
}

function obterComentariosPorPost($postId) {
    $conn = estabelecerConexao();
    // JOIN com users para buscar o nome de quem comentou
    $sql = "SELECT c.*, u.username 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.post_id = ? 
            ORDER BY c.data_criacao DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$postId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// --- Funções de Likes ---

function alternarLike($postId, $userId) {
    $conn = estabelecerConexao();
    
    // Verifica se já deu like
    if (verificarLike($postId, $userId)) {
        // Se já existe, remove (Dislike)
        $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
    } else {
        // Se não existe, adiciona (Like)
        $stmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
    }
    return $stmt->execute([$postId, $userId]);
}

function verificarLike($postId, $userId) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$postId, $userId]);
    return $stmt->fetchColumn();
}

function contarLikes($postId) {
    $conn = estabelecerConexao();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
    $stmt->execute([$postId]);
    return $stmt->fetchColumn();
}
?>