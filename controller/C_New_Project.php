<?php
include_once('controller/C_Base.php');
include_once('model/M_Projects.php');

//
//Controller-ul paginii de creare a proiectelor.
//
class C_New_Project extends C_Base
{
    private $specializations;

    //
    // Constructor.
    //
    function __construct()
    {
        $this -> needLogin = true;
        $this->specializations = array();
    }


    // Procesorul virtual de cerere
    //
    protected function OnInput()
    {
        parent::OnInput();
        //Verificam daca exista utilizator logat si daca utilizatorul are rolul de angajator
        if($this->user != null)
            if($this->user['idRole'] == 1){ //Daca utilizatorul are rol de freelancer atunci facem redirectionare pe index.php
                header('Location: index.php');
                die();
        }

        $this->title = $this->title . ' - Crearea proiectelor';

        //Menagerul proiectelor
        $mProjects = M_Projects::Instance();
        $this->specializations = $mProjects->getSpecializations();

        if ($this->IsPost())
        {
            $budget = null;
            if ($this->issetAndNotEmpty($_POST['budget']))
                $budget = trim($_POST['budget']);
            $budgetCurrency = null;
            if ($this->issetAndNotEmpty($_POST['budgetCurrency']) and $this->issetAndNotEmpty($budget))
                $budgetCurrency = trim($_POST['budgetCurrency']);
            if ($this->issetAndNotEmpty(trim($_POST['title'])) and
                $this->issetAndNotEmpty(trim($_POST['description'])) and
                $this->issetAndNotEmpty(trim($_POST['specialization'])) and
                $this->issetAndNotEmpty($_POST['author']))
            {
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                $specialization = trim($_POST['specialization']);
                $author = trim($_POST['author']);

                $idProject = $mProjects->addNewProject($title, $description, $specialization,
                                                        $budget, $budgetCurrency, $author);
                if($this->issetAndNotEmpty($idProject)) {
                    header("Location: index.php?c=project&idProject=" .$idProject);
                    die();
                }
            } else {
                exit ("Eroare. Nu ati completat toate cimpurile obligatorii.<br/>");
            }
        }
    }

    //
    // Generatorul virtual de HTML.
    //
    protected function OnOutput()
    {
        $vars = array('user' => $this->user, 'specializations' => $this->specializations);
        $this->content = $this->Template('view/tpl_new_project.php',$vars);
        parent::OnOutput();
    }
}
