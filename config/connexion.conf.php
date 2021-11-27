<?php 
    if (!empty($_COOKIE['sid'])){                               // Si $_COOKIE['sid'] est différent de vide
        $donnees = $_COOKIE['sid'];                             // On stock dans $donnees la valeur de sid dans le tableau $_COOKIE
        $utilisateurManager = new utilisateursManager($bdd);    // On effectue la connexion à la base de donnée
        $sidBDD = $utilisateurManager->getBySid($donnees);      // On utilise la fonction getBySid pour vérifier que le sid actuel est le même qu'en BDD, si c'est le cas, on stock le sid dans $sidBDD
    }
?>