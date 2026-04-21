<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Dupont | Cabinet Dentaire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --dark-color: #2c3e50;
            --light-bg: #f8f9fa;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-color);
        }

        header {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
        }

        .logo span {
            color: var(--primary-color);
            margin-left: 5px;
        }

        nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .btn-nav {
            background-color: var(--primary-color);
            color: white !important;
            padding: 10px 18px;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn-logout {
            background-color: #e74c3c;
            color: white !important;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .user-info {
            font-size: 0.85rem;
            color: #7f8c8d;
            border-left: 1px solid #ddd;
            padding-left: 15px;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <a href="index.php?page=home">🦷 Dr.<span>Dupont</span></a>
        </div>

        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>
            <li><a href="index.php?page=actualites">Actualités</a></li>
            <li><a href="index.php?page=about">À propos</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="index.php?page=dashboard">Agenda</a></li>
                    <li><a href="index.php?page=gestion-horaires">Horaires</a></li>
                    <li><a href="index.php?page=admin-news">⚙️ Gestion News</a></li>
                <?php else: ?>
                    <li><a href="index.php?page=mes-rdv">Mes RDV</a></li>
                    <li><a href="index.php?page=prendre-rdv" class="btn-nav">Prendre RDV</a></li>
                <?php endif; ?>

                <li class="user-info">
                    👤 <?php echo htmlspecialchars($_SESSION['user_nom']); ?>
                </li>
                <li><a href="index.php?page=logout" class="btn-logout">Déconnexion</a></li>

            <?php else: ?>
                <li><a href="index.php?page=login">Connexion</a></li>
                <li><a href="index.php?page=register" class="btn-nav">S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>