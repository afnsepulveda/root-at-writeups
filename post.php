<?php
include "model.php";

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = obterPostPorId($id);
} else {
    $post = false;
}

// Se o post não existir, redireciona ou mostra erro (opcional)
if (!$post) {
    header("Location: index.php"); // Redireciona para a home se não encontrar
    exit;
}

$titulo = htmlspecialchars($post['titulo']) . "@writeups";
include "header.php";
?>

    <section class="page-content">
        <h1><?php echo htmlspecialchars($post['titulo']); ?></h1>
        
        <p class="post-meta" style="border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 20px;">
            <i class="icon-calendar"></i> 
            Publicado em <?php echo date('d/m/Y H:i', strtotime($post['data_criacao'])); ?>
        </p>

        <div class="post-body">
            <?php echo nl2br(htmlspecialchars($post['conteudo'])); ?>
        </div>

        <div style="margin-top: 40px;">
            <a href="index.php" class="read-more">&laquo; Voltar à Home</a>
        </div>
    </section>

<?php
include "footer.php";
?>