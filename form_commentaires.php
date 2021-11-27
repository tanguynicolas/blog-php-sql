<?php 
    require_once 'config/init.conf.php';
    
    // Récupération de l'ID de l'article pour pouvoir l'associer au commentaire.
    if(isset($_GET['formulaire'])){
        $idArticle = $_GET['formulaire'];
        $articleManager = new articlesManager($bdd);
        $article = $articleManager->get($idArticle);
    }
    
    // Quand l'utilisateur a cliqué sur publier.
    if(isset($_POST['save'])){
        $commentaire = new commentaires();
        $commentaire->hydrate($_POST);

        // Insertion ou mise à jour du commentaire.
        $commentaireManager = new commentairesManager($bdd);
        $commentaireManager->addComment($commentaire);
        
        // Notification.
        if ($commentaireManager->get_result() == true) {
                $_SESSION['notification']['result'] = 'success';
                $_SESSION['notification']['message'] = 'Commentaire bien ajouté !';
            } else {
                $_SESSION['notification']['result'] = 'danger';
                $_SESSION['notification']['message'] = 'Une erreur est survenue durant l\'ajout du commentaire';
        }
        // Redirection.
        header("Location: index.php");
        exit();
        
    // Quand l'utilisateur n'a pas encore cliqué sur publier.
    } else {
        // Intégration du frontend via Twig.
        $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
        $twig = new \Twig\Environment($loader, ['debug' => true]);
        echo $twig->render('form_commentaires.html.twig', ['article' => $article, 'sid' => $_COOKIE['sid']]);
    } ?>