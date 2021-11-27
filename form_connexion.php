<?php 
    require_once 'config/init.conf.php';

    // Si l'utilisateur a cliqué sur connexion.
    if(isset($_POST['save'])){
        
        $utilisateur = new utilisateurs();
        $utilisateur->hydrate($_POST);

        // Recherche de l'utilisateur en BDD.
        $utilisateurManager = new utilisateursManager($bdd);
        $utilisateurEnBdd = $utilisateurManager->getByEmail($utilisateur->getEmail());
        // Vérifie son mot de passe.
        $isConnect = password_verify($utilisateur->getMdp(), $utilisateurEnBdd->getMdp());

        // Si l'utilisateur est connecté.
        if ($isConnect == true){
            $sid = sha1($utilisateur->getEmail() . time());
            // Création du cookie.
            setcookie('sid', $sid, time() + 86400);
            // Mise en BDD du SID.
            $utilisateur->setSid($sid);
            $utilisateurManager->updateByEmail($utilisateur);
        }

        // Notification et redirection.
        if ($isConnect == true) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = 'Vous êtes connecté !';
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = 'Une erreur est survenue durant la connexion';
            header("Location: form_connexion.php");
            exit();
        }
    }

    else {
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
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">     
                <div class="col-12">
                    <h1 class="font-weight-light">Connecte-toi !</h1>
                    <p>Connecte-toi pour accéder à du contenu exclusif.</p>
                </div>
            </div>
            
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
            
            <!-- Formulaire de connexion -->
            <form method=POST id="articleForm" action="form_connexion.php" enctype="multipart/form-data">
                <!-- E-Mail -->
                <div class="mb-3">
                    <label for="exampleInputTitlle" class="form-label">E-mail</label>
                    <input name='email' type="email" class="form-control" id="exampleInputTitle" aria-describedby="titleHelp">  
                </div>
                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="exampleInputTitlle" class="form-label">Mot de passe</label>
                    <input name='mdp' type="password" class="form-control" id="exampleInputTitle" aria-describedby="titleHelp">  
                </div>                
                <!-- Bouton submit -->
                <div class="col-12 mb-3">
                    <button name='save' class="btn btn-primary" type="submit">Connexion</button>
                </div>
            </form>
        </div>

        <!-- Footer-->
        <?php include 'includes/footer.inc.php'; ?>
    </body>
</html>

<?php } ?>