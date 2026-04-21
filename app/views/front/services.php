<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupération dynamique des services
$services = $pdo->query("SELECT * FROM services ORDER BY nom ASC")->fetchAll();
?>

<main class="container" style="margin-top: 50px;">
    <h2 style="text-align: center;">Nos Soins et Expertises</h2>
    <p style="text-align: center; color: #666; margin-bottom: 40px;">Découvrez l'éventail des prestations proposées par le Dr. Dupont.</p>

    <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        <?php foreach ($services as $s): ?>
            <div class="card-service" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid #3498db;">
                <h3 style="color: #2c3e50; margin-top: 0;"><?php echo htmlspecialchars($s['nom']); ?></h3>
                <p style="color: #7f8c8d; line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($s['description'] ?? 'Détails du soin sur demande au cabinet.')); ?>
                </p>
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: bold; color: #2ecc71; font-size: 1.2rem;"><?php echo number_format($s['prix'], 2); ?> €</span>
                    <span style="font-size: 0.9rem; color: #95a5a6;">⏳ ~<?php echo $s['duree_minutes']; ?> min</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>