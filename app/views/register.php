<?php 
// 1. Inclusion du header (qui contient déjà le début du HTML et le menu)
require_once ROOT_PATH . '/app/views/includes/header.php'; 
?>

<main>
    <div class="form-container">
        <h2>Inscription Patient</h2>
        <p>Créez votre compte pour gérer vos rendez-vous.</p>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
            <p style="color: red; text-align: center;">⚠️ Cet email est déjà utilisé.</p>
        <?php endif; ?>

        <form action="index.php?page=register-valid" method="POST">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn-submit">Créer mon compte</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            Déjà un compte ? <a href="index.php?page=login">Connectez-vous ici</a>
        </p>
    </div>
</main>

<?php 
// 2. Inclusion du footer
require_once ROOT_PATH . '/app/views/includes/footer.php'; 
?>