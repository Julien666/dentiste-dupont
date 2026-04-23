<?php
// On retire session_start() et les require de config/db car index.php s'en occupe déjà

// 1. On vérifie que des données ont été envoyées via le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. On récupère les données
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 3. On appelle le Modèle User (le require_once est fait dans l'index)
    $userModel = new User($pdo);
    $user = $userModel->findByEmail($email);

    // 4. On vérifie si l'utilisateur existe ET si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        
        // Succès : On remplit la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_role'] = $user['role'];
        

        // REDIRECTION VIA L'INDEX SELON LE RÔLE
        if ($user['role'] === 'admin') {
            header('Location: index.php?page=dashboard');
        } else {
            header('Location: index.php?page=mes-rdv');
        }
        exit();
    } else {
        // ÉCHEC : Redirection vers la route login de l'index
        header('Location: index.php?page=login&error=invalid');
        exit();
    }
} else {
    // Si accès direct sans POST, retour à l'accueil
    header('Location: index.php?page=home');
    exit();
}