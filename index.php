<?php
    require_once 'config/init.conf.php';
    
    // Création des objets commentaires et artcilesManager.
    $commentaires = new commentaires();    
    $articlesManager = new articlesManager($bdd);
    $commentairesManager = new commentairesManager($bdd);
    
    // Si l'utilisateur clique sur supprimer.
    if (isset($_GET['delete'])){
        $articlesManager->deleteArticles($_GET['delete']);
    }   
    
    // Déclaration de la constante du nombre d'articles par page.
    define('_nb_article_par_page_', 2);
    // Donne à $page la valeur du paramètre p présent dans l'URL après le "?".
    $page = !empty($_GET['p']) ? $_GET['p'] : 1; // Si le paramètre "p" est diffrent de vide, alors la valeur sera $_GET['p'], sinon, la valeur sera 1.
    // Calcule index de départ
    $indexDepart = ($page - 1) * _nb_article_par_page_;
    // Calacul le nombre d'artciles total à publier.
    $nbArticlesTotalAPubilier = $articlesManager->countArticlesPublie();
    // En déduit un entier pour le nombre total de pages.
    $nbPages = ceil($nbArticlesTotalAPubilier / _nb_article_par_page_);
    
    // Si l'utilisateur lance une recherche.
    if (isset($_POST['search'])){
        $listArticles=$articlesManager->search($_POST['search']);
    } else {
        $listArticles=$articlesManager->getListArticlesAAfficher($indexDepart, _nb_article_par_page_);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Header-->
    <?php include 'includes/header.inc.php';?>

    <body>
        <!-- Responsive navbar-->
        <?php include 'includes/menu.inc.php';?>
        
        <!-- Page Content-->
        <div class="container px-4 px-lg-5">
            <!-- Notification -->
            <?php if (isset($_SESSION['notification'])) { ?>
                <div class="alert alert-<?= $_SESSION['notification']['result'] ?> alert-dismissible mt-3" role="alert">
                    <?= $_SESSION['notification']['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
                    unset($_SESSION['notification']);
                }
            ?>
            
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
                
                <div class="col-12">
                    <h1 class="font-weight-light"><?php echo "Siquis enim militarium" ?></h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>   
                </div>
            </div>

        
            <!-- Content Row -->
            <!-- Articles -->
            <div class="row gx-4 gx-lg-5">
                <?php foreach ($articlesManager->get_listArticles() as $article) { ?>
                    <div class="col-md-4 mb-5">
                        <div class="card h-100">
                            <img class="card-img-top" src="img/<?= $article->getId() ?>.jpg">
                            <div class="card-body">
                                <h2 class="card-title"><font color="#77b5fe"><?= $article->getTitre() ?></font></h2>
                                <p class="card-text"><?= $article->getTexte() ?></p>
                                <!-- Commentaires-->
                                <h4 class="card-title"><font color="#77b5fe">Commentaire(s)</font></h2>
                                <?php
                                // Récupéation des commentaires associés à l'article.
                                $id_article = $article->getId();
                                $com = $commentairesManager->get($id_article);
                                $listCommentaires = $commentairesManager->getListCommentairesAAfficher($id_article);
                                // Affichage des commentaires
                                foreach ($listCommentaires as $key => $commentaire) { ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <?= $commentaire->getPseudo() ?>
                                        </div>
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-0">
                                                <p><?= $commentaire->getTexte() ?></p>
                                                <footer class="blockquote-footer"><?= $commentaire->getEmail() ?></footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- Boutons de modification, de suppression et de commentaire -->
                            <div class="card-footer">
                                <a class="btn btn-primary btn-sm" href="#!"><?= $article->getDate() ?></a>
                                <?php if(isset($_COOKIE['sid'])){?><a class="btn btn-primary btn-sm" href="form_articles.php?formulaire=<?= $article->getId(); ?>">Modifier</a><?php } ?>
                                <?php if(isset($_COOKIE['sid'])){?><a class="btn btn-primary btn-sm" href="index.php?delete=<?= $article->getId(); ?>">Supprimer</a><?php } ?>
                                <a class="btn btn-primary btn-sm mt-2" href="form_commentaires.php?formulaire=<?= $article->getId(); ?>">Commenter</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php for ($index = 1; $index <= $nbPages; $index++) { ?>
                        <li class="page-item <?php if ($page == $index) { ?>active<?php } ?>">
                        <a class="page-link" href="index.php?p=<?= $index ?>"><?= $index ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

        <!-- Footer-->
        <?php include 'includes/footer.inc.php'; ?>
    </body>
</html>