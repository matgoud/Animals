<?php

class Animal{

    private $nom;
    private $species;
    private $age;

    public function __construct($nom,$species,$age) {
        $this->nom = $nom;
        $this->species = $species;
        $this->age = $age;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getSpecies(){
        return $this->species;
    }

    public function getAge(){
        return $this->age;
    }

    public function setNom($newNom){
        return $this->nom = $newNom;
    }

    public function setSpecies($newSpecies){
        return $this->species = $newSpecies;
    }

    public function setAge($newAge){
        return $this->age = $newAge;
    }

}

?>