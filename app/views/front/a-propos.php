<?php require_once ROOT_PATH . '/app/views/includes/header.php'; ?>

<main class="container" style="margin-top: 50px; line-height: 1.6;">
    
    <section style="display: flex; gap: 50px; align-items: center; margin-bottom: 80px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px;">
            <img src="/dentiste-dupont/public/img/dr-dupont.jpg" alt="Portrait du Dr. Dupont" style="width: 100%; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
        </div>
        <div style="flex: 2; min-width: 300px;">
            <h2 style="color: #2c3e50; font-size: 2.5rem; margin-bottom: 20px;">Dr. Jean Dupont</h2>
            <h4 style="color: #3498db; margin-top: -10px;">Chirurgien-Dentiste & Fondateur</h4>
            <p>
                Diplômé de la Faculté d'Odontologie, le Dr. Dupont exerce depuis plus de 15 ans avec une passion constante pour l'innovation dentaire. 
                Il a fondé ce cabinet avec une vision claire : allier l'excellence technique à une approche humaine et écoresponsable des soins.
            </p>
            <h5 style="margin-bottom: 10px;">Diplômes et Qualifications :</h5>
            <ul style="padding-left: 20px;">
                <li>Doctorat en Chirurgie Dentaire</li>
                <li>D.U. d'Implantologie Orale et Maxillo-faciale</li>
                <li>Expert en Dentisterie Esthétique et Facettes</li>
            </ul>
        </div>
    </section>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 50px 0;">

    <section>
        <h2 style="text-align: center; margin-bottom: 40px;">Les membres de l'équipe</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            
            <div style="text-align: center; background: #f9f9f9; padding: 20px; border-radius: 10px;">
                <img src="/dentiste-dupont/public/img/equipe-1.jpg" alt="Sophie Martin" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px;">
                <h3 style="margin: 0;">Sophie Martin</h3>
                <p style="color: #3498db; font-weight: bold;">Assistante Dentaire</p>
                <p style="font-size: 0.9rem;">Sophie assure le confort des patients et l'assistance technique lors des interventions chirurgicales.</p>
            </div>

            <div style="text-align: center; background: #f9f9f9; padding: 20px; border-radius: 10px;">
                <img src="/dentiste-dupont/public/img/equipe-2.jpg" alt="Marc Durand" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px;">
                <h3 style="margin: 0;">Laure Durand</h3>
                <p style="color: #3498db; font-weight: bold;">Secrétaire Médical</p>
                <p style="font-size: 0.9rem;">Marc vous accueille avec le sourire et gère la coordination de vos plans de traitement.</p>
            </div>

        </div>
    </section>

    <section style="margin-top: 80px; background: #2c3e50; color: white; padding: 50px; border-radius: 15px; text-align: center;">
        <h2>Nos Valeurs</h2>
        <div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 20px; margin-top: 30px;">
            <div>
                <h3>🌱 Écoresponsabilité</h3>
                <p>Matériaux durables et gestion raisonnée des déchets.</p>
            </div>
            <div>
                <h3>🦷 Modernité</h3>
                <p>Équipements numériques de dernière génération.</p>
            </div>
            <div>
                <h3>🤝 Écoute</h3>
                <p>Un patient n'est pas un numéro, mais un partenaire.</p>
            </div>
        </div>
    </section>

</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>