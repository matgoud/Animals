<?php

require_once ("AnimalStorage.php");

class AnimalStorageStub implements AnimalStorage{

    private $animalsTab;

    public function __construct(){
        $this->animalsTab = array(
            'medor' => new Animal("Médor","chien","5"),
            'felix' => new Animal("Félix","chat","35"),
            'denver' => new Animal("Denver","dinosaure","180"),
        );
    }

    public function read($id){
        if(array_key_exists($id,$this->animalsTab)){
            return $this->animalsTab[$id];
        }else{
            return null;
        }
    }

    public function readAll(){
        return $this->animalsTab;
    }

    public function create(Animal $a){
        throw new Exception('error');
    }

    public function delete($id){
        throw new Exception('error');
    }

    public function update($id,Animal $a){
        throw new Exception('error');
    }

}

?>