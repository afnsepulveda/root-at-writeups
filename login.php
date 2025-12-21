<?php
include "model.php";
$titulo = "login@writeups";
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $user = verificarLogin($username, $password);

    if ($user) {
        // Sucesso: Guardar dados na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $erro = "Username ou password incorretos.";
    }
}

include "header.php";
?>

<section class="page-content">
    <h1>Login</h1>
    
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'registado'): ?>
        <p style="color: var(--primary-neon); margin-bottom: 15px;">Conta criada com sucesso! Podes entrar.</p>
    <?php endif; ?>

    <?php if($erro): ?>
        <p style="color: #ff3333; margin-bottom: 15px;">Erro: <?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn-submit">Entrar >_</button>
    </form>

    <div class="auth-links">
        Ainda não tens conta? <a href="register.php">Cria uma aqui</a>.
    </div>
</section>

<?php include "footer.php"; ?>