<?php 

require_once("model/Animal.php");

class View{ 

    private $router;
    private $feedback;
    private $title;
    private $content;
    private $menu;

    public function __construct(Router $router,$feedback){   
        $this->router = $router;
        $this->feedback = $feedback;
        $this->title = "";
        $this->content = "";
        $this->menu = "
                    <ul class='navbar'>
                        <li><a href='".$this->router->getAnimalListe()."'>Liste des animaux</a></li>
                        <li><a href='".$this->router->getHomePage()."'>Acueil</a></li>
                        <li><a href='".$this->router->getAnimalCreationURL()."'>Nouveau</a></li>
                       </ul>";
    }

    
    public function prepareTestPage(){
        $this->title = "Test";
        $this->content = "Encore un test";
    }
    
    public function prepareAnimalPage(Animal $animal,$id){
        $this->title = $animal->getNom();
        $this->content = "<div class='description'>".$animal->getNom()." est animal de l'espèce ".$animal->getSpecies()." de ".$animal->getAge()." ans</div>";
        $this->content .= '<div class="div-btn"><form action="'.$this->router->getAnimalDeletionURL($id).'" method="POST">
        <button type="submit">Supprimer</button></form>';
        $this->content .= '<form action="'.$this->router->modifierAnimalURL($id).'" method="POST">
        <button type="submit">Modifier</button></form></div>';
    }

    public function prepareModificationPage($id,AnimalBuilder $animal){
        $this->title = "Modifier l'animal";
        $data = $animal->getData();
        if($data instanceof Animal){
            $nom = $data->getNom();
            $espece = $data->getSpecies();
            $age = $data->getAge();
        }else{
            $nom = $data[$animal::NAME_REF];
            $espece = $data[$animal::SPECIES_REF];
            $age = $data[$animal::AGE_REF];
        }
        $this-> content = '<div class="div-form">
            <form action="'.$this->router->sauverModificationAnimalURL($id).'" method="POST">
            <label>'.$animal::NAME_REF.'</label>
            <input type="text" name="'.$animal::NAME_REF.'" value="'.$nom.'" >
            <label>'.$animal::SPECIES_REF.'</label>
            <input type="text" name="'.$animal::SPECIES_REF.'" value="'.$espece.'" >
            <label>'.$animal::AGE_REF.'</label>
            <input type="number" name="'.$animal::AGE_REF.'" value="'.$age.'" >
            <button type="submit">Valider</button><span class="error-message">'.$animal->getError().'</span></form></div>';
    }

    public function prepareUnknowAnimalPage($id){
        $this->title = "Error";
        $this->content = $id." est un animal inconnu";
    }

    public function prepareErrorPage(){
        $this->title = "Error";
        $this->content = "Les données sont incorect !";
    }
    
    public function prepareAccueilPage(){
        $this->title = "Acueil";
        $this->content = "<div class='description'>Un site sur les animaux</div>";
    }

    public function prepareListPage($animals){
        $this->title = "Liste des animaux";
        $this->content = "<ul class='liste'>";    
        foreach ($animals as $key => $animal) {
            $this->content .= '<li>';
            $this->content .= '<a href="site.php?animal='.$key.'&amp;action=voir">'.$animal->getNom().'</a>';
            $this->content .= '<button class="detail-btn" data-animal-id="'.$key.'" id="btnDetail-'. $key .'">Détails</button>';
            $this->content .= '<div id="resultat-'.$key.'"></div>';
            $this->content .= '</li>';
        }
        $this->content .= '</ul>';
    }
    

    public function prepareConfirmDeletionPage($id){
        $this->title = "Voulez vous vraiment suprimer l'animal ?";
        $this->content = '<div class="div-btn"><form action="'.$this->router->confirmAnimalDeletion($id).'" method="POST">
        <button type="submit">Valider</button></form>';
        $this->content .= '<form action="'.$this->router->getAnimalURL($id).'" method="POST">
        <button type="submit">Anuller</button></form></div>';
    }

    public function prepareAnimalDeletePage(){
        $this->title = "Suppression";
        $this->content = "<div class='description'>L'animal a été supprimé</div>";
    }

    public function prepareDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    public function displayAnimalCreationSuccess($id){
        $url = $this->router->getAnimalURL($id);
        $this->router->POSTredirect($url,"Succés lors de la création de l'animal");
    }

    public function displayAnimalCreationFail(){
        $url = $this->router->getAnimalCreationURL();
        $this->router->POSTredirect($url,"Erreur lors de la création de l'animal");
    }

    public function displayAnimalDeletionSuccess($id){
        $url = $this->router->deletePageUrl();
        $this->router->POSTredirect($url,"Succés lors de la suppression de l'animal");
    }

    public function displayAnimalModificationSuccess($id){
        $url = $this->router->getAnimalURL($id);
        $this->router->POSTredirect($url,"Succés lors de la modification de l'animal");
    }
    

    public function prepareAnimalCreationPage(AnimalBuilder $animal){
        $this->title = "Ajouter un animal";
        if(empty($animal->getData())){
            $this-> content .= '<div class="div-form">
            <form action="'.$this->router->getAnimalSaveURL().'" method="POST">
            <label>'.$animal::NAME_REF.'</label>
            <input type="text" name="'.$animal::NAME_REF.'">
            <label>'.$animal::SPECIES_REF.'</label>
            <input type="text" name="'.$animal::SPECIES_REF.'" >
            <label>'.$animal::AGE_REF.'</label>
            <input type="number" name="'.$animal::AGE_REF.'" >
            <button type="submit">Valider</button> <span class="error-message">'.$animal->getError().'</span></form></div>';
        }else{
            $this-> content .= '<div class="div-form">
            <form action="'.$this->router->getAnimalSaveURL().'" method="POST">
            <label>'.$animal::NAME_REF.'</label>
            <input type="text" name="'.$animal::NAME_REF.'" value="'.$animal->getData()[$animal::NAME_REF].'" >
            <label>'.$animal::SPECIES_REF.'</label>
            <input type="text" name="'.$animal::SPECIES_REF.'" value="'.$animal->getData()[$animal::SPECIES_REF].'" >
            <label>'.$animal::AGE_REF.'</label>
            <input type="number" name="'.$animal::AGE_REF.'" value="'.$animal->getData()[$animal::AGE_REF].'" >
            <button type="submit">Valider</button> <span class="error-message">'.$animal->getError().'</span></form></div>';
        }
    }

    protected function getMenu() {
        return $this->menu;
	}
    
    public function render(){
        if($this->title === null || $this->content === null){
            $this->title = "";
            $this->content = "";
        }
        include("squelette.php");
    }

}

?>