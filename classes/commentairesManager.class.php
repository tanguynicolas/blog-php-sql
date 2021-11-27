<?php

/**
 * La classe commentairesManager permet de gérer des commentaires créés avec la classe commentaires
 * Elle contient des fonctions en ce but.
 * 
 * @author Tanguy
 */
class commentairesManager {
    private $bdd;               // Instance de PDO
    private $_result;
    private $_message;
    private $_listCommentaires; // Instance de commentaires
    private $_getLastInsertId;
    
    
    // Constructeur
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);         
    }
    
    /**
     * Cette fonction permet de sélectionner un article en fonction de son ID.
     * @param $id
     */
    public function get($id) {
    // Requette SQL.
        $sql= 'SELECT * FROM commentaires WHERE id = :id';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    // Attribution de la valeur à l'objet commentaire.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $commentaires = new commentaires();
        $commentaires->hydrate($donnees);
    // Retour du résultat.
        return $commentaires;
    }
    
    /**
     * Cette fonction permet d'ajouter un commentaire.
     * @param $commentaires
     */
    public function addComment(commentaires $commentaires) {
    // Requette SQL.
        $sql = 'INSERT INTO commentaires '
                . '(id_article, '
                . 'email, '
                . 'pseudo, '
                . 'texte) '
                . 'VALUES ('
                . ':id_article, '
                . ':email, '
                . ':pseudo, '
                . ':texte)';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id_article', $commentaires->getId_article(), PDO::PARAM_INT);
        $req->bindValue(':email', $commentaires->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':pseudo', $commentaires->getPseudo(), PDO::PARAM_STR);
        $req->bindValue(':texte', $commentaires->getTexte(), PDO::PARAM_STR);
        $req->execute();
    // Vérifications
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
     * Cette fonction permet de lister les commentaires à afficher.
     * @param $id_article
     */
    public function getListCommentairesAAfficher($id_article) {
        $listCommentaires = [];
    // Requette SQL.
        $sql= 'SELECT * FROM commentaires WHERE id_article = :id_article';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql); // Prépare la requette en ayant effectuer la connexion au préalable
        $req->bindValue(':id_article', $id_article, PDO::PARAM_INT);
        $req->execute();
    // Boucle pour la sélection des articles à afficher.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $commentaires = new commentaires();
            $commentaires->hydrate($donnees);
            $listCommentaires[] = $commentaires;
        }
    // Retour du résultat.
        return $listCommentaires;
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

    function get_listCommentaires() {
        return $this->_listCommentaires;
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

    function set_listCommentaires($_listCommentaires) {
        $this->_listCommentaires = $_listCommentaires;
    }

    function set_getLastInsertId($_getLastInsertId) {
        $this->_getLastInsertId = $_getLastInsertId;
    }
}