<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 
$horaires = $pdo->query("SELECT * FROM horaires ORDER BY id ASC")->fetchAll();

// Détection du jour actuel pour la mise en avant
$jours_fr = ['Sunday' => 'Dimanche', 'Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi'];
$aujourdhui = $jours_fr[date('l')];
?>

<style>
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .icon-circle {
        width: 60px; height: 60px; background: #e3f2fd; color: #3498db;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; font-size: 1.5rem; margin: 0 auto 20px;
    }
    /* Style spécial pour la ligne du jour actuel */
    .day-now {
        background-color: rgba(52, 152, 219, 0.08);
        border-radius: 10px;
        font-weight: bold;
        color: #3498db;
    }
</style>

<main>
    <section class="position-relative d-flex align-items-center" style="min-height: 70vh; background: url('/dentiste-dupont/public/img/cabinet.jpg') center/cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(44, 62, 80, 0.8) 0%, rgba(44, 62, 80, 0.2) 100%);"></div>
        <div class="container position-relative z-index-2 text-white">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">L'excellence au service de votre <span class="text-primary">sourire</span>.</h1>
                <p class="lead mb-5">Un cadre moderne pour des soins dentaires d'exception.</p>
                <a href="index.php?page=login" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow">Prendre rendez-vous</a>
            </div>
        </div>
    </section>

    <section class="container py-5 mt-n5 position-relative z-index-3">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card service-card shadow-sm p-4 h-100">
                    <div class="icon-circle">✨</div>
                    <h4>Esthétique</h4>
                    <p class="text-muted small">Blanchiment et facettes pour un sourire parfait.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm p-4 h-100">
                    <div class="icon-circle">🦷</div>
                    <h4>Implantologie</h4>
                    <p class="text-muted small">Solutions durables pour remplacer vos dents.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm p-4 h-100">
                    <div class="icon-circle">🛡️</div>
                    <h4>Prévention</h4>
                    <p class="text-muted small">Soins complets pour une hygiène irréprochable.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5 my-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-4 fw-bold">Notre Plateau Technique</h2>
                <p class="text-muted mb-4">Nous utilisons les dernières technologies pour garantir des soins sans douleur et une précision optimale.</p>
                <img src="/dentiste-dupont/public/img/clinique-interieur.jpg" class="img-fluid rounded-5 shadow" alt="Clinique">
            </div>

            <div class="col-lg-6">
                <div class="p-4 p-md-5 bg-white shadow-lg rounded-5 border border-light">
                    <h3 class="text-center mb-4">🕒 Horaires du Cabinet</h3>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <?php foreach ($horaires as $h): ?>
                                <tr class="<?php echo ($aujourdhui == $h['jour']) ? 'day-now' : ''; ?>">
                                    <td class="py-3 ps-3"><?php echo $h['jour']; ?></td>
                                    <td class="text-end py-3 pe-3">
                                        <?php if ($h['est_ferme']): ?>
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">Fermé</span>
                                        <?php else: ?>
                                            <span class="fw-medium"><?php echo date('H:i', strtotime($h['ouverture'])); ?> — <?php echo date('H:i', strtotime($h['fermeture'])); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded-4 text-center">
                        <small class="text-muted d-block">📍 12 rue de la Paix, 75000 Paris</small>
                        <strong class="text-primary">📞 01 23 45 67 89</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>