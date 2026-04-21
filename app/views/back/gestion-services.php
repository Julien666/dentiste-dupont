<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupérer les services existants
$services = $pdo->query("SELECT * FROM services ORDER BY nom ASC")->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>🦷 Gestion des Services</h2>
        <p>Gérez les prestations proposées par le cabinet.</p>
    </div>

    <section class="admin-section">
        <?php if (isset($_GET['success'])): ?>
            <p style="color: #27ae60; background: #eafaf1; padding: 10px; border-radius: 5px;">✅ Service ajouté avec succès !</p>
        <?php endif; ?>

        <div class="card" style="padding: 20px; margin-bottom: 30px; background: #f4f7f6; border-radius: 8px;">
            <h4>Ajouter un nouveau service</h4>
            <form action="index.php?page=add-service" method="POST" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 2;">
                    <label style="display:block; font-size: 0.8rem;">Nom du soin</label>
                    <input type="text" name="nom_service" placeholder="Ex: Détartrage" required style="width: 100%; padding: 8px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-size: 0.8rem;">Prix (€)</label>
                    <input type="number" name="prix" placeholder="0.00" step="0.01" required style="width: 100%; padding: 8px;">
                </div>
                <div style="flex: 1;">
                    <label style="display:block; font-size: 0.8rem;">Durée (min)</label>
                    <input type="number" name="duree" value="30" style="width: 100%; padding: 8px;">
                </div>
                <button type="submit" class="btn-submit" style="width: auto; height: 38px;">➕ Ajouter</button>
            </form>
        </div>

        <table class="admin-table" style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px; text-align: left;">Nom</th>
                    <th style="padding: 12px; text-align: left;">Prix</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($services)): ?>
                    <tr>
                        <td colspan="3" style="padding: 20px; text-align: center; color: #7f8c8d;">Aucun service enregistré pour le moment.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($services as $s): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;"><strong><?php echo htmlspecialchars($s['nom']); ?></strong></td>
                        <td style="padding: 12px;"><?php echo number_format($s['prix'], 2); ?> €</td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="index.php?page=delete-service&id=<?php echo $s['id']; ?>" 
                               onclick="return confirm('Supprimer ce service ?')" 
                               style="color: #e74c3c; text-decoration: none; font-weight: bold;">
                               🗑️ Supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>