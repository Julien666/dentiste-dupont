<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') exit();

$id = $_GET['id'] ?? null;

if ($id) {
    // 1. On récupère le nom de l'image avant de supprimer l'article
    $stmt = $pdo->prepare("SELECT image_url FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();

    if ($article) {
        // 2. Si une image existe, on la supprime du dossier physique
        if (!empty($article['image_url'])) {
            $filePath = ROOT_PATH . '/public/img/news/' . $article['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath); // C'est ici que la magie opère !
            }
        }

        // 3. Enfin, on supprime l'article de la base de données
        $delete = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $delete->execute([$id]);
    }
}

// On redirige vers admin-news (attention au nom de la page dans ton index.php)
header('Location: index.php?page=admin-news&success=deleted');
exit();