<?php require_once '../includes/header.php'; ?>

<main>
    <div class="form-container">
        <h2>Prendre un rendez-vous</h2>
        <p>Choisissez une date et une heure pour votre consultation.</p>

        <form action="../../controllers/AppointmentController.php" method="POST">
            <div class="form-group">
                <label for="date_rdv">Date souhaitée</label>
                <input type="date" name="date_rdv" id="date_rdv" min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label for="heure_rdv">Heure</label>
                <select name="heure_rdv" id="heure_rdv" required>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Motif (optionnel)</label>
                <textarea name="description" id="description" rows="3" placeholder="Ex: Contrôle annuel, détartrage..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Confirmer le rendez-vous</button>
        </form>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>