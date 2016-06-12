<?php
include_once('controller/Controller.php');
include_once('model/M_Users.php');
include_once('model/M_Projects.php');

/**
 *  Controller-ul de baza al site-ului
 */
abstract class C_Base extends Controller
{
	protected $title;		// titlul paginii
	protected $content;		// continutul paginii
	protected $user;		// utilizatorul curent
	protected $needLogin;	// logare obligatorie
	protected $scripts;		// scripturi
	protected $categories;  // categoriile si numarul de utilizatori

	//
	// Constructor.
	//
	function __construct()
	{	
		$this ->user;
		$this ->needLogin = false;
		$this->categories = array();
	}

	protected function issetAndNotEmpty($var){
		return (isset($var) and !empty($var));
	}

	//
	// Procesorul virtual de cerere
	//
	protected function OnInput()
	{
		
		$this->title = 'Beefreelancer.com';
		$this->content = '';
		
		//Menager
		$mUsers = M_Users::Instance();

		// Curatirea sesiunelor vechi
		$mUsers->clearSessions();

		// Utilizatorul curent.
		$this->user = $mUsers->getUserById();

		if($this -> needLogin)
		{   
			
			if($this->user == null)
			{
				header("Location: index.php");
				die();
			}
		}

		if ($this->IsPost())
		{
			if (isset($_POST['login']))
			{
				if($this->issetAndNotEmpty(trim($_POST['email'])) and
						$this->issetAndNotEmpty(trim($_POST['password'])))
				{
					if ($mUsers->login(trim($_POST['email']),
							trim($_POST['password']),
							isset($_POST['remember'])))
					{
						header('Location:' . $_SERVER['REQUEST_URI']);
						die();
					}
				}
			}

			if (isset($_POST['logout']))
			{
				$mUsers->logout();
				header('Location: index.php');
				die();
			}
		}

		$this->categories= $mUsers->getCategories();

	}
	
	//
	// Generatorul virtual de HTML.
	//		
	protected function OnOutput()
	{
		$vars = array('title' => $this->title, 'content' => $this->content,'user' => $this->user,'scripts' => $this->scripts,'categories' => $this->categories);
		$page = $this->Template('view/tpl_main.php', $vars);
		echo $page;
	}	
}
