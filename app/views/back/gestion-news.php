<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupérer toutes les actualités (la plus récente en premier)
$news = $pdo->query("SELECT * FROM news ORDER BY date_pub DESC")->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>📰 Gestion des Actualités</h2>
        <p>Publiez des articles pour informer vos patients.</p>
    </div>

    <section class="admin-section">
        <div class="card" style="padding: 20px; margin-bottom: 30px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
            <h4>Publier un nouvel article</h4>
            <form action="index.php?page=add-news" method="POST" style="display: flex; flex-direction: column; gap: 15px; margin-top: 15px;">
                <input type="text" name="titre" placeholder="Titre de l'article" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                <textarea name="contenu" placeholder="Contenu de l'article..." rows="5" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;"></textarea>
                <button type="submit" class="btn-submit" style="width: 200px;">Publier l'actualité</button>
            </form>
        </div>

        <div class="news-list">
            <h3>Articles publiés</h3>
            <?php if (count($news) > 0): ?>
                <?php foreach ($news as $item): ?>
                    <div style="background: white; padding: 15px; margin-bottom: 15px; border-radius: 8px; border-left: 5px solid #e67e22; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <div>
                            <h4 style="margin: 0; color: #2c3e50;"><?php echo htmlspecialchars($item['titre']); ?></h4>
                            <small style="color: #7f8c8d;">Publié le <?php echo date('d/m/Y à H:i', strtotime($item['date_pub'])); ?></small>
                            <p style="margin-top: 10px; font-size: 0.9rem; color: #34495e;">
                                <?php echo nl2br(htmlspecialchars(substr($item['contenu'], 0, 150))); ?>...
                            </p>
                        </div>
                        <div style="margin-left: 20px;">
                            <a href="index.php?page=delete-news&id=<?php echo $item['id']; ?>" 
                               onclick="return confirm('Supprimer cet article ?')" 
                               style="color: #e74c3c; text-decoration: none; font-weight: bold;">🗑️ Supprimer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #999; font-style: italic;">Aucun article publié pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>