<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin'); 

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupération de l'ID du patient depuis l'URL
$patient_id = $_GET['id'] ?? null;

if (!$patient_id) {
    die("ID du patient manquant.");
}

// 1. Récupérer les infos du patient
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND role = 'patient'");
$stmt->execute([$patient_id]);
$patient = $stmt->fetch();

// 2. Récupérer son historique médical (rendez-vous passés)
$stmt_hist = $pdo->prepare("SELECT * FROM appointments WHERE user_id = ? ORDER BY date_rdv DESC");
$stmt_hist->execute([$patient_id]);
$historique = $stmt_hist->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>Dossier Patient : <?php echo htmlspecialchars($patient['nom'] . ' ' . $patient['prenom']); ?></h2>
        <p>Email : <?php echo htmlspecialchars($patient['email']); ?></p>
    </div>

    <section class="admin-section">
        <h3>📜 Historique des consultations</h3>
        <table class="admin-table" style="width: 100%; border-collapse: collapse; background: white; margin-top: 15px;">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 10px;">Date</th>
                    <th style="padding: 10px;">Heure</th>
                    <th style="padding: 10px;">Motif initial</th>
                    <th style="padding: 10px;">Soin effectué (Notes)</th>
                    <th style="padding: 10px;">Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historique as $h): ?>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo date('d/m/Y', strtotime($h['date_rdv'])); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo substr($h['heure_rdv'], 0, 5); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;"><?php echo htmlspecialchars($h['description']); ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">
                            <strong><?php echo htmlspecialchars($h['notes_soin'] ?? 'Aucune note'); ?></strong>
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">
                            <span class="badge" style="padding: 5px; border-radius: 4px; background: <?php echo ($h['status'] == 'effectué') ? '#d4edda' : '#fff3cd'; ?>">
                                <?php echo $h['status']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <br>
        <a href="index.php?page=patients" style="text-decoration: none;">← Retour à la liste</a>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>