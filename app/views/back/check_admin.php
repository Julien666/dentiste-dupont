<?php
session_start();

// Vérifie si l'utilisateur est connecté ET s'il est admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Si ce n'est pas un admin, on le renvoie vers la page de login
    header('Location: ../login.php');
    exit();
}