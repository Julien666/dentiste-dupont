<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function protect_page($required_role = null) {
    // 1. Si pas connecté -> Retour login via le routeur
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit();
    }

    // 2. Si le rôle ne correspond pas -> Redirection vers sa page dédiée
    if ($required_role && $_SESSION['user_role'] !== $required_role) {
        if ($_SESSION['user_role'] === 'admin') {
            header('Location: index.php?page=dashboard');
        } else {
            header('Location: index.php?page=mes-rdv');
        }
        exit();
    }
}