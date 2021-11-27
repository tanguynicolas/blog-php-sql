<?php require_once 'config/init.conf.php'; ?>

<?php
    // Récupération de l'ID de l'article pour pouvoir le modifier.
    if(isset($_GET['formulaire'])){
        $idArticle = $_GET['formulaire'];
        $articlesManager = new articlesManager($bdd);
        $modifications = $articlesManager->get($idArticle);
    }

    $publie = NULL;

    // Si l'utilisateur clique sur valider.
    if(isset($_POST['save'])) {
        // Si la valeur de l'ID (en hidden) est récupérée dans le formulaire
        if($_POST['id']){
            $article = new articles();
            $article->hydrate($_POST);
            $article->setDate(date('Y-m-d'));
            $publie = $article->getPublie() === 'on' ? 1 : 0; // Condition ternaire. Si $publie = on, publie vaut 1 sinon il vaut 0.
            $article->setPublie($publie);

            // Insertion ou mise à jour de l'article.
            $articleManager = new articlesManager($bdd);
            $articleManager->update($article);

            // Traitement de l'image
            if ($_FILES['image']['error'] == 0) {
                $fileInfos = pathinfo($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], // déplace un objet du tmp vers l'endroit choisi
                'img/'.$articleManager->get_getLastInsertId(). '.' . $fileInfos['extension']);
            }
            
            // Notification
            if ($articleManager->get_result() == true) {
                $_SESSION['notification']['result'] = 'success';
                $_SESSION['notification']['message'] = 'Article bien ajouté !';
            } else {
                $_SESSION['notification']['result'] = 'danger';
                $_SESSION['notification']['message'] = 'Une erreur est survenue durant l\'ajout de l\'article';
            }
            // Renvoi vers la page index.
            header("Location: index.php");
            exit();
        // Si la valeur de l'ID (en hidden) n'est pas récupérée dans le formulaire
        } else {
            $article = new articles();
            $article->hydrate($_POST);
            $article->setDate(date('Y-m-d'));
            $publie = $article->getPublie() === 'on' ? 1 : 0; // Condition ternaire. Si $publie = on, publie vaut 1 sinon il vaut 0.
            $article->setPublie($publie);

            // Insertion ou mise à jour de l'article.
            $articleManager = new articlesManager($bdd);
            $articleManager->addArticles($article);

            // Traitement de l'image
            if ($_FILES['image']['error'] == 0) {
                $fileInfos = pathinfo($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], // déplace un objet du tmp vers l'endroit choisi
                'img/'.$articleManager->get_getLastInsertId(). '.' . $fileInfos['extension']);
            }
            // Notification
            if ($articleManager->get_result() == true) {
                $_SESSION['notification']['result'] = 'success';
                $_SESSION['notification']['message'] = 'Article bien ajouté !';
            } else {
                $_SESSION['notification']['result'] = 'danger';
                $_SESSION['notification']['message'] = 'Une erreur est survenue durant l\'ajout de l\'article';
            }
            // Renvoi vers la page index.
            header("Location: index.php");
            exit();
        }
    // Quand l'utilisateur n'a pas encore cliqué sur valider.
    } else {
        $article = new articles();
        $action = 'ajouter';
    
        // Intégration du front end via Twig
        if (isset($_GET['formulaire'])) {
            // Intégration du frontend via Twig pour la modification d'articles.
            $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
            $twig = new \Twig\Environment($loader, ['debug' => true]);
            echo $twig->render('form_articles.html.twig', ['modifications' => $modifications, 'formulaire' => $_GET['formulaire'], 'idArticle' => $idArticle, 'publie' => $publie, 'sid' => $_COOKIE['sid']]);
        } else {
            // Intégration du frontend via Twig pour la création d'artices.
            $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
            $twig = new \Twig\Environment($loader, ['debug' => true]);
            echo $twig->render('form_articles.html.twig', ['sid' => $_COOKIE['sid']]);
        }
    } ?>