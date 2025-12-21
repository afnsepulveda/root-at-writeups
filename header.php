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
            
            <div class="left-group">
                <h1><a href="index.php">afonso@writeups</a></h1>
                <nav class="main-nav">
                    <a href="index.php">home</a>
                    <a href="about.php">about</a>
                    <a href="contact.php">contact</a>
                </nav>
            </div>

            <div class="right-group">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
                        <a href="create_post.php" class="nav-btn action-btn">+ Post</a>
                    <?php endif; ?>
                    
                    <span class="user-badge"><i class="icon-user"></i> <?= htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="nav-btn logout-btn">[ sair ]</a>

                <?php else: ?>
                    <a href="login.php" class="nav-link">login</a>
                    <a href="register.php" class="nav-btn register-btn">registar</a>
                <?php endif; ?>
            </div>

        </div>
    </header>
    <main class="content">