<?php 
// On inclut le header qui contient notre navigation et le CSS
require_once 'includes/header.php'; 
?>

<main>
    <div class="form-container">
        <h2>Inscription Patient</h2>
        <p>Créez votre compte pour gérer vos rendez-vous.</p>

        <form action="../controllers/RegisterController.php" method="POST">
            
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" required placeholder="Votre nom">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" required placeholder="Votre prénom">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required placeholder="patient@exemple.com">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required placeholder="Choisissez un mot de passe">
            </div>

            <button type="submit" class="btn-submit">Créer mon compte</button>
        </form>
    </div>
</main>

<?php 
// On inclut le footer
require_once 'includes/footer.php'; 
?>