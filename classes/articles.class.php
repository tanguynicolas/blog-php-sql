<?php

/**
 * La classe articles permet de créer des articles.
 * Elle contient une fonction hydrate.
 * 
 * @author Tanguy
 */
class articles{
    public $id;
    public $titre;
    public $texte;
    public $date;
    public $publie;
    
    
    /**
     * La fonction hydrate permet d'attribuer ses valeurs à un objet article.
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
    // Titre
        if (isset($donnees['titre'])) {
            $this->titre = $donnees['titre'];
        }
        else {
            $this->titre = '';
        }
    // Texte
        if (isset($donnees['texte'])) {
            $this->texte = $donnees['texte'];
        }
        else {
            $this->texte = '';
        }
    // Date
        if (isset($donnees['date'])) {
            $this->date = $donnees['date'];
        }
        else {
            $this->date = '';
        }
    // Publié
        if (isset($donnees['publie'])) {
            $this->publie = $donnees['publie'];
        }
        else {
            $this->publie = 0;
        }
    }
    
    // Getters & Setters
    function getId() {
        return $this->id;
    }

    function getTitre() {
        return $this->titre;
    }

    function getTexte() {
        return $this->texte;
    }

    function getDate() {
        return $this->date;
    }

    function getPublie() {
        return $this->publie;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setTexte($texte) {
        $this->texte = $texte;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setPublie($publie) {
        $this->publie = $publie;
    }
}