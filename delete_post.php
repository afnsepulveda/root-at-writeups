<?php
include "model.php";

// Verificação de segurança: Apenas "admin" pode realizar esta ação
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    die("ACESSO NEGADO: Apenas o administrador pode apagar posts.");
}

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    apagarPost($id);
}

// Redireciona para a home após apagar
header("Location: index.php");
exit;
?>