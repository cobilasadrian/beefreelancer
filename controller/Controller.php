<?php
//
// Clasa de baza a controller-ului
//
abstract class Controller
{
	//
	// Constructor.
	//
	function __construct()
	{		
	}
	
	//
	// Prelucrarea cererii HTTP
	//
	public function Request()
	{
		$this->OnInput();
		$this->OnOutput();
	}
	
	//
	// Procesorul virtual de cerere
	//
	protected function OnInput()
	{
	}
	
	//
	// Generatorul virtual de HTML.
	//		
	protected function OnOutput()
	{
	}
	
	//
	// Cererea este de tip GET?
	//
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	//
	// Cererea este de tip POST?
	//
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	//
	// Generarea template-ului HTML intr-un rind.
	//
	protected function Template($fileName, $vars = array())
	{
		// Initializarea variabilelor pentru template
		foreach ($vars as $k => $v)
		{
			$$k = $v;
		}

		// Generarea rindului HTML.
		ob_start();
		include $fileName;
		return ob_get_clean();	
	}	
}
