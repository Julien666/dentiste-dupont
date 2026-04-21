<?php
/**
 * INDEX.PHP - ROUTEUR PRINCIPAL
 */

// 1. Initialisation de la session et affichage des erreurs
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Définition des chemins (ROOT_PATH remonte d'un cran par rapport à /public)
define('ROOT_PATH', realpath(__DIR__ . '/..'));

// 3. Connexion Base de données et Modèles
require_once ROOT_PATH . '/config/db.php'; 
require_once ROOT_PATH . '/app/models/User.php';

// 4. Détermination de la page (par défaut : home)
$page = $_GET['page'] ?? 'home';

// 5. LE ROUTEUR
switch ($page) {

    // ==========================================
    // 🏠 PAGES PUBLIQUES (VITRINE)
    // ==========================================
    case 'home':
        include_once ROOT_PATH . '/app/views/home.php';
        break;

    case 'about':
        include_once ROOT_PATH . '/app/views/front/a-propos.php';
        break;

    case 'services':
        include_once ROOT_PATH . '/app/views/front/services.php';
        break;

    case 'actualites':
        include_once ROOT_PATH . '/app/views/front/actualites.php';
        break;

    // ==========================================
    // 🔐 AUTHENTIFICATION
    // ==========================================
    case 'login':
        include_once ROOT_PATH . '/app/views/login.php';
        break;

    case 'login-valid':
        require_once ROOT_PATH . '/app/controllers/AuthController.php';
        break;

    case 'register':
        include_once ROOT_PATH . '/app/views/register.php';
        break;

    case 'register-valid':
        require_once ROOT_PATH . '/app/controllers/RegisterController.php';
        break;

    case 'logout':
        require_once ROOT_PATH . '/app/controllers/LogoutController.php';
        break;

    // ==========================================
    // 🦷 ESPACE PATIENT
    // ==========================================
    case 'mes-rdv':
        include_once ROOT_PATH . '/app/views/front/mes-rdv.php';
        break;

    case 'prendre-rdv':
        include_once ROOT_PATH . '/app/views/front/prendre-rdv.php';
        break;

    case 'confirm-booking': // Action du formulaire de prise de RDV
        require_once ROOT_PATH . '/app/controllers/BookingController.php';
        break;

    case 'cancel-rdv':
        require_once ROOT_PATH . '/app/controllers/CancelAppointmentController.php';
        break;

    // ==========================================
    // 🩺 ESPACE ADMIN (DOCTEUR)
    // ==========================================
    case 'dashboard':
        include_once ROOT_PATH . '/app/views/back/dashboard.php';
        break;

    case 'patients':
        include_once ROOT_PATH . '/app/views/back/liste-patients.php';
        break;

    case 'dossier-patient':
        include_once ROOT_PATH . '/app/views/back/dossier-patient.php';
        break;

    // --- Gestion des soins ---
    case 'complete-soin':
        include_once ROOT_PATH . '/app/views/back/valider-soin.php';
        break;

    case 'confirm-soin-valid':
        require_once ROOT_PATH . '/app/controllers/ConfirmSoinController.php';
        break;

    // --- Gestion des Actualités ---
    case 'admin-news':
        include_once ROOT_PATH . '/app/views/back/admin-news.php';
        break;

    case 'add-news':
        require_once ROOT_PATH . '/app/controllers/NewsController.php';
        break;

    case 'delete-news':
        require_once ROOT_PATH . '/app/controllers/DeleteNewsController.php';
        break;

    case 'article':
        include_once ROOT_PATH . '/app/views/front/article-unique.php';
        break;  
        
    case 'edit-news':
        include_once ROOT_PATH . '/app/views/back/edit-news.php';
        break;

    case 'update-news-valid':
        require_once ROOT_PATH . '/app/controllers/UpdateNewsController.php';
        break;    

    // --- Gestion des Horaires ---
    case 'gestion-horaires':
        include_once ROOT_PATH . '/app/views/back/gestion-horaires.php';
        break;

    case 'update-horaires':
        require_once ROOT_PATH . '/app/controllers/UpdateHorairesController.php';
        break;

    // --- Gestion des Services ---
    case 'gestion-services':
        include_once ROOT_PATH . '/app/views/back/gestion-services.php';
        break;

    case 'add-service':
        require_once ROOT_PATH . '/app/controllers/AddServiceController.php';
        break;

    case 'delete-service':
        require_once ROOT_PATH . '/app/controllers/DeleteServiceController.php';
        break;

    // ==========================================
    // 🚫 ERREUR 404
    // ==========================================
    default:
        http_response_code(404);
        include_once ROOT_PATH . '/app/views/includes/header.php';
        echo "<main class='container' style='text-align:center; padding:100px;'>
                <h1>404</h1>
                <p>Oups ! La page que vous cherchez n'existe pas.</p>
                <a href='index.php?page=home' class='btn-nav'>Retour à l'accueil</a>
              </main>";
        include_once ROOT_PATH . '/app/views/includes/footer.php';
        break;
}