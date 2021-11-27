<?php
    require_once 'config/init.conf.php';
    
    // Supprimme le cookie sid
    setcookie('sid', '', -1);

    // Notification de déconnexion
    $_SESSION['notification']['result'] = 'danger';
    $_SESSION['notification']['message'] = 'Vous êtes déconnecté.';
    
    // Renvoie vers la page index.
    header("Location: index.php");
    exit()
?>