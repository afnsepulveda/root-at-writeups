<?php
include "model.php";

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = obterPostPorId($id);
} else {
    $post = false;
}

// Se o post não existir, redireciona
if (!$post) {
    header("Location: index.php");
    exit;
}

// --- LÓGICA DE INTERAÇÃO (LIKES E COMENTÁRIOS) ---
$msgErro = "";
$msgSucesso = "";

// Apenas processa se for POST e o utilizador estiver logado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    
    // 1. Processar Like
    if (isset($_POST['action']) && $_POST['action'] === 'toggle_like') {
        alternarLike($id, $_SESSION['user_id']);
        // Refresh na página para atualizar o contador visualmente
        header("Location: post.php?id=" . $id); 
        exit;
    }

    // 2. Processar Comentário
    if (isset($_POST['comentario'])) {
        $conteudo = trim($_POST['comentario']);
        if (!empty($conteudo)) {
            if (adicionarComentario($id, $_SESSION['user_id'], $conteudo)) {
                 // Refresh para evitar reenvio do formulário (F5)
                header("Location: post.php?id=" . $id);
                exit;
            } else {
                $msgErro = "Erro ao guardar comentário.";
            }
        } else {
            $msgErro = "O comentário não pode estar vazio.";
        }
    }
}

// Buscar dados atualizados para exibir
$comentarios = obterComentariosPorPost($id);
$totalLikes = contarLikes($id);
$deuLike = isset($_SESSION['user_id']) ? verificarLike($id, $_SESSION['user_id']) : false;

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

    <hr style="margin: 40px 0; border-color: #333;">

    <div class="interaction-area">
        <form method="post" action="post.php?id=<?php echo $id; ?>" style="display:inline;">
            <input type="hidden" name="action" value="toggle_like">
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <button type="submit" class="btn-like <?php echo $deuLike ? 'active' : ''; ?>">
                    <span class="heart-icon"><?php echo $deuLike ? '♥' : '♡'; ?></span> 
                    <?php echo $deuLike ? 'Gostaste' : 'Gostar'; ?>
                </button>
            <?php else: ?>
                <a href="login.php" class="btn-like disabled" title="Faz login para gostar">♡ Gostar</a>
            <?php endif; ?>
        </form>
        
        <span class="likes-count">
            <strong><?php echo $totalLikes; ?></strong> likes
        </span>
    </div>

    <div class="comments-section" style="margin-top: 50px;">
        <h3><i class="icon-comment"></i> Comentários (<?php echo count($comentarios); ?>)</h3>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="new-comment-box">
                <?php if($msgErro) echo "<p style='color:#ff3333;'>$msgErro</p>"; ?>
                
                <form method="post" action="post.php?id=<?php echo $id; ?>">
                    <textarea name="comentario" class="form-control" rows="3" placeholder="Escreve um comentário..." required style="width:100%; margin-bottom:10px; background:#0d0d0d; color:#fff; border:1px solid #333; padding:10px;"></textarea>
                    <button type="submit" class="btn-submit" style="font-size:0.9em;">Publicar Comentário</button>
                </form>
            </div>
        <?php else: ?>
            <div class="login-alert" style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <p>Queres participar na discussão? <a href="login.php" style="color: var(--primary-neon);">Faz login</a> ou <a href="register.php" style="color: var(--primary-neon);">cria conta</a>.</p>
            </div>
        <?php endif; ?>

        <div class="comments-list" style="margin-top: 30px;">
            <?php if (count($comentarios) > 0): ?>
                <?php foreach ($comentarios as $c): ?>
                    <div class="comment-item" style="border-bottom: 1px solid #222; padding: 15px 0;">
                        <div class="comment-header" style="margin-bottom: 5px;">
                            <strong style="color: var(--primary-neon);">@<?php echo htmlspecialchars($c['username']); ?></strong>
                            <span style="font-size: 0.8em; color: #666; float: right;">
                                <?php echo date('d/m/Y H:i', strtotime($c['data_criacao'])); ?>
                            </span>
                        </div>
                        <div class="comment-content" style="color: #ddd; line-height: 1.5;">
                            <?php echo nl2br(htmlspecialchars($c['conteudo'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #666; font-style: italic;">Ainda não existem comentários. Sê o primeiro!</p>
            <?php endif; ?>
        </div>
    </div>

    <div style="margin-top: 40px;">
        <a href="index.php" class="read-more">&laquo; Voltar à Home</a>
    </div>
</section>

<style>
    .btn-like {
        background: transparent;
        border: 1px solid var(--primary-neon); /* Assume verde neon do teu tema */
        color: var(--primary-neon);
        padding: 8px 16px;
        cursor: pointer;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.3s ease;
        border-radius: 4px;
        margin-right: 10px;
    }
    .btn-like:hover {
        background: rgba(0, 255, 65, 0.1); /* Brilho leve */
        box-shadow: 0 0 10px rgba(0, 255, 65, 0.2);
    }
    .btn-like.active {
        background: var(--primary-neon);
        color: #000; /* Texto preto no fundo neon */
        font-weight: bold;
    }
    .btn-like.disabled {
        border-color: #555;
        color: #555;
        cursor: not-allowed;
        text-decoration: none;
        display: inline-block;
    }
    .heart-icon { margin-right: 5px; }
    .likes-count { font-size: 1.1em; vertical-align: middle; }
</style>

<?php include "footer.php"; ?>