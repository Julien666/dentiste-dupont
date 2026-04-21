<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    echo "<script>alert('Article introuvable'); window.location.href='index.php?page=admin-news';</script>";
    exit();
}
?>

<style>
    .edit-wrapper {
        max-width: 900px;
        margin: 60px auto;
        padding: 0 20px;
    }
    .admin-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 40px;
        border: 1px solid #eee;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #f0f0f0;
        border-radius: 10px;
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #3498db;
    }
    .current-image-container {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 10px;
    }
    .img-preview {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    .btn-save {
        background: #3498db;
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-save:hover { background: #2980b9; }
    .btn-cancel {
        background: #95a5a6;
        color: white;
        text-decoration: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: background 0.3s;
    }
    .btn-cancel:hover { background: #7f8c8d; }
</style>

<div class="edit-wrapper">
    <div style="margin-bottom: 30px;">
        <a href="index.php?page=admin-news" style="text-decoration: none; color: #7f8c8d; font-size: 0.9rem;">← Retour à la gestion</a>
        <h1 style="color: #2c3e50; margin-top: 10px;">Modifier l'article</h1>
    </div>

    <div class="admin-card">
        <form action="index.php?page=update-news-valid" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $article['id']; ?>">

            <div class="form-group">
                <label class="form-label">Titre de l'actualité</label>
                <input type="text" name="titre" class="form-control" 
                       value="<?= htmlspecialchars($article['titre']); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Contenu de l'article</label>
                <textarea name="contenu" class="form-control" rows="12" required><?= htmlspecialchars($article['contenu']); ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Illustration</label>
                
                <?php if(!empty($article['image_url'])): ?>
                    <div class="current-image-container">
                        <img src="/dentiste-dupont/public/img/news/<?= $article['image_url']; ?>" class="img-preview" alt="Aperçu">
                        <div>
                            <p style="margin: 0; font-size: 0.85rem; color: #7f8c8d;">Image actuelle :</p>
                            <p style="margin: 0; font-size: 0.8rem; font-family: monospace;"><?= $article['image_url']; ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <input type="file" name="image" accept="image/*" class="form-control">
                <p style="margin-top: 8px; font-size: 0.85rem; color: #3498db;">
                    💡 <em>Laissez vide pour conserver l'image actuelle.</em>
                </p>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save">Enregistrer les modifications</button>
                <a href="index.php?page=admin-news" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>