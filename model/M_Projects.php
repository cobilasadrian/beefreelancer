<?php
include_once('model/DB.php');
include_once('model/M_Users.php');

/**
 *  Managerul proiectelor
 */
class M_Projects
{
    private static $instance;    // instanta clasei
    private $mUsers;

    /**
     * Primim instanta clasei
     * @return M_Projects
     */
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Projects();

        return self::$instance;
    }

    /**
     * M_Projects constructor.
     */
    public function __construct()
    {
        $this->mUsers = M_Users::Instance();
    }

    /**
     * Folosim metode cu acelasi nume dar cu numar diferit de argumente
     * @param $method - numele metodei
     * @param $arguments - numarul de argumente
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if ($method == 'getProjects') {
            if (count($arguments) == 2) {
                return call_user_func_array(array($this, 'getProjectsWith2Parameters'), $arguments);
            } else if (count($arguments) == 3) {
                return call_user_func_array(array($this, 'getProjectsWith3Parameters'), $arguments);
            }
        }
        if ($method == 'getNumberOfProjects') {
            if (count($arguments) == 0) {
                return call_user_func_array(array($this, 'getNumberOfProjectsWithoutParameters'), $arguments);
            } else if (count($arguments) == 1) {
                return call_user_func_array(array($this, 'getNumberOfProjectsWith1Parameter'), $arguments);
            }
        }
    }

    /**
     * Primim proiectele intre $start si $num
     * @param $start
     * @param $num
     * @return array - obiect de tip proiect
     */
    public function getProjectsWith2Parameters($start, $num)
    {
        $conn = DB::getInstance();
        $result = $conn->query("SELECT projects.*, specializations.name AS specialization,
                                COUNT(projectsanswers.idAnswer) AS answers
                                FROM projects
                                JOIN specializations
                                ON projects.idSpecialization = specializations.idSpecialization
                                LEFT JOIN projectsanswers
                                ON projectsanswers.idProject = projects.idProject
                                GROUP BY projects.idProject
                                ORDER BY projects.idProject DESC LIMIT $start, $num")->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Primim proiectele intre $start si $num avind conditii in array-ul $data
     * @param $data - where conditii
     * @param $start
     * @param $num
     * @return array - obiect de tip proiect
     */
    public function getProjectsWith3Parameters($data, $start, $num)
    {
        $conn = DB::getInstance();
        $result = $conn->query("SELECT projects.*, specializations.name AS specialization,
                                COUNT(projectsanswers.idAnswer) AS answers
                                FROM projects
                                JOIN specializations
                                ON projects.idSpecialization = specializations.idSpecialization
                                LEFT JOIN projectsanswers
                                ON projectsanswers.idProject = projects.idProject
                                WHERE " . implode(' AND ', $data) . "
                                GROUP BY projects.idProject
                                ORDER BY projects.idProject DESC LIMIT  $start, $num")->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Primim numarul total de proiecte
     * @return - numarul de proiecte
     */
    public function getNumberOfProjectsWithoutParameters()
    {
        $conn = DB::getInstance();
        $result = $conn->query("SELECT count(*) FROM projects")->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    /**
     * Primim numarul total de proiecte avind conditii in array-ul $data
     * @param $data - where conditii
     * @return - numarul de proiecte
     */
    public function getNumberOfProjectsWith1Parameter($data)
    {
        $conn = DB::getInstance();
        $result = $conn->query("SELECT COUNT(DISTINCT (projects.idProject)) FROM projects
                                JOIN specializations
                                ON projects.idSpecialization = specializations.idSpecialization
                                LEFT JOIN projectsanswers
                                ON projectsanswers.idProject = projects.idProject
                                WHERE " . implode(' AND ', $data))->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    /**
     * Primim toate categoriile
     * @return array
     */
    public function getCategories()
    {
        $conn = DB::getInstance();
        $result = $conn->query("SELECT * FROM categories
                                ORDER BY idCategory ASC")->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Primim toate specializarile
     * @return array
     */
    public function getSpecializations()
    {
        $conn = DB::getInstance();
        $result = $conn->query("SELECT categories.name, specializations.name
                                FROM specializations
                                JOIN categories
                                ON specializations.idCategory = categories.idCategory")->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_COLUMN);
        return $result;
    }

    /**
     * Primim proiect dupa ID
     * @param $idProject - ID-ul proiectului
     * @return array - obiect
     */
    public function getProjectById($idProject)
    {
        if ($idProject == null)
            return null;

        $conn = DB::getInstance();
        $stmt = $conn->prepare("SELECT projects.*, specializations.idSpecialization, specializations.name AS specialization,
                                      users.idUser AS idAuthor ,users.lastName AS authorLastName,
                                      users.firstName AS authorFirstName, users.profileImage AS authorProfileImage
                                FROM projects
                                JOIN specializations
                                ON specializations.idSpecialization = projects.idSpecialization
                                JOIN users
                                ON projects.author = users.idUser
                                WHERE projects.idProject=:idProject");
        $stmt->execute(array(':idProject' => $idProject));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result[0];
    }

    /**
     * Adaugam un nou proiect
     * @param $title - denumirea
     * @param $description - textul proiectului
     * @param $specialization - specializarea
     * @param null $budget - bugetul
     * @param null $budgetCurrency - valuta bugetului
     * @param $author - ID-ul autorului
     * @return - ID-ul proiectului aduagat
     */
    public function addNewProject($title, $description, $specialization, $budget = null, $budgetCurrency = null, $author)
    {
        if(!$this->mUsers->can('ADD_PROJECT'))
            return false;

        // introducem in BD
        $conn = DB::getInstance();
        $stmt = $conn->prepare("INSERT INTO projects(title,description,author,budget,budgetCurrency,views,publishDate,idSpecialization)
								VALUES(:title,:description,:author,:budget,:budgetCurrency,0,NOW(),
								(SELECT idSpecialization FROM specializations WHERE name LIKE :specialization))");

        $stmt->execute(array(':title' => $title, ':description' => $description, ':author' => $author, ':budget' => $budget,
                            ':budgetCurrency' => $budgetCurrency, ':specialization' => $specialization));

        return $conn->lastInsertId();
    }

    /**
     * Setam executorul pentru proiect
     * @param $idProject - ID-ul proiectului
     * @param $executor - ID-ul executorului
     * @return bool
     */
    public function setExecutor($idProject,$executor)
    {
        $conn = DB::getInstance();
        $stmt = $conn->prepare("UPDATE projects SET executor = :executor WHERE idProject = :idProject");
        $stmt->execute(array(':idProject' => $idProject, ':executor' => $executor));
        return ($stmt->rowCount()>0);
    }

    /**
     * Primim numarul de raspunsuri la proiect
     * @param $idProject - ID-ul proiectului
     * @return - numarul de raspunsuri
     */
    public function getNumberOfAnswers($idProject)
    {
        if ($idProject == null)
            return null;

        $conn = DB::getInstance();
        $stmt = $conn->prepare("SELECT count(*)  FROM projectsanswers
                                WHERE idProject = :idProject");
        $stmt->execute(array(':idProject' => $idProject));
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    /**
     * Incrementam vizualizari pentru proiect
     * @param $idProject - ID-ul proiectului
     * @return bool
     */
    public function updateViews($idProject)
    {
        $conn = DB::getInstance();
        $stmt = $conn->prepare("UPDATE projects SET views = views+1 WHERE idProject = :idProject");
        $stmt->execute(array(':idProject' => $idProject));
        return ($stmt->rowCount()>0);
    }

    /**
     * Verificam daca exista deja un raspuns adaugat de utilizator
     * @param $idProject - ID-ul proiectului
     * @param $author - ID-ul autorului
     * @return true|false
     */
    public function checkIfAnswerExist($idProject, $author){

        if ($idProject == null or $author ==null)
            return null;

        $conn = DB::getInstance();
        $stmt = $conn->prepare("SELECT count(*)  FROM projectsanswers
                                WHERE idProject = :idProject AND author = :author");
        $stmt->execute(array(':idProject' => $idProject, ':author' => $author));
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return ($result[0]>0);
    }

    /**
     * Primim raspunsurile la proiect
     * @param $idProject - ID-ul proiectului
     * @return array|null - obiect de tip raspuns
     */
    public function getProjectAnswers($idProject)
    {
        if ($idProject == null)
            return null;

        $conn = DB::getInstance();
        $stmt = $conn->prepare("SELECT projectsanswers.*, users.idUser AS idAuthor ,users.lastName AS authorLastName,
                                      users.firstName AS authorFirstName, users.profileImage AS authorProfileImage
                                FROM projectsanswers
                                JOIN users
                                ON projectsanswers.author = users.idUser
                                WHERE projectsanswers.idProject = :idProject
                                ORDER BY projectsanswers.idAnswer DESC");
        $stmt->execute(array(':idProject' => $idProject));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Adaugam raspuns la proiect
     * @param $answer - textul raspunsului
     * @param null $budget - bugetul propus
     * @param null $budgetCurrency - valuta
     * @param null $executionTime - termen de executie
     * @param null $timeUnit - unitatea de timp
     * @param $author - ID-ul autorului
     * @param $idProject - ID-ul proiectului
     * @return true|false
     */
    public function addNewAnswer($answer, $budget = null, $budgetCurrency = null, $executionTime = null,
                                $timeUnit = null, $author, $idProject)
    {
        if(!$this->mUsers->can('ADD_ANSWER'))
            return false;;

        if ($idProject == null)
            return null;

        // introducem in BD
        $conn = DB::getInstance();
        $stmt = $conn->prepare("INSERT INTO projectsanswers(answer,budget,budgetCurrency,executionTime,
                                                            timeUnit,publishDate,author,idProject)
								VALUES(:answer,:budget,:budgetCurrency,:executionTime,:timeUnit,NOW(),:author,:idProject)");

        $stmt->execute(array(':answer' => $answer,':budget' => $budget, ':budgetCurrency' => $budgetCurrency,
                            ':executionTime' => $executionTime, ':timeUnit' => $timeUnit, ':author' =>$author,
                            ':idProject' => $idProject));

        return ($stmt->rowCount()>0);
    }

}