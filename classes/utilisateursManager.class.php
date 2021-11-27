<?php

/**
 * La classe utilisateursManager permet de gérer des utilisateurs créés avec la classe utilisateurs.
 * Elle contient des fonctions en ce but.
 * 
 * @author Tanguy
 */
class utilisateursManager {
    private $bdd;               // Instance de PDO
    private $_result;
    private $_message;
    private $_listUtilisateurs; // Instance de utilisateurs
    private $_getLastInsertId;
    
    
    // Constructeur
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);         
    }
    
    /**
     * Cette fonction permet d'ajouter des utilisateurs.
     * @param $utilisateurs
     */
    public function addUsers(utilisateurs $utilisateurs) {
    // Requette SQL.
        $sql = 'INSERT INTO utilisateurs '
                . '(nom, '
                . 'prenom, '
                . 'email, '
                . 'mdp) '
                . 'VALUES ('
                . ':nom, '
                . ':prenom, '
                . ':email, '
                . ':mdp)';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':nom', $utilisateurs->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateurs->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $utilisateurs->getMdp(), PDO::PARAM_STR);
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
     * Cette fonction sélectionne les utilisateurs en fonction de leur e-mail.
     * @param $email
     */
    function getByEmail($email) {
    // Requette SQL.
        $sql = 'SELECT * FROM utilisateurs WHERE email = :email';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':email',$email,PDO::PARAM_STR);
        $req->execute();
    // Attribution de la valeur à l'objet utilisateur.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
    // Retour du résultat.
        return $utilisateurs;
    }
    
    /**
     * Cette fonction sélectionne les utilisateurs en fonction de leur SID.
     * @param $sid
     */
    public function getBySid($sid) {
    // Requette SQL.
        $sql = 'SELECT * FROM utilisateurs WHERE sid = :sid';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();
    // Attribution de la valeur à l'objet utilisateur.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $utilisateur = new utilisateurs();
        $utilisateur->hydrate($donnees);
    // Retour du résultat.
        return $utilisateur;
    }
    
    /**
     * Cette fonction permet de mettre à jour le SID d'un utilisateur en fonction de son e-mail.
     * @param $utilisateurs
     */
    public function updateByEmail(utilisateurs $utilisateurs) {
    // Requette SQL.
        $sql = 'UPDATE utilisateurs SET SID= :sid WHERE email=:email';
    // Préparation, sécurisation et éxécution de la requette.
        $req = $this->bdd->prepare($sql);
        $req->BindValue(':email', $utilisateurs->getEmail(),PDO::PARAM_STR);
        $req->BindValue(':sid', $utilisateurs->getSid(),PDO::PARAM_STR);
        $req->execute();
    // Vérifications
        if ($req->errorCode() == 0000) {
            $this->_result=true;
        } else {
            $this->_result = false;
        }
    // Retour du résultat.
        return $this;
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

    function get_listUtilisateurs() {
        return $this->_listUtilisateurs;
    }

    function get_getLastInsertId() {
        return $this->_getLastInsertId;
    }

    function setBdd($bdd): void {
        $this->bdd = $bdd;
    }

    function set_result($_result): void {
        $this->_result = $_result;
    }

    function set_message($_message): void {
        $this->_message = $_message;
    }

    function set_listUtilisateurs($_listUtilisateurs): void {
        $this->_listUtilisateurs = $_listUtilisateurs;
    }

    function set_getLastInsertId($_getLastInsertId): void {
        $this->_getLastInsertId = $_getLastInsertId;
    }
}