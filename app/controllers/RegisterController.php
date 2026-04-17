<?php
// On inclut la connexion à la base de données
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupération et nettoyage des données (protection XSS)
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password']; // On ne nettoie pas le password ici, on va le hacher

    // 2. Vérification si l'email existe déjà
    $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->execute([$email]);

    if ($checkEmail->fetch()) {
        die("Erreur : Cet email est déjà utilisé.");
    }

    // 3. Hachage du mot de passe (Sécurité US03)
    // On ne stocke JAMAIS un mot de passe en clair.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insertion dans la base de données
    // Le rôle est 'patient' par défaut
    $sql = "INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, 'patient')";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nom, $prenom, $email, $hashedPassword])) {
        // Succès : On redirige vers la page de login
        header('Location: ../views/login.php?success=1');
        exit();
    } else {
        echo "Une erreur est survenue lors de l'inscription.";
    }
}