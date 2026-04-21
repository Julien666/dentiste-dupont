<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupérer les horaires
$horaires = $pdo->query("SELECT * FROM horaires ORDER BY id ASC")->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>🕒 Gestion des Horaires</h2>
    </div>
    <section class="admin-section">
        <form action="index.php?page=update-horaires" method="POST" class="card" style="padding: 20px; background: white;">
            <table>
                <?php foreach ($horaires as $h): ?>
                <tr>
                    <td><?php echo $h['jour']; ?></td>
                    <td><input type="time" name="ouverture[<?php echo $h['id']; ?>]" value="<?php echo $h['ouverture']; ?>"></td>
                    <td><input type="time" name="fermeture[<?php echo $h['id']; ?>]" value="<?php echo $h['fermeture']; ?>"></td>
                    <td><input type="checkbox" name="est_ferme[<?php echo $h['id']; ?>]" <?php echo $h['est_ferme'] ? 'checked' : ''; ?>> Fermé</td>
                </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit" class="btn-submit">Enregistrer</button>
        </form>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>