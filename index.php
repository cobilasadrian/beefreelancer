<?php
include_once('controller/C_Index.php');
include_once('controller/C_Reg_User.php');
include_once('controller/C_Projects.php');
include_once('controller/C_Project.php');
include_once('controller/C_New_Project.php');

// Deschiderea sesiunei.
session_start();

$parameter = null;
if(isset($_GET['c']))
	$parameter = $_GET['c'];

switch ($parameter) {
	case 'reg':
		$controller = new C_Reg_User();
		break;
	case 'projects':
		$controller = new C_Projects();
		break;
	case 'project':
		$controller = new C_Project();
		break;
	case 'newProject':
		$controller = new C_New_Project();
		break;
	default:
		$controller = new C_Index();
		break;
}
$controller->Request();