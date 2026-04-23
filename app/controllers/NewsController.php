<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = htmlspecialchars($_POST['titre']);
    $contenu = htmlspecialchars($_POST['contenu']);
    $image_name = null;

    // Gestion de l'upload d'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // On crée un nom unique pour éviter les doublons
            $image_name = time() . '_' . $filename;
            $target = ROOT_PATH . '/public/img/news/' . $image_name;
            
            // On crée le dossier s'il n'existe pas
            if (!is_dir(ROOT_PATH . '/public/img/news/')) {
                mkdir(ROOT_PATH . '/public/img/news/', 0777, true);
            }

            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }
    }

    $stmt = $pdo->prepare("INSERT INTO news (titre, contenu, image_url) VALUES (?, ?, ?)");
    $stmt->execute([$titre, $contenu, $image_name]);

    header('Location: index.php?page=gestion-news&success=added');
    exit();
}