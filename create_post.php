<?php
include "model.php";

// Verificação de segurança: Apenas "admin" pode ver esta página
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    die("ACESSO NEGADO: Apenas o administrador pode criar posts.");
}

$titulo = "novo_post@writeups";
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tituloPost = $_POST['titulo'];
    $conteudoPost = $_POST['conteudo'];

    if (!empty($tituloPost) && !empty($conteudoPost)) {
        if (criarPost($tituloPost, $conteudoPost)) {
            header("Location: index.php"); // Sucesso, volta para a home
            exit;
        } else {
            $msg = "Erro ao guardar o post na base de dados.";
        }
    } else {
        $msg = "Preenche o título e o conteúdo.";
    }
}

include "header.php";
?>

<section class="page-content">
    <h1>Novo Writeup</h1>
    
    <?php if($msg): ?>
        <p style="color: #ff3333;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="post" action="create_post.php">
        <div class="form-group">
            <label>Título:</label>
            <input type="text" name="titulo" class="form-control" placeholder="Ex: SQL Injection Lab 1" required>
        </div>
        
        <div class="form-group">
            <label>Conteúdo (Aceita HTML básico):</label>
            <textarea name="conteudo" class="form-control" rows="10" placeholder="Escreve aqui o writeup..." required></textarea>
        </div>
        
        <button type="submit" class="btn-submit">Publicar Post >_</button>
    </form>
</section>

<?php include "footer.php"; ?>