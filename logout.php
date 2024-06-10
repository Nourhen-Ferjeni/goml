<?php
session_start(); // Démarre la session

// Détruit toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, détruisez également le cookie de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruit la session.
session_destroy();

// Redirige vers la page de login (ou autre page de votre choix)
header("Location: indexlog.php");
exit;
?>
