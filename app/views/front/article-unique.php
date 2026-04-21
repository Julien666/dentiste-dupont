<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// On récupère l'ID depuis l'URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php?page=actualites');
    exit();
}

// On cherche l'article précis
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

// Si l'article n'existe pas en BDD
if (!$article) {
    echo "<p style='text-align:center; padding:50px;'>L'article demandé n'existe pas.</p>";
    include_once ROOT_PATH . '/app/views/includes/footer.php';
    exit();
}
?>

<main class="container" style="max-width: 800px; margin: 60px auto; padding: 0 20px;">
    <a href="index.php?page=actualites" style="text-decoration: none; color: #3498db; font-weight: bold;">← Retour aux actualités</a>

    <article style="margin-top: 30px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        
        <span style="color: #3498db; font-weight: bold; font-size: 0.9rem;">
            📅 Publié le <?php echo date('d/m/Y', strtotime($article['created_at'])); ?>
        </span>
        
        <h1 style="color: #2c3e50; font-size: 2.5rem; margin: 15px 0 30px 0; line-height: 1.2;">
            <?php echo htmlspecialchars($article['titre']); ?>
        </h1>

        <?php if ($article['image_url']): ?>
            <div style="width: 100%; height: 400px; overflow: hidden; border-radius: 10px; margin-bottom: 30px;">
                <img src="/dentiste-dupont/public/img/news/<?php echo htmlspecialchars($article['image_url']); ?>" 
                    alt="Image" 
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        <?php endif; ?>

        <div style="color: #2c3e50; font-size: 1.15rem; line-height: 1.8; white-space: pre-line;">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>
    </article>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>