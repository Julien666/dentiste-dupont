<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 1. Récupération des services
$stmt_services = $pdo->query("SELECT id, nom, duree_minutes FROM services ORDER BY nom ASC");
$services_list = $stmt_services->fetchAll(PDO::FETCH_ASSOC);

// 2. Paramètres des créneaux
$debut = "09:00";
$fin = "18:00";
$pas_affichage = 30; 

$date_selectionnee = $_GET['date'] ?? null;
$motif_selectionne = $_GET['motif'] ?? null;
$rdvs_existants = [];

if ($date_selectionnee) {
    // On récupère les RDV avec leur heure de début et de fin calculée
    $sql = "SELECT 
                DATE_FORMAT(r.date, '%H:%i') as heure_debut, 
                DATE_FORMAT(DATE_ADD(r.date, INTERVAL s.duree_minutes MINUTE), '%H:%i') as heure_fin
            FROM rendez_vous r
            JOIN services s ON r.id_acte = s.id
            WHERE DATE(r.date) = ? AND r.statut != 'annulé'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$date_selectionnee]);
    $rdvs_existants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main class="container py-5">
    <div class="row justify-content-center py-4">
        <div class="col-lg-11">
            
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark">Prendre rendez-vous</h1>
                <p class="lead text-muted">Choisissez votre soin et votre créneau horaire.</p>
            </div>

            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="row g-0">
                    
                    <div class="col-md-4 bg-primary text-white p-5 d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-4">Infos pratiques</h4>
                        <ul class="list-unstyled">
                            <li class="mb-4 d-flex align-items-start">
                                <span class="me-3">🕒</span>
                                <div><strong>Durée garantie</strong><br><small class="opacity-75">Le système réserve automatiquement la durée nécessaire pour votre soin.</small></div>
                            </li>
                            <li class="mb-4 d-flex align-items-start">
                                <span class="me-3">✅</span>
                                <div><strong>Confirmation</strong><br><small class="opacity-75">Votre rendez-vous est confirmé instantanément après validation.</small></div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-8 p-5 bg-white">
                        <form action="index.php?page=rdv-valid" method="POST">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">1. Motif de consultation</label>
                                    <select name="motif" id="motif_select" class="form-select border-light bg-light rounded-3" required>
                                        <option value="" selected disabled>Quel est l'objet de votre visite ?</option>
                                        <?php foreach($services_list as $s): ?>
                                            <option value="<?= $s['id'] ?>" 
                                                <?= ($motif_selectionne == $s['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($s['nom']) ?> (⏳ <?= $s['duree_minutes'] ?> min)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">2. Date du rendez-vous</label>
                                    <input type="date" name="date_rdv" id="date_rdv" 
                                           class="form-control border-light bg-light rounded-3" 
                                           min="<?= date('Y-m-d') ?>" 
                                           value="<?= htmlspecialchars($date_selectionnee) ?>" required>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">3. Heure disponible</label>
                                    <div class="d-flex flex-wrap gap-2" id="container-creneaux">
                                        <?php if (!$date_selectionnee): ?>
                                            <div class="alert alert-info w-100 border-0 rounded-4">
                                                👋 Veuillez d'abord choisir une date.
                                            </div>
                                        <?php else: ?>
                                            <?php 
                                            // DETERMINATION DE LA DURÉE DU SOIN CHOISI
                                            $duree_soin_choisi = 30; 
                                            if ($motif_selectionne) {
                                                foreach($services_list as $s) {
                                                    if($s['id'] == $motif_selectionne) {
                                                        $duree_soin_choisi = (int)$s['duree_minutes'];
                                                        break;
                                                    }
                                                }
                                            }

                                            $current = strtotime($debut);
                                            $end = strtotime($fin);

                                            while ($current < $end): 
                                                $time_str = date("H:i", $current);
                                                // Calcul de la fin théorique pour ce créneau
                                                $timestamp_fin_potentielle = strtotime("+$duree_soin_choisi minutes", $current);
                                                $time_fin_potentielle = date("H:i", $timestamp_fin_potentielle);
                                                
                                                $est_occupe = false;

                                                foreach ($rdvs_existants as $rdv) {
                                                    // Règle d'or du chevauchement :
                                                    // (Nouveau_Début < Existant_Fin) ET (Nouveau_Fin > Existant_Début)
                                                    if ($time_str < $rdv['heure_fin'] && $time_fin_potentielle > $rdv['heure_debut']) {
                                                        $est_occupe = true;
                                                        break;
                                                    }
                                                }

                                                // Empêcher de déborder sur l'heure de fermeture du cabinet
                                                if ($timestamp_fin_potentielle > strtotime($fin)) {
                                                    $est_occupe = true;
                                                }
                                            ?>
                                                <input type="radio" class="btn-check" name="heure_rdv" 
                                                       id="time_<?= $time_str ?>" value="<?= $time_str ?>" 
                                                       required <?= $est_occupe ? 'disabled' : '' ?>>
                                                
                                                <label class="btn <?= $est_occupe ? 'btn-light text-decoration-line-through opacity-50' : 'btn-outline-primary' ?> rounded-pill px-3" 
                                                       for="time_<?= $time_str ?>">
                                                    <?= $time_str ?>
                                                </label>
                                            <?php 
                                                $current = strtotime("+$pas_affichage minutes", $current);
                                            endwhile; 
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm" <?= !$date_selectionnee ? 'disabled' : '' ?>>
                                    Confirmer mon rendez-vous
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Amélioration du script pour recharger avec date ET motif
function updateSelection() {
    const date = document.getElementById('date_rdv').value;
    const motif = document.getElementById('motif_select').value;
    if(date) {
        window.location.href = "index.php?page=prendre-rdv&date=" + date + (motif ? "&motif=" + motif : "");
    }
}

document.getElementById('date_rdv').addEventListener('change', updateSelection);
document.getElementById('motif_select').addEventListener('change', updateSelection);
</script>

<style>
    /* Votre style reste identique pour ne pas casser le visuel */
    .btn-check:checked + .btn-outline-primary {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
        transform: scale(1.1);
    }
    .btn-outline-primary {
        transition: all 0.2s;
        border: 1px solid #dee2e6;
        color: #495057;
    }
    .btn-light.text-decoration-line-through {
        background: #f8f9fa;
        border-color: #eee;
        color: #adb5bd;
        cursor: not-allowed;
    }
</style>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>