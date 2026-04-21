<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('patient'); 

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupération des rendez-vous du patient connecté avec les infos du service
$user_id = $_SESSION['user_id'];
$query = "SELECT a.*, s.nom as service_nom, s.prix 
          FROM appointments a 
          JOIN services s ON a.service_id = s.id 
          WHERE a.user_id = ? 
          ORDER BY a.date_rdv DESC, a.heure_rdv DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$my_appointments = $stmt->fetchAll();
?>

<main class="container" style="margin-top: 30px;">
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>🗓️ Mes Rendez-vous</h2>
        <a href="index.php?page=prendre-rdv" class="btn-secondary" style="padding: 10px 20px; background: #3498db; color: white; border-radius: 5px; text-decoration: none;">+ Nouveau RDV</a>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'booked'): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            🎉 Votre rendez-vous a été enregistré avec succès ! Le Dr. Dupont vous attend avec impatience.
        </div>
    <?php endif; ?>

    <div class="appointments-list">
        <?php if (empty($my_appointments)): ?>
            <div class="card" style="padding: 40px; text-align: center; background: #f9f9f9; border: 1px dashed #ccc;">
                <p>Vous n'avez pas encore de rendez-vous programmé.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 15px;">
                <?php foreach ($my_appointments as $rdv): ?>
                    <div class="card-rdv" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid <?php echo ($rdv['date_rdv'] < date('Y-m-d')) ? '#bdc3c7' : '#2ecc71'; ?>;">
                        <div>
                            <h4 style="margin: 0; color: #2c3e50;"><?php echo htmlspecialchars($rdv['service_nom']); ?></h4>
                            <p style="margin: 5px 0; color: #7f8c8d;">
                                📅 <strong><?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?></strong> à 
                                ⏰ <strong><?php echo date('H:i', strtotime($rdv['heure_rdv'])); ?></strong>
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: block; font-weight: bold; margin-bottom: 5px;"><?php echo number_format($rdv['prix'], 2); ?> €</span>
                            <span class="badge" style="padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; background: #eee;">
                                <?php echo ucfirst($rdv['status']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>