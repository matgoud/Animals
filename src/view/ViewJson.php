<?php

require_once("model/Animal.php");

class ViewJson{

    private $content;

    public function __construct(){
    }

    public function prepareJsonPage(AnimalBuilder $animal){
        header("Content-Type: application/json");
        $data = array($animal::NAME_REF => $animal->getData()->getNom(),$animal::SPECIES_REF => $animal->getData()->getSpecies(),$animal::AGE_REF => $animal->getData()->getAge());
        $json = json_encode($data,JSON_UNESCAPED_UNICODE);
        echo $json;
    }



}
?>