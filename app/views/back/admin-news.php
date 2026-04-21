<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

$articles = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>

<main class="container" style="margin-top: 40px; max-width: 900px;">
    <h2>⚙️ Gestion des Actualités</h2>

    <section style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 40px;">
        <h3>Ajouter un article</h3>
        <form action="index.php?page=add-news" method="POST" enctype="multipart/form-data">
            <div style="margin-bottom: 15px;">
                <label>Titre de l'actualité :</label>
                <input type="text" name="titre" required style="width: 100%; padding: 10px; margin-top: 5px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Contenu :</label>
                <textarea name="contenu" rows="5" required style="width: 100%; padding: 10px; margin-top: 5px;"></textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label>Image d'illustration :</label>
                <input type="file" name="image" accept="image/*" style="display: block; margin-top: 5px;">
            </div>
            <button type="submit" style="background: #27ae60; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer;">Publier l'article</button>
        </form>
    </section>

    <h3>Articles publiés</h3>
    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden;">
        <thead style="background: #f8f9fa;">
            <tr>
                <th style="padding: 15px; text-align: left;">Date</th>
                <th style="padding: 15px; text-align: left;">Titre</th>
                <th style="padding: 15px; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $a): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px;"><?php echo date('d/m/Y', strtotime($a['created_at'])); ?></td>
                <td style="padding: 15px;"><strong><?php echo htmlspecialchars($a['titre']); ?></strong></td>
                <td style="padding: 15px; text-align: center;">
                    <a href="index.php?page=edit-news&id=<?php echo $a['id']; ?>" style="color: #3498db; text-decoration: none; margin-right: 15px;">✏️ Modifier</a>
                    <a href="index.php?page=delete-news&id=<?php echo $a['id']; ?>" onclick="return confirm('Supprimer ?')" style="color: #e74c3c; text-decoration: none;">❌ Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>