<?php

/**
 * La classe commentaires permet de créer des commentaires.
 * Elle contient une foncton hydrate.
 * 
 * @author Tanguy
 */
class commentaires {
    public $id;
    public $id_article;
    public $email;
    public $pseudo;
    public $texte;
    
    
    /**
     * La fonction hydrate permet d'attribuer ses valeurs à un objet commentaire.
     * @param type $donnees
     */
    public function hydrate($donnees) {
    // ID
        if (isset($donnees['id'])) {
            $this->id = $donnees['id'];
        }
        else {
            $this->id = '';
        }
        
    // ID d'article
        if (isset($donnees['id_article'])) {
            $this->id_article = $donnees['id_article'];
        }
        else {
            $this->id_article = '';
        }

    // E-mail
        if (isset($donnees['email'])) {
            $this->email = $donnees['email'];
        }
        else {
            $this->email = '';
        }

    // Pseudo
        if (isset($donnees['pseudo'])) {
            $this->pseudo = $donnees['pseudo'];
        }
        else {
            $this->pseudo = '';
        }

    // Texte
        if (isset($donnees['texte'])) {
            $this->texte = $donnees['texte'];
        }
        else {
            $this->texte = '';
        }
    }
    
    // Getters & Setters
    function getId() {
        return $this->id;
    }

    function getId_article() {
        return $this->id_article;
    }

    function getEmail() {
        return $this->email;
    }

    function getPseudo() {
        return $this->pseudo;
    }

    function getTexte() {
        return $this->texte;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setId_article($id_article) {
        $this->id_article = $id_article;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    function setTexte($texte) {
        $this->texte = $texte;
    }
}