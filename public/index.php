<?php
// 1. Initialisation globale
session_start();

// Affichage des erreurs pour le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Définition du chemin racine du projet (plus sûr)
define('ROOT_PATH', realpath(__DIR__ . '/../'));

// 3. Chargement de la base de données et des Modèles
require_once ROOT_PATH . '/config/db.php'; 
require_once ROOT_PATH . '/app/models/User.php';

// 4. Détermination de la page
$page = $_GET['page'] ?? 'home';

// 5. Le Routeur en IF/ELSE
if ($page === 'home') {
    include_once ROOT_PATH . '/app/views/home.php';
} 
else if ($page === 'login') {
    include_once ROOT_PATH . '/app/views/login.php';
} 
else if ($page === 'register') {
    include_once ROOT_PATH . '/app/views/register.php';
} 
// --- ACTIONS DE FORMULAIRES ---
else if ($page === 'login-valid') {
    require_once ROOT_PATH . '/app/controllers/AuthController.php';
} 
else if ($page === 'register-valid') {
    require_once ROOT_PATH . '/app/controllers/RegisterController.php';
} 
else if ($page === 'logout') {
    require_once ROOT_PATH . '/app/controllers/LogoutController.php';
} 
// --- PARTIE PATIENT ---
else if ($page === 'mes-rdv') {
    include_once ROOT_PATH . '/app/views/front/mes-rdv.php';
} 
else if ($page === 'prendre-rdv') {
    include_once ROOT_PATH . '/app/views/front/prendre-rdv.php';
} 
else if ($page === 'rdv-valid') {
    require_once ROOT_PATH . '/app/controllers/AppointmentController.php';
} 
else if ($page === 'dossier-patient') {
    include_once ROOT_PATH . '/app/views/back/dossier-patient.php';
}
else if ($page === 'cancel-rdv') {
    require_once ROOT_PATH . '/app/controllers/CancelAppointmentController.php';
}
// --- PARTIE ADMIN ---
else if ($page === 'dashboard') {
    include_once ROOT_PATH . '/app/views/back/dashboard.php';
} 
else if ($page === 'patients') {
    include_once ROOT_PATH . '/app/views/back/liste-patients.php';
}
else if ($page === 'valider-soin') {
    include_once ROOT_PATH . '/app/views/back/valider-soin.php';
}
else if ($page === 'delete-rdv') {
    require_once ROOT_PATH . '/app/controllers/AdminDeleteRDV.php';
} 
// --- CAS PAR DÉFAUT (404) ---
else {
    http_response_code(404);
    echo "<h1>404 - Page non trouvée</h1>";
    echo "<a href='index.php?page=home'>Retour à l'accueil</a>";
}