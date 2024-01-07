<?php 

require_once("view/View.php");
require_once("view/ViewJson.php");
require_once("model/Animal.php");

class Controller{

    private $view;
    private $animals;

    public function __construct(View $view,AnimalStorage $animals){
        $this->view = $view;
        $this->animals = $animals;
    }

    public function showInformation($id) {
        if($this->animals->read($id) === null){
            $this->view->prepareUnknowAnimalPage($id);
        }else{
            $this->view->prepareAnimalPage($this->animals->read($id),$id);
        }
    }

    public function showList(){
        $this->view->prepareListPage($this->animals->readAll());
    }

    public function deleteAnimal($animalId){
        $animalTMP = $this->animals->read($animalId);
        if($animalTMP === null){
            $this->view->prepareUnknowAnimalPage($animalId);
        }else {
            $this->view->prepareConfirmDeletionPage($animalId);
        }
    }

    public function confirmAnimalDeletion($id){
        $ok = $this->animals->delete($id);
        if(!$ok){
            $this->view->prepareUnknowAnimalPage($id);
        }else{
            $this->view->displayAnimalDeletionSuccess($id);
        }
    }

    public function moidifyAnimal($animalId){
        $animalTMP = $this->animals->read($animalId);
        if($animalTMP === null){
            $this->view->prepareUnknowAnimalPage($animalId);
        }else{
            $animalBuilder = new AnimalBuilder($animalTMP);
            $this->view->prepareModificationPage($animalId,$animalBuilder);
        }
    }

    public function saveAnimalModification($animalId,array $data){
        $animalTMP = $this->animals->read($animalId);
        if($animalTMP === null){
            $this->view->prepareUnknowAnimalPage($animalId);
        }else{
            $animalBuilder = new AnimalBuilder($data);
            if($animalBuilder->updateAnimal($animalTMP) === null){
                $this->view->prepareModificationPage($animalId,$animalBuilder);
            }else{
                $animalTMP = $animalBuilder->updateAnimal($animalTMP);
                $ok = $this->animals->update($animalId,$animalTMP);
                if(!$ok){
                    throw new Exception("Identifier has disappeared?!");
                }
                $this->view->displayAnimalModificationSuccess($animalId);
            }
        }
    }

    public function saveNewAnimal(array $data){
        $animalBuilder = new AnimalBuilder($data);
        if($animalBuilder->createAnimal()===null){
            $_SESSION['curentNewAnimal'] = $animalBuilder;
            $this->view->displayAnimalCreationFail();
        }else{
            $animalTMP = $animalBuilder->createAnimal();
            $id = $this->animals->create($animalTMP);
            $this->view->displayAnimalCreationSuccess($id);
        }
    }

    public function jsonView($animalId){
        $animalTMP = $this->animals->read($animalId);
        if($animalTMP === null){
            $this->view->prepareUnknowAnimalPage($animalId);
        }else{
            $animalBuilder = new AnimalBuilder($animalTMP);
            $this->view = new ViewJson();
            $this->view->prepareJsonPage($animalBuilder);
        }
    }

    public function getView(){
        return $this->view;
    }

}


?>