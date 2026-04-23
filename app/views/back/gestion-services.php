<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

$services = $pdo->query("SELECT * FROM services ORDER BY nom ASC")->fetchAll();
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold">⚙️ Gestion des Services</h1>
            <p class="text-muted">Configurez les prestations et les tarifs de votre cabinet.</p>
        </div>
        <div class="text-end">
            <a href="index.php?page=add-service" class="btn btn-primary rounded-pill px-4 shadow-sm">
                + Nouveau Service
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
        <div class="bg-white p-4 border-bottom">
            <h4 class="fw-bold mb-0">Catalogue des soins</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">NOM DU SOIN / DESCRIPTION</th>
                        <th>DURÉE ESTIMÉE</th>
                        <th>TARIF</th>
                        <th class="text-end pe-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($services)): ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">Aucun service configuré.</td></tr>
                    <?php else: ?>
                        <?php foreach ($services as $s): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($s['nom'] ?? 'Sans nom'); ?></div>
                                <?php if (!empty($s['description'])): ?>
                                    <div class="text-muted small italic" style="max-width: 300px;"><?php echo htmlspecialchars($s['description']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark rounded-pill border">
                                    <i class="far fa-clock me-1"></i> 
                                    <?= htmlspecialchars($s['duree_minutes'] ?? 0); ?> min
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">
                                    <?php echo number_format((float)($s['prix'] ?? 0), 2); ?> €
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="index.php?page=edit-service&id=<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Modifier</a>
                                <a href="index.php?page=delete-service&id=<?php echo $s['id']; ?>" onclick="return confirm('Supprimer ce service ?')" class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-2">🗑️</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<style>
.table-hover tbody tr:hover { background-color: rgba(52, 152, 219, 0.02); transition: background-color 0.2s ease; }
.italic { font-style: italic; }
</style>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>