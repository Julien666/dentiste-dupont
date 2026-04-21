<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);

    if (!empty($titre) && !empty($contenu)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO news (titre, contenu) VALUES (?, ?)");
            $stmt->execute([$titre, $contenu]);
            header('Location: index.php?page=gestion-news&success=published');
        } catch (PDOException $e) {
            die("Erreur lors de la publication : " . $e->getMessage());
        }
    } else {
        header('Location: index.php?page=gestion-news&error=empty');
    }
} else {
    header('Location: index.php?page=gestion-news');
}
exit();