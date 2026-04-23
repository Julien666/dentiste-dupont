<?php require_once ROOT_PATH . '/app/views/includes/header.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center mt-4">
        <div class="col-12 col-md-8 col-lg-6">
            
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h2 class="text-center mb-5 fw-bold">Créer un compte</h2>
                    
                    <form action="index.php?page=register-valid" method="POST">
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" name="nom" id="nom" class="form-control form-control-lg" placeholder="Dupont" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="prenom" class="form-label">Prénom :</label>
                                <input type="text" name="prenom" id="prenom" class="form-control form-control-lg" placeholder="Jean" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Adresse Email :</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="jean.dupont@mail.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mot de passe :</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">S'inscrire</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">Vous avez déjà un compte ? <a href="index.php?page=login" class="text-decoration-none">Se connecter</a></p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>