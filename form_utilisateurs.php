<?php 
    require_once 'config/init.conf.php';

    // Quand l'utilisateur clique sur valider.
    if(isset($_POST['save'])){
        $utilisateur = new utilisateurs();
        $utilisateur->hydrate($_POST);
        $utilisateur->setMdp(password_hash($utilisateur->getMdp(), PASSWORD_DEFAULT));

        // Insertion ou mise à jour de l'utilisateur.
        $utilisateurManager = new utilisateursManager($bdd);
        $utilisateurManager->addUsers($utilisateur);
        
        // Notification et redirection.
        if ($utilisateurManager->get_result() == true) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = 'Utilisateur bien ajouté !';
            header("Location: index.php");
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Une erreur est survenue durant l\'ajout de l\'utilisateur';
            header("Location: index.php");
        }
        exit();
        
    // Quand l'utilisateur n'a pas encore cliqué su valider.
    } else {
        // Intégration du frontend via Twig.
        $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
        $twig = new \Twig\Environment($loader, ['debug' => true]);
        echo $twig->render('form_utilisateurs.html.twig');
    }
?>