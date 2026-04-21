<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 
// On récupère les horaires
$horaires = $pdo->query("SELECT * FROM horaires ORDER BY id ASC")->fetchAll();
?>

<main>
    <section class="hero" style="position: relative; background: url('public/img/cabinet.jpg') center/cover; padding: 120px 20px; text-align: center; color: white;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(44, 62, 80, 0.6); z-index: 1;"></div>
        <div style="position: relative; z-index: 2; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 3rem; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Votre sourire, notre expertise.</h1>
            <p style="font-size: 1.3rem; margin-bottom: 30px; opacity: 0.9;">Le Dr. Dupont et son équipe vous accueillent dans un cadre moderne et chaleureux pour tous vos soins dentaires.</p>
            <a href="index.php?page=prendre-rdv" style="display: inline-block; background: #3498db; color: white; padding: 18px 40px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1rem; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">📅 Prendre rendez-vous</a>
        </div>
    </section>

    <section class="container" style="max-width: 1200px; margin: 60px auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 50px; align-items: start;">
        
        <div class="about-text">
            <h2 style="color: #2c3e50; margin-bottom: 20px; border-bottom: 3px solid #3498db; display: inline-block; padding-bottom: 5px;">Le Cabinet</h2>
            <p style="line-height: 1.8; color: #555; font-size: 1.1rem;">
                Situé au centre-ville, notre établissement combine **technologies de pointe** et **approche écoresponsable**. Nous accordons une importance capitale au confort de nos patients et à la transparence des soins.
            </p>
            <div style="margin-top: 30px; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <img src="public/img/clinique-interieur.jpg" alt="Cabinet" style="width: 100%; display: block; height: auto;">
            </div>
        </div>

        <div class="hours-card" style="background: #ffffff; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
            <h3 style="text-align: center; color: #2c3e50; margin-bottom: 30px; font-size: 1.5rem;">🕒 Nos Horaires</h3>
            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php foreach ($horaires as $h): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid #f9f9f9;">
                    <span style="font-weight: 600; color: #34495e;"><?php echo $h['jour']; ?></span>
                    <span style="color: #7f8c8d; font-family: monospace; font-size: 1rem;">
                        <?php if ($h['est_ferme']): ?>
                            <span style="background: #fdeaea; color: #e74c3c; padding: 4px 10px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">FERMÉ</span>
                        <?php else: ?>
                            <?php echo date('H:i', strtotime($h['ouverture'])); ?> - <?php echo date('H:i', strtotime($h['fermeture'])); ?>
                        <?php endif; ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-top: 30px; background: #e8f4fd; padding: 15px; border-radius: 10px; text-align: center;">
                <p style="margin: 0; color: #3498db; font-size: 0.9rem;">📍 12 rue de la Paix, 75000 Paris</p>
                <p style="margin: 5px 0 0; color: #3498db; font-size: 0.9rem;">📞 01 23 45 67 89</p>
            </div>
        </div>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>