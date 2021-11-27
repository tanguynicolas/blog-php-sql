<?php

/**
 * La classe utilisateurs permet de créer des utilisateurs.
 * Elle contient une fonction hydrate.
 * 
 * @author Tanguy
 */
class utilisateurs{
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mdp;
    public $sid;

    
    /**
     * La fonction hydrate permet d'attribuer ses valeurs à un objet utilisateur.
     * @param $donnees
     */
    public function hydrate($donnees) {
    // ID
        if (isset($donnees['id'])){
            $this->id = $donnees['id'];
        }
        else {
            $this->id = '';
        }
        
    // Nom
        if (isset($donnees['nom'])) {
            $this->nom = $donnees['nom'];
        }
        else {
            $this->nom = '';
        }

    // Prénom
        if (isset($donnees['prenom'])) {
            $this->prenom = $donnees['prenom'];
        }
        else {
            $this->prenom = '';
        }

    // E-mail
        if (isset($donnees['email'])) {
            $this->email = $donnees['email'];
        }
        else {
            $this->email = '';
        }

    // MDP
        if (isset($donnees['mdp'])) {
            $this->mdp = $donnees['mdp'];
        }
        else {
            $this->mdp = '';
        }
        
    // SID
        if (isset($donnees['sid'])) {
            $this->sid = $donnees['sid'];
        }
        else {
            $this->sid = '';
        }
    }
    
    // Getters & Setters
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

    function getMdp() {
        return $this->mdp;
    }

    function getSid() {
        return $this->sid;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMdp($mdp) {
        $this->mdp = $mdp;
    }

    function setSid($sid) {
        $this->sid = $sid;
    }
}