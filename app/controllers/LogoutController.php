<?php
// On ne met PAS de session_start() ici car il est déjà dans index.php

// 1. On vide toutes les variables de session
$_SESSION = array();

// 2. On détruit la session
session_destroy();

// 3. Redirection propre vers la route 'home' via l'index
header('Location: index.php?page=home');
exit();