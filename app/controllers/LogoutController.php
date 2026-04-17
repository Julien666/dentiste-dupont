<?php
session_start();
session_destroy(); // On détruit la session
header('Location: ../../public/index.php'); // On renvoie à l'accueil
exit();