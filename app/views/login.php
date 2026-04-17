<?php require_once 'includes/header.php'; ?>

<main>
    <div class="form-container">
        <h2 style="text-align: center; color: var(--dark-navy);">Connexion</h2>

        <?php if (isset($_GET['error'])): ?>
            <div style="background-color: #fce4e4; border: 1px solid #fcc2c2; color: #cc0033; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                ❌ Email ou mot de passe incorrect.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div style="background-color: #e6fffa; border: 1px solid #b2f5ea; color: #2c7a7b; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                ✅ Inscription réussie ! Connectez-vous.
            </div>
        <?php endif; ?>

        <form action="../controllers/AuthController.php" method="POST">
            <div class="form-group">
                <label for="email">Votre Email</label>
                <input type="email" name="email" id="email" required placeholder="exemple@mail.com">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">Se connecter au cabinet</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Nouveau patient ? <a href="register.php" style="color: var(--medical-blue); font-weight: bold;">Créer un compte</a>
        </p>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>