<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupération des dernières actualités
$news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>

<style>
    .news-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
    }
    
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .card-news {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        border: 1px solid #f0f0f0;
    }

    .card-news:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .card-image-wrapper {
        height: 220px;
        width: 100%;
        overflow: hidden;
        background: #f8f9fa;
        position: relative;
    }

    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .date-badge {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.9);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #3498db;
    }

    .card-content {
        padding: 25px;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.25rem;
        color: #2c3e50;
        margin: 0 0 12px 0;
        line-height: 1.4;
    }

    .card-excerpt {
        color: #7f8c8d;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .btn-read-more {
        display: inline-block;
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .btn-read-more:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .empty-state {
        text-align: center;
        padding: 100px 20px;
        background: white;
        border-radius: 15px;
    }
</style>

<main class="news-container">
    <header style="text-align: center; margin-bottom: 60px;">
        <h1 style="font-size: 2.5rem; color: #2c3e50; margin-bottom: 15px;">Le Journal du Cabinet</h1>
        <div style="width: 60px; height: 4px; background: #3498db; margin: 0 auto 20px;"></div>
        <p style="color: #7f8c8d; max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            Conseils d'experts, innovations technologiques et actualités de votre cabinet dentaire.
        </p>
    </header>

    <div class="news-grid">
        <?php if (empty($news)): ?>
            <div class="empty-state" style="grid-column: 1 / -1;">
                <p style="font-size: 1.2rem; color: #95a5a6;">📅 Aucune actualité pour le moment.</p>
                <p>Revenez très bientôt pour de nouveaux conseils santé !</p>
            </div>
        <?php else: ?>
            <?php foreach ($news as $article): ?>
                <article class="card-news">
                    <div class="card-image-wrapper">
                        <?php if ($article['image_url']): ?>
                            <img src="/dentiste-dupont/public/img/news/<?php echo htmlspecialchars($article['image_url']); ?>" 
                                 alt="Image" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #bdc3c7;">
                                <span style="font-size: 3rem;">🦷</span>
                            </div>
                        <?php endif; ?>
                        <div class="date-badge">
                            <?php echo date('d M Y', strtotime($article['created_at'])); ?>
                        </div>
                    </div>

                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($article['titre']); ?></h3>
                        <p class="card-excerpt">
                            <?php 
                                $texte = strip_tags($article['contenu']);
                                echo (strlen($texte) > 120) ? substr($texte, 0, 120) . '...' : $texte; 
                            ?>
                        </p>
                        <a href="index.php?page=article&id=<?php echo $article['id']; ?>" class="btn-read-more">
                            Lire l'article complet →
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>