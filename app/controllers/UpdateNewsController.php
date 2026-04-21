<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = htmlspecialchars($_POST['contenu']);
    
    // 1. Récupérer l'ancienne image au cas où
    $stmt = $pdo->prepare("SELECT image_url FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $old_article = $stmt->fetch();
    $image_name = $old_article['image_url'];

    // 2. Vérifier si une nouvelle image est téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // Supprimer l'ancienne image physiquement si elle existe
            if ($image_name && file_exists(ROOT_PATH . '/public/img/news/' . $image_name)) {
                unlink(ROOT_PATH . '/public/img/news/' . $image_name);
            }

            // Upload de la nouvelle image
            $image_name = time() . '_' . $filename;
            move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . '/public/img/news/' . $image_name);
        }
    }

    // 3. Mise à jour en base de données
    $update = $pdo->prepare("UPDATE news SET titre = ?, contenu = ?, image_url = ? WHERE id = ?");
    $update->execute([$titre, $contenu, $image_name, $id]);

    header('Location: index.php?page=admin-news&success=updated');
    exit();
}