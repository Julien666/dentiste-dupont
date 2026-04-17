<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Fonction pour protéger les pages
 * @param string $required_role (admin ou patient)
 */
function protect_page($required_role = null) {
    // 1. Si l'utilisateur n'est pas connecté du tout
    if (!isset($_SESSION['user_id'])) {
        header('Location: /dentiste-dupont/app/views/login.php');
        exit();
    }

    // 2. Si un rôle spécifique est requis et que l'utilisateur ne l'a pas
    if ($required_role && $_SESSION['user_role'] !== $required_role) {
        // On le renvoie vers sa page par défaut
        if ($_SESSION['user_role'] === 'admin') {
            header('Location: /dentiste-dupont/app/views/back/dashboard.php');
        } else {
            header('Location: /dentiste-dupont/app/views/front/mes-rdv.php');
        }
        exit();
    }
}