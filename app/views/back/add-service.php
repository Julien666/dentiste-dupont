<?php
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php';
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="index.php?page=gestion-services" class="btn btn-outline-secondary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    ←
                </a>
                <h1 class="fw-bold mb-0">Nouveau Service</h1>
            </div>

            <div class="card border-0 shadow-lg rounded-5 p-4 p-md-5">
                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small uppercase">Nom du soin</label>
                        <input type="text" name="nom_service" class="form-control form-control-lg rounded-4 border-light-subtle shadow-sm" placeholder="Ex: Détartrage complet" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small uppercase">Description (Optionnel)</label>
                        <textarea name="description" class="form-control rounded-4 border-light-subtle shadow-sm" rows="3" placeholder="Détails de la prestation..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-muted small uppercase">Durée (minutes)</label>
                            <div class="input-group">
                                <input type="number" name="duree" class="form-control form-control-lg rounded-start-4 border-light-subtle shadow-sm" value="30">
                                <span class="input-group-text rounded-end-4 bg-light border-light-subtle text-muted">min</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-muted small uppercase">Tarif (€)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="prix" class="form-control form-control-lg rounded-start-4 border-light-subtle shadow-sm" placeholder="0.00">
                                <span class="input-group-text rounded-end-4 bg-light border-light-subtle text-muted">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                            Créer le service
                        </button>
                        <a href="index.php?page=gestion-services" class="btn btn-link text-muted text-decoration-none text-center">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
    .form-control:focus { border-color: #3498db; box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.1); }
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.75rem; }
</style>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>