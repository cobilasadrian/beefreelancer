<?php
include_once('controller/C_Base.php');

//
//Controller-ul paginii principale.
//
class C_Index extends C_Base
{
	private $numberOfProjects;
	private $numberOfUsers;
	private $bestFreelancers;
	//
	// Constructor.
	//
	function __construct()
	{
		$this->numberOfProjects = null;
		$this->numberOfUsers = null;
		$this->bestFreelancers = null;
	}
	
	//
	// Procesorul virtual de cerere
	//
	protected function OnInput()
	{
		parent::OnInput();

		//Menagerul proiectelor
		$mProjects = M_Projects::Instance();
		$this->numberOfProjects = $mProjects->getNumberOfProjects(); //Primim numarul total de proiecte

		//Menagerul utilizatorilor
		$mUsers = M_Users::Instance();
		$this->numberOfUsers = $mUsers->getNumberOfUsers(); //Primim numarul total de utilizatori
		$this->bestFreelancers = $mUsers->getBestFreelancers();

		$this->title = $this->title . ' - Pagina principala';
		$this->scripts[] = "script0001.js";

	}
	
	//
	// Generatorul virtual de HTML.
	//	
	protected function OnOutput()
	{
		$vars = array('user' => $this->user, 'categories' => $this->categories, 'numberOfUsers' => $this->numberOfUsers, 'bestFreelancers' => $this->bestFreelancers, 'numberOfProjects' => $this->numberOfProjects);
		$this->content = $this->Template('view/tpl_index.php',$vars);
		parent::OnOutput();
	}	
}
