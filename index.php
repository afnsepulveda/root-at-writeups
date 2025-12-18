<?php
include "model.php";

// Buscar os posts à base de dados
$posts = obterTodosPosts();

$titulo = "home@writeups";
include "header.php";
?>

    <section class="post-list">
        <h2>Últimos Projetos e Writeups</h2>
        
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <article class="post-preview">
                    <h3><?php echo htmlspecialchars($post['titulo']); ?></h3>
                    
                    <p class="post-meta">
                        Publicado em <?php echo date('d/m/Y', strtotime($post['data_criacao'])); ?>
                    </p>
                    
                    <p>
                        <?php echo htmlspecialchars(substr($post['conteudo'], 0, 150)) . '...'; ?>
                    </p>
                    
                    <a href="post.php?id=<?php echo $post['id']; ?>" class="read-more">Ler mais &raquo;</a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Ainda não existem posts publicados.</p>
        <?php endif; ?>

    </section>

<?php 
include "footer.php";
?>