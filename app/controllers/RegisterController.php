<?php
/**
 * RegisterController.php
 * Ce fichier est inclus par index.php, donc $pdo est déjà disponible.
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Récupération et nettoyage des données (protection XSS)
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password']; 

    // 2. Vérification si l'email existe déjà (on utilise $pdo de l'index)
    $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->fetch()) {
        // Redirection vers la route register avec un message d'erreur
        header('Location: index.php?page=register&error=exists');
        exit();
    }

    // 3. Hachage du mot de passe (Sécurité : JAMAIS en clair)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insertion dans la base de données
    $sql = "INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, 'patient')";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nom, $prenom, $email, $hashedPassword])) {
        // SUCCÈS : Redirection vers la page login via l'index
        header('Location: index.php?page=login&success=1');
        exit();
    } else {
        // ÉCHEC technique
        header('Location: index.php?page=register&error=1');
        exit();
    }
} else {
    // Si accès direct sans formulaire
    header('Location: index.php?page=home');
    exit();
}