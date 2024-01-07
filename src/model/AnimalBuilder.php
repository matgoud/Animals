<?php
class AnimalBuilder{

    private $data;
    private $error;
    const NAME_REF = "Nom";
    const SPECIES_REF = "Espece";
    const AGE_REF = "Age";

    public function __construct($data) {
        $this->data = $data;
        $this->error = "";
    }

    public function getData(){
        return $this->data;
    }

    public function getError(){
        return $this->error;
    }

    public function isValid(){
        $nom = htmlspecialchars($this->data[self::NAME_REF]);
        $espece = htmlspecialchars($this->data[self::SPECIES_REF]);
        $age = $this->data[self::AGE_REF];
        $valid = true;
        if(empty($nom)){
            $valid = false;
            $this->error .= "Veuillez remplir le champ : nom ";
        }
        if(empty($espece)){
            $valid = false;
            $this->error .= "Veuillez remplir le champ : espèce ";
        }
        if($age <= 0){
            $valid = false;
            $this->error .= "Veuillez remplir correctement le champ : âge (l'âge doit être supérieur à 0) ";
        }
        return $valid;
    }

    public function createAnimal(){
        if($this->isValid($this->data)){
            $nom = htmlspecialchars($this->data[self::NAME_REF]);
            $espece = htmlspecialchars($this->data[self::SPECIES_REF]);
            $age = $this->data[self::AGE_REF];
            return new Animal($nom,$espece,$age);
        }else{
            return null;
        }
    }

    public function updateAnimal(Animal $animal) {
        if($this->isValid()){
            if (key_exists(self::NAME_REF, $this->data)){
                $animal->setNom(htmlspecialchars($this->data[self::NAME_REF]));
            }
            if (key_exists(self::SPECIES_REF, $this->data)){
                $animal->setSpecies(htmlspecialchars($this->data[self::SPECIES_REF]));
            }
            if(key_exists(self::AGE_REF,$this->data)){
                $animal->setAge($this->data[self::AGE_REF]);
            }
            return $animal;
        }else{
            return null;
        }
	}

}


?>