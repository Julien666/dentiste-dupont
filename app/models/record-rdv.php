<form action="index.php?page=creer-rdv" method="POST">
    
    <label>Choisir le patient :</label>
    <select name="patient_selectionne" class="form-select" required>
        <?php
        // On récupère tous les patients pour remplir la liste
        $patients = $pdo->query("SELECT id, nom, prenom FROM users WHERE role = 'patient' ORDER BY nom ASC")->fetchAll();
        
        foreach ($patients as $p) {
            // L'utilisateur voit le NOM, mais le formulaire envoie l'ID (value)
            echo "<option value='{$p['id']}'>{$p['nom']} {$p['prenom']}</option>";
        }
        ?>
    </select>

    <label>Motif du soin :</label>
    <select name="motif" class="form-select">
        <option value="Détartrage">Détartrage</option>
        <option value="Consultation">Consultation</option>
        <option value="Prothèse">Prothèse</option>
    </select>

    <label>Date et Heure :</label>
    <input type="datetime-local" name="date_rdv" class="form-control" required>

    <button type="submit" class="btn btn-success mt-3">Enregistrer le soin</button>
</form>