<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/*
	Component installation file
	
	- create visual step of installation
	- saves component icon
	- connection option parameter with component
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Back function
function BackToInstall($e)
{
	// show error in alert
	echo '<script> alert("'.$e.'");window.history.go(-1);</script>';
	// stop script
	exit();
}

// install function
function com_install() 
{
	// creatung database interface
	$database = & JFactory::getDBO();
	// Swhowing header
	echo "<h2>PhotoSlide GK2</h2>";
	// component database actualization
	$database->setQuery('
	UPDATE 
		#__components 
	SET 
		`admin_menu_img` = "../administrator/components/com_gk_photoslide/interface/images/com_logo_gk2.png"
	WHERE 
		`name` = "gk2_photoslide" 
		AND 
		`option` = "com_gk2_photoslide"
	');
	// when error - go back
	if (!$database->query()) BackToInstall($database->getErrorMsg());
	// actualization of link database
	$database->setQuery('
	UPDATE 
		#__components 
	SET 
		`link` = "option=com_gk2_photoslide" 
	WHERE 
		`name` = "gk2_photoslide" 
		AND 
		`option` = "com_gk2_photoslide"
	');
	// when error - go back
	if (!$database->query()) BackToInstall($database->getErrorMsg());
	// when all is OK - show info about successfull installation
	echo JText::_('INSTALLED'); 
}

?>