<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/*
	Connected with Toolbar class
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Loading Toolbar class
require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.toolbar.php');
// creating new instance of Toolbar class
$tool = new Toolbar();
// switching tasks
switch ($task)
{	
	case 'view_group': 		$tool->view_group(); 	break;// Showing group		
	case 'add_group': 		$tool->add_group(); 	break;// Adding group					
	case 'edit_group': 		$tool->edit_group();	break;// Editing group
	case 'add_slide': 		$tool->add_slide(); 	break;// Adding slide
	case 'edit_slide': 		$tool->edit_slide(); 	break;// Editing slide
	case 'check_system': 	$tool->check_system(); 	break;// Showing system check
	case 'view_plugin': 	$tool->view_plugin(); 	break;// Showing plugins
	case 'add_plugin': 		$tool->add_plugin(); 	break;// Adding plugins				
	case 'help': 			$tool->help(); 			break;// Showing help page
	case 'info': 			$tool->info(); 			break;// Showing info page
	case 'view_extension': 	$tool->view_extension();break;// Showing extensions
	case 'add_extension': 	$tool->add_extension(); break;// Adding extension
	case 'news': 			$tool->news(); 		break;// Showing stats
	default: 				$tool->view_groups(); 	break;// Default task - showing all groups
}

?>