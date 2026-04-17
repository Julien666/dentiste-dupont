<?php require_once 'includes/header.php'; ?>

<main style="text-align: center; padding: 50px;">
    <h1>Bienvenue au Cabinet Dentaire</h1>
    <p>Le Dr. Dupont et son équipe vous accueillent du lundi au vendredi.</p>
    
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="index.php?page=login" class="btn-submit" style="text-decoration: none;">Prendre rendez-vous</a>
    <?php else: ?>
        <p>Bonjour <strong><?php echo $_SESSION['user_nom']; ?></strong> !</p>
    <?php endif; ?>
</main>

<?php require_once 'includes/footer.php'; ?>