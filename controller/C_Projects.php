<?php
include_once('controller/C_Base.php');

//
//Controller-ul paginii proiectelor.
//
class C_Projects extends C_Base
{
    private $projects;
    private $currentPage;
    private $pages;
    private $specializations;
    private $searchData;
    //
    // Constructor.
    //
    function __construct()
    {
        $this->projects = array();
        $this->specializations = array();
        $this->currentPage = null;
        $this->pages = null;
        $this->searchData = array();
    }


    // Procesorul virtual de cerere
    //
    protected function OnInput()
    {
        parent::OnInput();

        $this->title = $this->title . ' - Proiecte';

        //Menagerul proiectelor
        $mProjects = M_Projects::Instance();
        $this->specializations = $mProjects->getSpecializations(); //Primim specializarile grupate in categorii

        if ($this->IsPost()) {
            //Daca filtrul proiectelor a fost pornit atunci ingregistram datele in $_SESSION
            if(isset($_POST['startFilterBtn'])) {
                unset($_SESSION['searchData']);
                $_SESSION['searchData'] = array();
                if ($this->issetAndNotEmpty(trim($_POST['specialization'])))
                    $_SESSION['searchData']['specialization'] = trim($_POST['specialization']);
                if ($this->issetAndNotEmpty(trim($_POST['budget'])))
                    $_SESSION['searchData']['budget'] = trim($_POST['budget']);
                if ($this->issetAndNotEmpty(trim($_POST['budgetCurrency'])))
                    $_SESSION['searchData']['budgetCurrency'] = trim($_POST['budgetCurrency']);
                if (isset($_POST['withoutExecutor']))
                    $_SESSION['searchData']['withoutExecutor'] = true;
                if (isset($_POST['lessTwoAnswers']))
                    $_SESSION['searchData']['lessTwoAnswers'] = true;
            }
            //Daca filtrul a fost oprit atunci stergem sesiune
            if(isset($_POST['stopFilterBtn'])) {
                unset($_SESSION['searchData']);
            }
        }

        if(isset($_SESSION['searchData']))
            $this->searchData = $_SESSION['searchData'];

        //Formam conditia pentru cauatarea proiectelor in BD
        $whereConditions = array();
        if(isset($_SESSION['searchData']['specialization'])) {
            $whereConditions[] = "specializations.name LIKE '" .$_SESSION['searchData']['specialization']. "'";
        }
        if(isset($_SESSION['searchData']['budget']) and isset($_SESSION['searchData']['budgetCurrency'])) {
            $budget = $_SESSION['searchData']['budget'];
            $budgetCurrency = $_SESSION['searchData']['budgetCurrency'];
            $RON = 4.9973; $USD = 19.8101; $EUR = 22.4737;
            if($budgetCurrency=='RON')
                $budget = $budget * $RON;
            if($budgetCurrency=='USD')
                $budget= $budget * $USD;
            if($budgetCurrency=='EUR')
                $budget = $budget * $EUR;
            $whereConditions[] = "((projects.budget >= ".$budget." AND projects.budgetCurrency LIKE 'MDL') OR
                                  (projects.budget >= ".$budget/$RON." AND projects.budgetCurrency LIKE 'RON')OR
                                  (projects.budget >= ".$budget/$USD." AND projects.budgetCurrency LIKE 'USD')OR
                                  (projects.budget >= ".$budget/$EUR." AND projects.budgetCurrency LIKE 'EUR'))";
        }
        if(isset($_SESSION['searchData']['withoutExecutor'])) {
            $whereConditions[] = "projects.executor IS NULL";
        }
        if(isset($_SESSION['searchData']['lessTwoAnswers'])) {
            $whereConditions[] = "(SELECT COUNT(*) FROM projectsanswers WHERE projectsanswers.idProject = projects.idProject ) < 2";
        }


        $num = 6; // Numarul maxim de proiecte afisate pe o pagina

        if ($this->IsGet()) {
            if (isset($_GET['page']))
                $this->currentPage = $_GET['page'];
        }
        if (empty($whereConditions)) {
            $numberOfProjects = $mProjects->getNumberOfProjects(); //Numarul total de proiecte
        } else {
            $numberOfProjects = $mProjects->getNumberOfProjects($whereConditions); //Numarul total de proiecte cu $whereConditions
        }
        $this->pages = intval(($numberOfProjects[0] - 1) / $num) + 1; //Numarul total de pagini
        //Se determina proiectele pentru pagina curenta
        $this->currentPage = intval($this->currentPage);
        // Daca valoarea $page este negativa
        // trecem pe prima pagina
        // Si daca este prea mare, atunci mergem pe ultima
        if(empty($this->currentPage) or $this->currentPage < 0) $this->currentPage = 1;
        if($this->currentPage > $this->pages) $this->currentPage = $this->pages;
        // Determinam incepind de la care numar
        // trebuie de afisat proiectele
        $start = $this->currentPage * $num - $num;

        if (empty($whereConditions)) {
            // Selectam $num proiecte incepind de la numarul $start
            $this->projects = $mProjects->getProjects($start, $num);
        } else {
            // Selectam $num proiecte incepind de la numarul $start cu $whereConditions
            $this->projects = $mProjects->getProjects($whereConditions, $start, $num);
        }

    }

    //
    // Generatorul virtual de HTML.
    //
    protected function OnOutput()
    {
        $vars = array('projects' => $this->projects,
                    'currentPage' => $this->currentPage,
                    'pages' =>$this->pages,
                    'specializations' => $this->specializations,
                    'searchData' => $this->searchData);
        $this->content = $this->Template('view/tpl_projects.php',$vars);
        parent::OnOutput();
    }
}
