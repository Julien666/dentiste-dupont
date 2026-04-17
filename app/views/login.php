<?php require_once ROOT_PATH . '/app/views/includes/header.php'; ?>

<main>
    <div class="form-container">
        <h2>Connexion</h2>
        <form action="index.php?page=login-valid" method="POST">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>