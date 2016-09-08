<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/*
	Deinstallation component file
	Showing information about deinstall
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// function to deinstall
function com_uninstall()
{
	// swhowing info text
	echo JText::_('UNINSTALLED');
}

?>