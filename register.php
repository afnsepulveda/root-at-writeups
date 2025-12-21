<?php
include "model.php";
$titulo = "registar@writeups";
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $resultado = registarUtilizador($username, $password);
        if ($resultado === true) {
            header("Location: login.php?msg=registado");
            exit;
        } else {
            $erro = $resultado; // Mensagem de erro
        }
    } else {
        $erro = "Preenche todos os campos.";
    }
}

include "header.php";
?>

<section class="page-content">
    <h1>Criar Conta</h1>
    <?php if($erro): ?>
        <p style="color: #ff3333; margin-bottom: 15px;">Erro: <?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post" action="register.php">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn-submit">Registar >_</button>
    </form>
    
    <div class="auth-links">
        Já tens conta? <a href="login.php">Faz login aqui</a>.
    </div>
</section>

<?php include "footer.php"; ?>