<?php
/**
 * Fichier de configuration de la base de données
 * Projet : Cabinet Dentaire Dr. Dupont
 */

// Paramètres de connexion
$host = 'localhost';
$dbname = 'cabinet_dentaire_dupont';
$username = 'root'; // Utilisateur par défaut sous XAMPP/WAMP
$password = '';     // Mot de passe vide par défaut sous XAMPP/WAMP

try {
    // 1. Création de la connexion PDO
    // On ajoute le charset utf8mb4 pour bien gérer les accents
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
        $username, 
        $password
    );

    // 2. Configuration des options PDO
    // On demande à PDO de lancer des exceptions en cas d'erreur SQL (très utile en développement)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // On définit le mode de récupération des données par défaut : Tableau associatif
    // (Exemple : $user['nom'] au lieu de $user[1])
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 3. Sécurité supplémentaire : désactiver l'émulation des requêtes préparées
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    // Si la connexion échoue, on affiche l'erreur et on arrête le script
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}