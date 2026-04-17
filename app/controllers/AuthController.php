<?php
session_start();
require_once '../../config/db.php';
require_once '../models/User.php';

// 1. On vérifie que des données ont été envoyées via le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. On récupère les données et on nettoie les espaces
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 3. On appelle le Modèle User pour chercher l'utilisateur par son email
    $userModel = new User($pdo);
    $user = $userModel->findByEmail($email);

    // 4. On vérifie si l'utilisateur existe ET si le mot de passe correspond au hash
    if ($user && password_verify($password, $user['password'])) {
        
        // Succès : On remplit la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: ../views/back/dashboard.php');
        } else {
            header('Location: ../views/front/mes-rdv.php');
        }
        exit();
    } else {
        // Échec : Redirection vers le login avec un message d'erreur
        header('Location: ../views/login.php?error=invalid');
        exit();
    }
} else {
    // Si quelqu'un essaie d'accéder au fichier sans formulaire, on le renvoie à l'accueil
    header('Location: ../../public/index.php');
    exit();
}