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
    <title>Cabinet Dentaire - Dr. Dupont</title>
    <link rel="stylesheet" href="/dentiste-dupont/public/css/style.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <a href="/dentiste-dupont/public/index.php" style="font-size: 1.5rem; background: none; padding: 0;">
                🦷 <span>Dr. Dupont</span>
            </a>
        </div>

        <ul>
            <li><a href="/dentiste-dupont/public/index.php">Accueil</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="/dentiste-dupont/app/views/back/dashboard.php">Agenda Docteur</a></li>
                    <li><a href="/dentiste-dupont/app/views/back/liste-patients.php">Gestion Patients</a></li> 
                <?php else: ?>
                    <li><a href="/dentiste-dupont/app/views/front/mes-rdv.php">Mes RDV</a></li>
                    <li><a href="/dentiste-dupont/app/views/front/prendre-rdv.php">Prendre RDV</a></li>
                <?php endif; ?>

                <li style="padding: 10px; color: #fff; font-size: 0.9rem;">
                    👤 <?php echo htmlspecialchars($_SESSION['user_nom']); ?>
                </li>

                <li><a href="/dentiste-dupont/app/controllers/LogoutController.php" style="background: #e74c3c; border-radius: 5px;">Déconnexion</a></li>

            <?php else: ?>
                <li><a href="/dentiste-dupont/app/views/login.php">Connexion</a></li>
                <li><a href="/dentiste-dupont/app/views/register.php">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>