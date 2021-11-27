<?php

/**
 * La classe articlesManager permet de gérer les articles créés avec la classe articles.
 * Elle contient des fonctions en ce but.
 * 
 * @author Tanguy
 */
class articlesManager {
    private $bdd;               // Instance de PDO
    private $_result;
    private $_message;
    private $_listArticles;     // Instance de articles
    private $_getLastInsertId;
    
    
    // Constructeur
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);         
    }
    
    /**
     * Cette fonction permet d'de compter les articles publiés.
     * Elle est utilisée pour l'affichage d'un n nombre d'article sur la page d'accueil.
     */
    public function countArticlesPublie() {
        $sql = 'SELECT COUNT(*) as total FROM articles';
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }
    
    /**
     * Cette fonction permet de compter les articles publiés.
     * Elle est utilisée pour l'affichage d'un n nombre d'article sur la page d'accueil.
     */
    public function getListArticlesAAfficher($depart, $limite) {
        $listArticles = [];
    // Requette SQL.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles '
                . 'LIMIT :depart, :limite';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limite', $limite, PDO::PARAM_INT);
        $req->execute();
    // Boucle pour la sélection des articles à afficher.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticles[] = $articles;
        }
    // Attribution de la valeur au tableau.
        $this->_listArticles=$listArticles;
    }
    
    /**
     * Cette fonction permet d'ajouter des articles.
     * @param $articles
     */
    public function addArticles(articles $articles) {
    // Requette SQL.
        $sql = 'INSERT INTO articles '
                . '(titre, '
                . 'texte, '
                . 'date, '
                . 'publie) '
                . 'VALUES ('
                . ':titre, '
                . ':texte, '
                . ':date, '
                . ':publie)';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql); // Prépare la requette en ayant effectuer la connexion au préalable
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':date', $articles->getDate(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);
        $req->execute();
    // Vérification.
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
    // Retour du résultat.
        return $this;
    }
    
    /**
     * Cette fonction permet de mettre à jour des articles.
     * @param $articles
     */
    public function update(articles $articles) {
    // Requette SQL.
        $sql = 'UPDATE articles SET '
                . 'titre = :titre, '
                . 'texte = :texte, '
                . 'publie = :publie, '
                . 'id = :id '
                . 'WHERE id = :id';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_INT);
        $req->execute();
    // Vérification.
        if ($req->errorCode() == 00000) {
            $this->_result = true;
        } else {
            $this->_result = false;
        }
    // Retour du résultat.
        return $this;
    }
    
    /**
     * Cette fonction permet de récupérer l'ID d'un article en BDD.
     * @param $id
     */
    public function get($id) {
    // Requette SQL.
        $sql = 'SELECT * from articles WHERE id = :id';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    // Attribution de la valeur à l'objet article.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $articles = new articles();
        $articles->hydrate($donnees);
    // Retour du résultat.
        return $articles;
    }
    
    /**
     * Cette fonction permet de supprimer un article et ses commentaires associés.
     * @param $id
     */
    public function deleteArticles($id) {
    // Requette SQL.
        $sql = 'DELETE articles, commentaires FROM articles '
                . 'LEFT JOIN commentaires '
                . 'ON articles.id = commentaires.id_article '
                . 'WHERE articles.id = :id';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }
    
    /**
     * Cette fonction permet de supprimer un article.
     * @param $recherche
     */
    public function search($recherche) {
        $listArticle = [];
    // Requette SQL.
        $sql = 'SELECT * FROM articles '
                . 'WHERE publie = 1 '
                . 'AND (titre LIKE \'%'.$recherche.'%\' '
                . 'OR texte LIKE \'%'.$recherche.'%\')';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':recherche', $recherche, PDO::PARAM_STR);
        $req->execute();
    // Boucle pour la sélection des articles à afficher.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            // On crée des objets avec les données issus de la table.
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;            
        }
    // Attribution de la valeur au tableau.
        $this->_listArticles=$listArticle;
    }

    // Getters & Setters
    function getBdd() {
        return $this->bdd;
    }

    function get_result() {
        return $this->_result;
    }

    function get_message() {
        return $this->_message;
    }

    function get_listArticles() {
        return $this->_listArticles;
    }

    function get_getLastInsertId() {
        return $this->_getLastInsertId;
    }

    function setBdd($bdd) {
        $this->bdd = $bdd;
    }

    function set_result($_result) {
        $this->_result = $_result;
    }

    function set_message($_message) {
        $this->_message = $_message;
    }

    function set_listArticles($_listArticles) {
        $this->_listArticles = $_listArticles;
    }

    function set_getLastInsertId($_getLastInsertId) {
        $this->_getLastInsertId = $_getLastInsertId;
    }   
}