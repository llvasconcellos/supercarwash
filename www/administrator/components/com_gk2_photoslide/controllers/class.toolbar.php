<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	Class Toolbar
	- generate toolbars on component subpages
**/

class Toolbar{
	
	/**
		All methods names are connected with tasks
	**/
	
	function edit_group()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_EDITGROUP' ));
		JToolBarHelper::back();
		JToolBarHelper::save( 'apply_group' );
		JToolBarHelper::custom( 'a_group', 'apply.png', 'apply_f2.png', JText::_('APPLY'), false, false );
		JToolBarHelper::cancel( 'cancel_group', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(true);
	}
	
	function add_group()
	{
		$db =& JFactory::getDBO();
		$db->setQuery("
		SELECT 
			phpclassfile AS value, 
			name AS text 
		FROM 
			#__gk2_photoslide_plugins 
		WHERE 
			status = 1 
		ORDER BY 
			id ASC
		");
		
		$plugins = $db->loadObjectList();
		
		if(!isset($_GET['step']) && (count($plugins) > 1 || count($plugins) == 0))
		{
			JToolBarHelper::back();
			JToolBarHelper::title( 'Photoslide GK2 - '.JText::_('TOOLBAR_ADDGROUPSELECTMODULE'));
			JToolBarHelper::custom( 'add_group', 'forward.png', 'forward_f2.png', JText::_('NEXT'), false, false );
			JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		}
		else
		{
			JToolBarHelper::title( JText::_( 'Photoslide GK2 - '.JText::_('TOOLBAR_ADDGROUP' ) ));
			JToolBarHelper::back();
			JToolBarHelper::save( 'save_group' );
			JToolBarHelper::cancel( 'cancel_group', JText::_('CLOSE') );
			JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		}
		
		$this->submenu(true);
	}
	
	function edit_slide()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_EDITSLIDE' ));
		JToolBarHelper::back();
		JToolBarHelper::save( 'apply_slide' );
		JToolBarHelper::custom( 'a_slide', 'apply.png', 'apply_f2.png', JText::_('APPLY'), false, false );
		JToolBarHelper::cancel( 'cancel_slide', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(true);
	}
	
	function add_slide()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_ADDSLIDE' ) );
		JToolBarHelper::back();
		JToolBarHelper::save( 'save_slide' );
		JToolBarHelper::cancel( 'cancel_slide', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(true);
	}
	
	function view_groups()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_VIEWGROUPS' ) );
		JToolBarHelper::back();
		JToolBarHelper::addNew( 'add_group', JText::_( 'TOOLBAR_B_ADDGROUP' ));
		JToolBarHelper::editListX( 'edit_group', JText::_( 'TOOLBAR_B_EDITGROUP' ));
		JToolBarHelper::custom( 'view_group', 'preview.png', 'preview_f2.png', JText::_( 'TOOLBAR_B_VIEWGROUP' ), true, false );
		JToolBarHelper::deleteList( JText::_('TOOLBAR_B_REALLYWANTREMOVEGROUPS'), 'delete_group');
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(true);
	}
	
	function view_group()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_('TOOLBAR_VIEWGROUP') );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'publish_slide', 'publish.png', 'publish_f2.png', JText::_( 'TOOLBAR_B_PUBLISHSLIDE' ), true, false );
		JToolBarHelper::custom( 'unpublish_slide', 'unpublish.png', 'unpublish_f2.png', JText::_( 'TOOLBAR_B_UNPUBLISHSLIDE' ), true, false );
		JToolBarHelper::addNew( 'add_slide', JText::_( 'TOOLBAR_B_ADDSLIDE' ));
		JToolBarHelper::editListX( 'edit_slide', JText::_( 'TOOLBAR_B_EDITSLIDE' ));
		JToolBarHelper::deleteList( JText::_( 'TOOLBAR_B_REALLYWANTREMOVESLIDES' ), 'delete_slide');
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(true);
	}
	
	function add_plugin()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_('TOOLBAR_ADDPLUGIN') );
		JToolBarHelper::back();
		JToolBarHelper::save('save_plugin');
		JToolBarHelper::cancel( 'cancel_plugin', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, true);
	}
	
	function view_plugin()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_PLUGINS' ) );
		JToolBarHelper::back();
		JToolBarHelper::addNew( 'add_plugin', JText::_( 'TOOLBAR_B_INSTALLPLUGIN' ));
		JToolBarHelper::custom( 'enable_plugin', 'publish.png', 'publish_f2.png', JText::_( 'TOOLBAR_B_ENABLEPLUGINS' ), true );
		JToolBarHelper::custom( 'disable_plugin', 'unpublish.png', 'unpublish_f2.png', JText::_( 'TOOLBAR_B_DISABLEPLUGINS' ), true );
		JToolBarHelper::deleteListX( JText::_( 'TOOLBAR_B_REALLYWANTREMOVEPLUGINS' ), 'delete_plugin');
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, true);
	}
	
	function check_system()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_CHECKSYSTEM' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, false, false, true);
	}
	
	function help()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_HELP' ) );
		JToolBarHelper::back();
		$this->submenu(false, false, false, false, true);
	}
	
	function info()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_INFO' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, false, false, false, false, true);
	}
	
	function view_extension()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_EXTENSIONS' ) );
		JToolBarHelper::back();
		JToolBarHelper::addNew( 'add_extension', JText::_( 'TOOLBAR_B_INSTALLEXTENSION' ));
		JToolBarHelper::custom( 'enable_extension', 'publish.png', 'publish_f2.png', JText::_( 'TOOLBAR_B_ENABLEEXTENSIONS' ), true );
		JToolBarHelper::custom( 'disable_extension', 'unpublish.png', 'unpublish_f2.png', JText::_( 'TOOLBAR_B_DISABLEEXTENSIONS' ), true );
		JToolBarHelper::deleteListX( JText::_( 'TOOLBAR_B_REALLYWANTREMOVEEXTENSIONS' ), 'delete_extension');
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, false, true);
	}
	
	function add_extension()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_ADDEXTENSION' ) );
		JToolBarHelper::back();
		JToolBarHelper::save('save_extension');
		JToolBarHelper::cancel( 'cancel_extension', JText::_('CLOSE') );
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, false, true);
	}
	
	function news()
	{
		JToolBarHelper::title( 'Photoslide GK2 - '.JText::_( 'TOOLBAR_NEWS' ) );
		JToolBarHelper::back();
		JToolBarHelper::custom( 'help', 'help.png', 'help_f2.png', JText::_('HELP'), false, false );
		$this->submenu(false, false, false, false, false, false, true);
	}
	
	/*
		Method which shows submenu
		TRUE value means that this option is signed as actual option
	*/
	
	function submenu($p1 = false, $p2 = false, $p3 = false, $p4 = false, $p5 = false, $p6 = false, $p7 = false)
	{
		JSubMenuHelper::addEntry(JText::_('SUBMENU_GROUPS'), 'index.php?option=com_gk2_photoslide',$p1);
		JSubMenuHelper::addEntry(JText::_('SUBMENU_PLUGINS'), 'index.php?option=com_gk2_photoslide&task=view_plugin',$p2);
		JSubMenuHelper::addEntry(JText::_('SUBMENU_EXTENSIONS'), 'index.php?option=com_gk2_photoslide&task=view_extension',$p3);
		JSubMenuHelper::addEntry(JText::_('SUBMENU_CHECKSYSTEM'), 'index.php?option=com_gk2_photoslide&task=check_system',$p4);
		JSubMenuHelper::addEntry(JText::_('SUBMENU_HELP'), 'index.php?option=com_gk2_photoslide&task=help',$p5);
		JSubMenuHelper::addEntry(JText::_('SUBMENU_INFO'), 'index.php?option=com_gk2_photoslide&task=info',$p6);
		JSubMenuHelper::addEntry(JText::_('SUBMENU_NEWS'), 'index.php?option=com_gk2_photoslide&task=news',$p7);
	}
}

?>