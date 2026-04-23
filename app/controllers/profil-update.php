<?php
// Vérification de la session
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $id_user = $_SESSION['user_id'];
    $new_password = $_POST['new_password'];

    try {
        if (!empty($new_password)) {
            // Si l'utilisateur veut changer son mot de passe
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $query = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?");
            $query->execute([$nom, $prenom, $email, $hash, $id_user]);
        } else {
            // Mise à jour simple sans toucher au mot de passe
            $query = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ? WHERE id = ?");
            $query->execute([$nom, $prenom, $email, $id_user]);
        }

        // MISE À JOUR DE LA SESSION (pour que le nom change aussi dans le header)
        $_SESSION['user_nom'] = $nom;

        header('Location: index.php?page=profil&status=updated');
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }
}