<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo isset($titulo) ? $titulo : 'afonso@writeups'; ?></title> 
</head>
<body>
    <header class="header">
        <div class="topnav">
            <h1><a href="index.php">afonso@writeups</a></h1>
            <nav>
                <a href="index.php">home</a>
                <a href="about.php">about</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['username'] === 'admin'): ?>
                        <a href="create_post.php" style="color: var(--secondary-neon);">+ novo post</a>
                    <?php endif; ?>
                    <a href="logout.php">logout (<?= htmlspecialchars($_SESSION['username']); ?>)</a>
                <?php else: ?>
                    <a href="login.php">login</a>
                    <a href="register.php">registar</a>
                <?php endif; ?>
                
                <a href="contact.php">contact</a>
            </nav>
        </div>
    </header>
    <main class="content">