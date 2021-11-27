<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="#!">Mon blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Affichage contextuel des boutons de publication, déconnexion, d'inscription et de connexion -->
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Accueil</a></li>
                <?php if(isset($_COOKIE['sid'])){?>
                    <li class="nav-item"><a class="nav-link" href="form_articles.php">Publication</a></li>
                    <li class="nav-item"><a class="nav-link" href="deconnexion.conf.php">Déconnexion</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="form_utilisateurs.php">S'inscrire</a></li>
                    <li class="nav-item"><a class="nav-link" href="form_connexion.php">Connexion</a></li>
                <?php } ?>
                <form method="POST" id="searchForm" action="index.php" enctype="multipart/form-data">
                    <input name="search" id="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </ul>
        </div>
    </div>
</nav>