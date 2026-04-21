<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On utilise l'opérateur de coalescence (??) pour éviter les warnings si le champ est vide
    $nom = htmlspecialchars($_POST['nom_service'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $description = htmlspecialchars($_POST['description'] ?? ''); // Évite le warning si absent
    $duree = intval($_POST['duree'] ?? 30);

    if (!empty($nom) && $prix > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO services (nom, prix, description, duree_minutes) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $prix, $description, $duree]);

            header('Location: index.php?page=gestion-services&success=1');
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de l'ajout : " . $e->getMessage());
        }
    } else {
        header('Location: index.php?page=gestion-services&error=invalid');
        exit();
    }
}