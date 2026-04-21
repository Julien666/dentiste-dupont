<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin'); 

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// --- 1. PRÉPARATION DES DATES ---
$aujourdhui = date('Y-m-d');

// --- 2. RÉCUPÉRATION DES STATISTIQUES ---
$stmt_today = $pdo->query("SELECT COUNT(*) FROM appointments WHERE date_rdv = CURDATE() AND status = 'prévu'");
$rdv_today = $stmt_today->fetchColumn();

$stmt_patients = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'patient'");
$total_patients = $stmt_patients->fetchColumn();

// --- 3. RÉCUPÉRATION DES RDV À VENIR ---
$query = $pdo->query("SELECT a.*, u.nom, u.prenom 
                      FROM appointments a 
                      JOIN users u ON a.user_id = u.id 
                      WHERE a.status = 'prévu' 
                      ORDER BY a.date_rdv ASC, a.heure_rdv ASC LIMIT 10");
$appointments = $query->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>Bonjour Dr. Dupont</h2>
        <p>Voici un résumé de l'activité de votre cabinet.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="card" style="background: #3498db; color: white; padding: 20px; border-radius: 8px;">
            <h4>📅 Aujourd'hui</h4>
            <p style="font-size: 2rem; font-weight: bold;"><?php echo $rdv_today; ?> RDV</p>
        </div>
        <div class="card" style="background: #2ecc71; color: white; padding: 20px; border-radius: 8px;">
            <h4>👥 Patients</h4>
            <p style="font-size: 2rem; font-weight: bold;"><?php echo $total_patients; ?></p>
        </div>
        <div class="card" style="background: #f1c40f; color: white; padding: 20px; border-radius: 8px;">
            <h4>⚙️ Services</h4>
            <p style="font-size: 1rem;"><a href="index.php?page=gestion-services" style="color: white;">Gérer les prestations</a></p>
        </div>
    </div>

    <nav class="admin-nav" style="margin-bottom: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="index.php?page=patients" class="btn-submit" style="width: auto;">👥 Patients</a>
        <a href="index.php?page=gestion-services" class="btn-submit" style="width: auto; background: #9b59b6;">🦷 Services</a>
        <a href="index.php?page=gestion-news" class="btn-submit" style="width: auto; background: #e67e22;">📰 Actualités</a>
        <a href="index.php?page=gestion-horaires" class="btn-submit" style="width: auto; background: #34495e;">🕒 Horaires</a>
    </nav>

    <section class="admin-section">
        <h3>🗓️ Prochains rendez-vous</h3>
        <table class="admin-table" style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px;">Patient</th>
                    <th style="padding: 12px;">Date</th>
                    <th style="padding: 12px;">Heure</th>
                    <th style="padding: 12px;">Motif</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $rdv): ?>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo htmlspecialchars($rdv['nom'].' '.$rdv['prenom']); ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo substr($rdv['heure_rdv'], 0, 5); ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee; font-style: italic;"><?php echo htmlspecialchars($rdv['description']); ?></td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        
                        <?php if ($rdv['date_rdv'] <= $aujourdhui): ?>
                            <a href="index.php?page=valider-soin&id=<?php echo $rdv['id']; ?>" 
                               style="color: #27ae60; text-decoration: none; font-weight: bold;">
                               ✅ Valider
                            </a>
                        <?php else: ?>
                            <span style="color: #95a5a6; font-size: 0.9rem; font-style: italic;">Indisponible</span>
                        <?php endif; ?>

                        <span style="margin: 0 5px; color: #ddd;">|</span>

                        <a href="index.php?page=delete-rdv&id=<?php echo $rdv['id']; ?>" 
                           onclick="return confirm('Supprimer ?')" 
                           style="color: #e74c3c; text-decoration: none;">
                           🗑️ Supprimer
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>