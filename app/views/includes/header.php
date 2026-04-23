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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 15px 0; background-color: #fff !important; }
        .logo-text { font-weight: 600; font-size: 1.4rem; color: #2c3e50; text-decoration: none; }
        .logo-text span { color: #3498db; }
        .nav-link { font-weight: 500; color: #576574 !important; transition: color 0.3s; }
        .nav-link:hover { color: #3498db !important; }
        .btn-nav { background-color: #3498db; color: white !important; border-radius: 50px; padding: 8px 25px !important; }
        .user-badge { background-color: #f1f2f6; padding: 5px 15px; border-radius: 50px; color: #2c3e50; font-weight: 500; text-decoration: none; }
        
        .dropdown-menu { z-index: 1050; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 12px; }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="logo-text" href="index.php?page=home">🦷 Dr.<span>Dupont</span></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item"><a class="nav-link" href="index.php?page=home">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=actualites">Actualités</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?page=about">À propos</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=dashboard">Agenda</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=gestion-patients">Gestion Patients</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=gestion-horaires">Gestion Horaires</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=gestion-services">Gestion Services</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=gestion-news">Gestion Actualités</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?page=mes-rdv">Mes RDV</a></li>
                            <li class="nav-item"><a class="nav-link btn btn-nav" href="index.php?page=prendre-rdv">Prendre RDV</a></li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-badge" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 <?= htmlspecialchars($_SESSION['user_nom']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="index.php?page=profil">⚙️ Mon Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="index.php?page=logout">🚪 Déconnexion</a></li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=login">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-nav" href="index.php?page=register">S'inscrire</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>