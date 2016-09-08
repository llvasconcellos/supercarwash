<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	Class SystemControl
	- shows information about GD
	- shows information about catalog permissions
	- shows information about database status
	- has option "check for updates"
	
	Uses:
	- system.check.php
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class SystemControl 
{
	// component version
	var $version = '<strong>2.2 stable</strong>';
	// status of component tables
	var $groupsDB_status = false;
	var	$slidesDB_status = false;
	var	$pluginsDB_status = false;
	var	$extensionsDB_status = false;
	// prefix for database tables
	var $prefix = '';	
	// checking GD status
	function GDStatus()
	{
		echo (!extension_loaded('gd')) ? 
		'<strong><font color="red">'.JText::_('CSC_DISABLED').'</font></strong>':
		'<strong><font color="green">'.JText::_('CSC_ENABLED').'</font></strong>'; 
	}
	// checking PNG support
	function PNGSupport()
	{
		$gd = gd_info();
    	
    	echo ($gd['PNG Support'] == false) ? 
		'<strong><font color="red">'.JText::_('CSC_DISABLED').'</font></strong>':
		'<strong><font color="green">'.JText::_('CSC_ENABLED').'</font></strong>';
	}
	// Checking GD version
	function GDVersion()
	{
		$gd = gd_info();
    	echo (ereg_replace('[[:alpha:][:space:]()]+', '', $gd['GD Version']) < '2.0.1') ? 
		'<strong><font color="red">'.$gd['GD Version'].JText::_('CSC_GDTOOOLD').'</font></strong>':
		'<strong><font color="green">'.$gd['GD Version'].'</font></strong>';	
	}
	// Checking folder permissions
	function folderStatus($folder){
		if(is_writable($folder))
		{
			echo '<strong><font color="green">'. JText::_( 'CSC_WRITABLE' ) .'</font></strong>'; 
		} 
		else
		{
			echo '<strong><font color="red">'. JText::_( 'CSC_UNWRITABLE' ) .'</font></strong>';
		}
	}
	// Checking database tables status
	function DBStatus()
	{
		// getting tables list
		$db =& JFactory::getDBO();
		$results = $db->getTableList();
		// getting prefix values
		$jconf = new JConfig();
		$this->prefix = $jconf->dbprefix;	
		// setting tables status
		for($i=0;$i < count($results);$i++)
		{
			if($results[$i] == $this->prefix.'gk2_photoslide_groups') $this->groupsDB_status = true;
			if($results[$i] == $this->prefix.'gk2_photoslide_slides') $this->slidesDB_status = true;
			if($results[$i] == $this->prefix.'gk2_photoslide_plugins') $this->pluginsDB_status = true;
			if($results[$i] == $this->prefix.'gk2_photoslide_extensions') $this->extensionsDB_status = true;
		}	
	}
	// writing effects of tables checking
	function DBTableStatus($table)
	{
		// check table name and write
		if($table == 'gk2_photoslide_groups')
		{
			echo ($this->groupsDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
		elseif($table == 'gk2_photoslide_slides')
		{
			echo ($this->slidesDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
		elseif($table == 'gk2_photoslide_plugins')
		{
			echo ($this->pluginsDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
		elseif($table == 'gk2_photoslide_extensions')
		{
			echo ($this->extensionsDB_status) ? 
			'<strong><font color="green">'.JText::_('CSC_YES').'</font></strong>' : 
			'<strong><font color="red">'.JText::_('CSC_NO').'</font></strong>';
		}
	}
}

?>