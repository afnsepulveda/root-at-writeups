<?php
include "model.php";
$titulo = "home@writeups";
include "header.php";
?>

    <section class="post-list">
        <h2>Últimos Projetos e Writeups</h2>
        <article class="post-preview">
            <h3>Título do Post 1</h3>
            <p class="post-meta">Publicado em 01/01/2025</p>
            <p>Breve descrição do conteúdo do post...</p>
            <a href="post.php?id=1" class="read-more">Ler mais &raquo;</a>
        </article>
        <article class="post-preview">
            <h3>Título do Post 2 - Cibersegurança</h3>
            <p class="post-meta">Publicado em 15/01/2025</p>
            <p>Mais uma breve descrição de outro post interessante...</p>
            <a href="post.php?id=2" class="read-more">Ler mais &raquo;</a>
        </article>
        </section>

<?php 
include "footer.php";
?>