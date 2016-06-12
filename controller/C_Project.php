<?php
include_once('controller/C_Base.php');

//
//Controller-ul paginii cu proiect.
//
class C_Project extends C_Base
{
    private $project;
    private $numberOfAnswers;
    private $answers;
    private $isAnswer;
    //
    // Constructor.
    //
    function __construct()
    {
        $this->project = array();
        $this->answers = array();
        $this->numberOfAnswers = 0;
        $this->isAnswer = false;
        $this->isAuthorOnline = false;
    }


    // Procesorul virtual de cerere
    //
    protected function OnInput()
    {
        parent::OnInput();

        //Menagerul proiectelor
        $mProjects = M_Projects::Instance();
        //Menagerul utilizatorilor
        $mUsers = M_Users::Instance();

        if($this->issetAndNotEmpty($_GET['idProject'])){
            $mProjects->updateViews($_GET['idProject']);
            $this->project = $mProjects->getProjectById($_GET['idProject']);
            $this->isAuthorOnline = $mUsers->isOnline($this->project['idAuthor']);
            $this->numberOfAnswers = $mProjects->getNumberOfAnswers($_GET['idProject']);
            if(count($this->numberOfAnswers)>0)
                $this->answers = $mProjects->getProjectAnswers($_GET['idProject']);
            if($this->user != null)
                $this->isAnswer = $mProjects->checkIfAnswerExist($_GET['idProject'], $this->user['idUser']);
        }
        else {
            header('Location: index.php');
            die();
        }

        $this->title = $this->title . ' - '.$this->project['title'];

        if ($this->IsPost()) {
            if(isset($_POST["addAnswerBtn"])){
                if(!$this->isAnswer) {
                    $budget = null;
                    if ($this->issetAndNotEmpty(trim($_POST['budget'])))
                        $budget = trim($_POST['budget']);
                    $budgetCurrency = null;
                    if ($this->issetAndNotEmpty($_POST['budgetCurrency']) and $this->issetAndNotEmpty($budget))
                        $budgetCurrency = trim($_POST['budgetCurrency']);
                    $executionTime = null;
                    if ($this->issetAndNotEmpty(trim($_POST['executionTime'])))
                        $executionTime = trim($_POST['executionTime']);
                    $timeUnit = null;
                    if ($this->issetAndNotEmpty(trim($_POST['timeUnit'])) and $this->issetAndNotEmpty($executionTime))
                        $timeUnit = trim($_POST['timeUnit']);
                    if ($this->issetAndNotEmpty(trim($_POST['answer'])) and
                        $this->issetAndNotEmpty(trim($_POST['author']))
                    ) {
                        $answer = trim($_POST['answer']);
                        $author = trim($_POST['author']);

                        if ($mProjects->addNewAnswer($answer, $budget, $budgetCurrency,
                            $executionTime, $timeUnit, $author, $_GET['idProject'])
                        ) {
                            header("Location: index.php?c=project&idProject=" . $_GET['idProject']);
                            die();
                        }
                    } else {
                        exit ("Eroare. Nu ati completat toate cimpurile obligatorii.<br/>");
                    }
                }
            }
            if(isset($_POST["setExecutorBtn"])){
                if($this->issetAndNotEmpty(trim($_POST["executor"])))
                    $executor = trim($_POST["executor"]);
                if($mProjects->setExecutor($_GET['idProject'],$executor)){
                    header("Location: index.php?c=project&idProject=" . $_GET['idProject']);
                    die();
                }
            }
        }
    }

    //
    // Generatorul virtual de HTML.
    //
    protected function OnOutput()
    {
        $vars = array('project' => $this->project,
                        'numberOfAnswers'=> $this->numberOfAnswers,
                        'answers' => $this->answers,
                        'user' => $this->user,
                        'isAuthorOnline' => $this->isAuthorOnline,
                        'isAnswer' => $this->isAnswer);
        $this->content = $this->Template('view/tpl_project.php',$vars);
        parent::OnOutput();
    }
}
