<?php require_once ROOT_PATH . '/app/views/includes/header.php'; ?>

<main class="container py-5">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-5">Connexion</h2>
                    
                    <form action="index.php?page=login-valid" method="POST">
                        <div class="mb-5">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="exemple@mail.com" required>
                        </div>
                        
                        <div class="mb-5">
                            <label for="password" class="form-label">Mot de passe :</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
            <p class="text-center mt-3 small">
                Pas encore de compte ? <a href="index.php?page=register">S'inscrire</a>
            </p>
            
        </div>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>