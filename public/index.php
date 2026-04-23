<?php
/**
 * CABINET DENTAIRE DUPONT - ROUTEUR PRINCIPAL
 */

// --- 1. CONFIGURATION ET SECURITE ---
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_PATH', realpath(__DIR__ . '/..'));

// Connexion DB et Modèles
require_once ROOT_PATH . '/config/db.php'; 
require_once ROOT_PATH . '/app/models/User.php';

// Détermination de la page
$page = $_GET['page'] ?? 'home';


// --- 2. LOGIQUE DE ROUTAGE ---
switch ($page) {

    // ==========================================
    // 🏠 VITRINE (PAGES PUBLIQUES)
    // ==========================================
    case 'home':      require_once ROOT_PATH . '/app/views/home.php';break;
    case 'about':     include_once ROOT_PATH . '/app/views/front/a-propos.php'; break;
    case 'services':  include_once ROOT_PATH . '/app/views/front/services.php'; break;
    case 'actualites':include_once ROOT_PATH . '/app/views/front/actualites.php';break;
    case 'article':   include_once ROOT_PATH . '/app/views/front/article-unique.php'; break;

    // ==========================================
    // 🔐 AUTHENTIFICATION
    // ==========================================
    case 'login':          include_once ROOT_PATH . '/app/views/login.php'; break;
    case 'register':       include_once ROOT_PATH . '/app/views/register.php'; break;
    
    // Traitements (Controllers)
    case 'login-valid':    require_once ROOT_PATH . '/app/controllers/AuthController.php'; break;
    case 'register-valid': require_once ROOT_PATH . '/app/controllers/RegisterController.php'; break;
    case 'logout':         require_once ROOT_PATH . '/app/controllers/LogoutController.php'; break;

    // ==========================================
    // 🦷 ESPACE PATIENT
    // ==========================================
    case 'profil':         include_once ROOT_PATH . '/app/views/profil.php'; break;
    case 'mes-rdv':        require_once ROOT_PATH . '/app/views/front/mes-rdv.php'; break;
    case 'prendre-rdv':    require_once ROOT_PATH . '/app/views/front/prendre-rdv.php'; break;
    case 'rdv-valid':      require_once ROOT_PATH . '/app/controllers/RdvController.php'; break;
   
    // Traitements Patient
    case 'profil-update':  require_once ROOT_PATH . '/app/controllers/profil-update.php'; break;
    case 'confirm-booking':require_once ROOT_PATH . '/app/controllers/BookingController.php'; break;
    case 'rdv-cancel':     require_once ROOT_PATH . '/app/controllers/RdvController.php'; break;

    // ==========================================
    // 🩺 ESPACE ADMIN (BACK-OFFICE)
    // ==========================================
    case 'dashboard':        include_once ROOT_PATH . '/app/views/back/dashboard.php'; break;
    case 'patients':         include_once ROOT_PATH . '/app/views/back/liste-patients.php'; break;
    case 'dossier-patient':  include_once ROOT_PATH . '/app/views/back/dossier-patient.php'; break;
    case 'gestion-patients': include_once ROOT_PATH . '/app/views/back/liste-patients.php'; break;
    case 'gestion-horaires': include_once ROOT_PATH . '/app/views/back/gestion-horaires.php'; break;
    case 'gestion-services': include_once ROOT_PATH . '/app/views/back/gestion-services.php'; break;
    case 'admin-news':       include_once ROOT_PATH . '/app/views/back/admin-news.php'; break;
    case 'gestion-news':     include_once ROOT_PATH . '/app/views/back/admin-news.php'; break; 
    case 'edit-news':        include_once ROOT_PATH . '/app/views/back/edit-news.php'; break;
    case 'edit-service':     include_once ROOT_PATH . '/app/views/back/edit-service.php'; break;
    case 'valider-soin':     include_once ROOT_PATH . '/app/views/back/valider-soin.php'; break;

    // Traitements Admin
    case 'add-news':           require_once ROOT_PATH . '/app/controllers/NewsController.php'; break;
    case 'update-news-valid':  require_once ROOT_PATH . '/app/controllers/UpdateNewsController.php'; break;
    case 'delete-news':        require_once ROOT_PATH . '/app/controllers/DeleteNewsController.php'; break;
    case 'confirm-soin-valid': require_once ROOT_PATH . '/app/controllers/ConfirmSoinController.php'; break;
    case 'update-horaires':    require_once ROOT_PATH . '/app/controllers/UpdateHorairesController.php'; break;
    case 'add-service':        require_once ROOT_PATH . '/app/controllers/AddServiceController.php'; break;
    case 'update-service':     require_once ROOT_PATH . '/app/controllers/UpdateServiceController.php'; break;   
    case 'delete-service':     require_once ROOT_PATH . '/app/controllers/DeleteServiceController.php'; break;
    case 'delete-rdv':         require_once ROOT_PATH . '/app/controllers/RdvController.php'; break;
    case 'delete-patient':     require_once ROOT_PATH . '/app/controllers/DeletePatientController.php'; break;

    // ==========================================
    // 🚫 ERREUR 404
    // ==========================================
    default:
        render_404();
        break;
}

/**
 * Fonction simple pour afficher la page 404
 */
function render_404() {
    http_response_code(404);
    require_once ROOT_PATH . '/app/views/includes/header.php';
    echo "
    <main class='container py-5 text-center' style='min-height: 60vh;'>
        <div class='py-5'>
            <h1 class='display-1 fw-bold text-primary'>404</h1>
            <h2 class='mb-4'>Oups ! Cette page n'existe pas.</h2>
            <p class='text-muted mb-5'>Le Dr. Dupont est peut-être en train de soigner cette page...</p>
            <a href='index.php?page=home' class='btn btn-primary btn-lg rounded-pill px-5'>Retour à l'accueil</a>
        </div>
    </main>";
    require_once ROOT_PATH . '/app/views/includes/footer.php';
}