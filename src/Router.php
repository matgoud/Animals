<?php

require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/AnimalStorageStub.php");
require_once("model/AnimalBuilder.php");



class Router{
    
    public function main($animalStorage){

        if(key_exists('feedback',$_SESSION)){
            $feedback = $_SESSION['feedback'];
        }else{
            $feedback = "";
        }

        if(key_exists('curentNewAnimal',$_SESSION)){
            $curentNewAnimal = $_SESSION['curentNewAnimal'];
        }else{
            $curentNewAnimal = new AnimalBuilder(null);
        }

        $view = new View($this,$feedback);
        $controller = new Controller($view,$animalStorage);

        $animalId = key_exists('animal', $_GET)? $_GET['animal']: null;
        $action = key_exists('action', $_GET)? $_GET['action']: null;
        if ($action === null) {
			$action = ($animalId === null)? "accueil": "voir";
		}
        $_SESSION['feedback']="";
        $_SESSION['curentNewAnimal']= new AnimalBuilder(null);
        if($action === 'json'){
            $controller->jsonView($animalId);
        }else{
            try {
                switch ($action) {
                    case 'voir':
                        if($animalId === null){
                            $view->prepareErrorPage();
                        }else{
                            $controller->showInformation($animalId);
                        }
                        break;
                    case 'liste':
                        $controller->showList();
                        break;
                    case 'nouveau':
                        $view->prepareAnimalCreationPage($curentNewAnimal);
                        break;
                    case 'sauverNouveau':
                        $controller->saveNewAnimal($_POST);
                        break;
                    case'supprimer':
                        if($animalId === null){
                            $view->prepareErrorPage();
                        }else{
                            $controller->deleteAnimal($animalId);
                        }
                        break;
                    case 'confirmDeletion':
                        if($animalId === null){
                            $view->prepareErrorPage();
                        }else{
                            $controller->confirmAnimalDeletion($animalId);
                        }
                    case 'deletePage':
                        $view->prepareAnimalDeletePage();
                        break;
                    case 'modifier':
                        $controller->moidifyAnimal($animalId);
                        break;
                    case 'sauverModification':
                        $controller->saveAnimalModification($animalId,$_POST);
                        break;
                    default:
                    $view->prepareAccueilPage();
                        break;
                }
            } catch (Exception $e) {
                $view->prepareErrorPage();
            }
            $view->render();
        }

    }

    public function getHomePage(){
        return "site.php?";
    }

    public function getAnimalSaveURL(){
        return "site.php?action=sauverNouveau";
    }

    public function getAnimalListe(){
        return "site.php?action=liste";
    }

    public function getAnimalCreationURL(){
        return "site.php?action=nouveau";
    }

    public function getAnimalURL($id){
        return "site.php?animal=".$id."&amp;action=voir";
    }

    public function modifierAnimalURL($id){
        return "site.php?animal=".$id."&amp;action=modifier";
    }

    public function sauverModificationAnimalURL($id){
        return "site.php?animal=".$id."&amp;action=sauverModification";
    }

    public function getAnimalDeletionURL($id){
        return "site.php?animal=".$id."&amp;action=supprimer";
    }

    public function confirmAnimalDeletion($id){
        return "site.php?animal=".$id."&amp;action=confirmDeletion";
    }

    public function deletePageUrl(){
        return "site.php?action=deletePage";
    }

    public function jsonURl($id){
        return "site.php?animal".$id."&amp;action=json";
    }

    public function POSTredirect($url, $feedback){
        $_SESSION['feedback'] = $feedback;
        header('HTTP/1.1 303 See Other');
        header('Location: ' . $url);
    }

}

?>