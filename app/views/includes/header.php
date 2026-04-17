<?php
// On laisse la vérification de session au cas où le header soit inclus 
// mais normalement l'index.php s'en occupe déjà.
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
            <a href="index.php?page=home" style="font-size: 1.5rem; background: none; padding: 0;">
                 <span>Dr. Dupont</span>
            </a>
        </div>

        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="index.php?page=dashboard">Agenda Docteur</a></li>
                    <li><a href="index.php?page=patients">Gestion Patients</a></li> 
                <?php else: ?>
                    <li><a href="index.php?page=mes-rdv">Mes RDV</a></li>
                    <li><a href="index.php?page=prendre-rdv">Prendre RDV</a></li>
                <?php endif; ?>

                <li style="padding: 10px; color: #fff; font-size: 0.9rem;">
                    👤 <?php echo htmlspecialchars($_SESSION['user_nom']); ?>
                </li>

                <li><a href="index.php?page=logout" style="background: #e74c3c; border-radius: 5px;">Déconnexion</a></li>

            <?php else: ?>
                <li><a href="index.php?page=login">Connexion</a></li>
                <li><a href="index.php?page=register">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>