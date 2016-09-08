<?php

/**
* @author: GavickPro
* @copyright: 2008
**/
	
// no direct access
defined('_JEXEC') or die('Restricted access');	
	// path for plugins (is too long)
	$PLUGINPATH = JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS;
	// getting task	
	$task = JRequest::getCmd( 'task' );
	// switching task	
	switch($task)
	{
		// Showing selected group	
		case 'view_group':
			// including file with Groups class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.groups.php');
			// creating new instance of Groups class
			$groups = new Groups();
			// empty string for group
			$plugin = ''; // this variable get value by reference
			// blank id
			$gid = 0; // this variable get value by reference
			// group initialization
			$rows = $groups->viewGroup($plugin, $gid);
			// loading view for this task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'view.group.php');
		break;
		// showing form to adding group	
		case 'add_group':
			// loading plugin list
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
			// loading correctly view
			if(isset($_GET['step']) || count($plugins) == 1)
			{
				// if user has installed only one plugin
				if(count($plugins) == 1)
				{
					// get this plugin automatically
					$plugin = $plugins[0]->value; 
				}
				else // in other situation
				{
					// get plugin name from GET variable
					$plugin	= JRequest::getCmd('plugin');
				}
				// including plugin class
				require_once($PLUGINPATH.substr($plugin,0,-4).DS.$plugin);
				// creating new instance of plugin class
				$pluginClass = new GKPlugin();
				// loading view for this task
				require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'add.group.php');
			}
			else
			{
				// If user have 0 or more than one plugin - load plugin list view
				require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'add.group.php');
			}
		break;		
		// saving group
		case 'save_group':
			// loading plugin name from GET variable
			$plugin	= JRequest::getCmd('plugin');
			// loading plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// get operation from plugin class
			$pluginClass->addGroup();
		break;
		// Canceling group operation
		case 'cancel_group':
			global $mainframe;
			// getting variables from GET vars	
			$option	= JRequest::getCmd('option');
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
			// Redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_('MAIN_ACTIONCANCELLED'), 'notice');
		break;	
		// editing group		
		case 'edit_group':
			// getting category ID
			$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
			// loading plugin name
			$db =& JFactory::getDBO();
			$query = '
			SELECT 
				p.phpclassfile AS phpclassfile 
			FROM 
				#__gk2_photoslide_groups AS g 
			LEFT JOIN 
				#__gk2_photoslide_plugins AS p 
				ON 
				g.plugin = p.name 
			WHERE 
				g.id='.$cid[0].';
			';
	
			$db->setQuery($query);
			// preparing variables
			foreach($db->loadObjectList() as $r)
			{
				$plugin = $r->phpclassfile;
			}
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// loading view for this task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'edit.group.php');
		break;
		// Saving edited group
		case 'apply_group':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running operation from plugin class
			$pluginClass->editGroup();
		break;
		// Applying edited group
		case 'a_group':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running operation from plugin class
			$pluginClass->editGroup(true);
		break;
		// Removing group
		case 'delete_group':
			// loading category ID
			$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
			// loading plugin
			$db =& JFactory::getDBO();
			$query = '
			SELECT 
				p.phpclassfile AS phpclassfile 
			FROM 
				#__gk2_photoslide_groups AS g 
			LEFT JOIN 
				#__gk2_photoslide_plugins AS p 
				ON 
				g.plugin = p.name 
			WHERE 
				g.id='.$cid[0].';
			';
			
			$db->setQuery($query);
			// preparing data
			foreach($db->loadObjectList() as $r)
			{
				$plugin = $r->phpclassfile;
			}
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running plugin operation
			$pluginClass->deleteGroup();
		break;
		// adding slide form	
		case 'add_slide':
			// getting plugin name from GET vars
			$plugin	= JRequest::getCmd('plugin');
			// including file with plugin class
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// getting group ID
			$gid = JRequest::getString( 'gid', '', 'get' );
			// loading view for task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'add.slide.php');
		break;
		// saving new slide
		case 'save_slide':
			// loading plugin name from GET vrs
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running plugin class operation
			$pluginClass->addSlide();
		break;			
		// canceling slide operation	
		case 'cancel_slide':
			global $mainframe;
			// getting variables from GET	
			$option	= JRequest::getCmd('option');
			$gid = JRequest::getString( 'gid', '', 'post' );
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cid='.$gid, JText::_('MAIN_ACTIONCANCELLED'), 'notice');
		break;
		// Editing slide form			
		case 'edit_slide':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// getting group id
			$gid = JRequest::getString( 'gid', '', 'get' );
			// loading view for this task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'edit.slide.php');
		break;
		// Saving edited slide
		case 'apply_slide':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running class operation
			$pluginClass->editSlide();
		break;	
		// Applying edited slide
		case 'a_slide':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running class operation
			$pluginClass->editSlide(true);
		break;
		// Removing slide
		case 'delete_slide':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class file
			require_once($PLUGINPATH.DS.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running class operation
			$pluginClass->deleteSlide();
		break;
		// Saving slide order
		case 'saveorder':
			// loading Groups class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.groups.php');
			// Creating new instance of Groups class
			$groups = new Groups();
			// saving changes
			$groups->order();
		break;
		// Publishing slide
		case 'publish_slide':
			// loading Groups class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.groups.php');
			// Creating new instance of Groups class
			$groups = new Groups();
			// saving changes
			$groups->publishSlide(1);
		break;
		// Unpublising slide
		case 'unpublish_slide':
			// loading Groups class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.groups.php');
			// Creating new instance of Groups class
			$groups = new Groups();
			// saving changes
			$groups->publishSlide(0);
		break;	
		// Access slide
		case 'access_slide':
			// loading Groups class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.groups.php');
			// Creating new instance of Groups class
			$groups = new Groups();
			// saving changes
			$groups->accessSlide($_GET['level']);
		break;
		// Showing check system site	
		case 'check_system':
			// including system checking class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.system.control.php');
			// creating new instance of SystemControl class
			$systemcheck = new SystemControl();
			// getting data from DB
			$systemcheck->DBStatus();
			// loading view for task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'system.check.php');
		break;
		// Showing plugins list	
		case 'view_plugin':
			// including Plugins class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.plugins.php');
			// creating new instance of Plugins class
			$plugins = new Plugins();
			// Running class operation
			$plugins->viewPlugins();
		break;
		// Showing form to adding plugin
		case 'add_plugin':
			// including Plugins class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.plugins.php');
			// creating new instance of Plugins class
			$plugins = new Plugins();
			// Running class operation
			$plugins->addPlugin();
		break;
		// Saving plugin	
		case 'save_plugin':
			// including Plugins class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.plugins.php');
			// creating new instance of Plugins class
			$plugins = new Plugins();
			// Running class operation
			$plugins->savePlugin();
		break;
		// Canceling plugin operation
		case 'cancel_plugin':
			global $mainframe;
			// Getting variables from GET storage	
			$option	= JRequest::getCmd('option');
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
			// Redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('MAIN_ACTIONCANCELLED'), 'notice');
		break;
		// Enabling plugin	
		case 'enable_plugin':
			// including Plugins class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.plugins.php');
			// creating new instance of Plugins class
			$plugins = new Plugins();
			// Running class operation
			$plugins->enablePlugin();		
		break;
		// Disabling plugin
		case 'disable_plugin':
			// including Plugins class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.plugins.php');
			// creating new instance of Plugins class
			$plugins = new Plugins();
			// Running class operation
			$plugins->disablePlugin();
		break;	
		// Deinstalling plugin			
		case 'delete_plugin':
			// including Plugins class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.plugins.php');
			// creating new instance of Plugins class
			$plugins = new Plugins();
			// Running class operation
			$plugins->deletePlugin();
		break;	
		// Showing extensions
		case 'view_extension':
			// including Extensions class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.extensions.php');
			// creating new instance of Extensions class
			$extensions = new Extensions();
			// Running class operation
			$extensions->viewExtensions();
		break;
		// Showing adding extension form
		case 'add_extension':
			// including Extensions class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.extensions.php');
			// creating new instance of Extensions class
			$extensions = new Extensions();
			// Running class operation
			$extensions->addExtension();
		break;
		// Saving extension
		case 'save_extension':
			// including Extensions class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.extensions.php');
			// creating new instance of Extensions class
			$extensions = new Extensions();
			// Running class operation
			$extensions->saveExtension();
		break;
		// Cancel extension operation
		case 'cancel_extension':
			global $mainframe;
			// Getting GET variables	
			$option	= JRequest::getCmd('option');
			$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
			// Redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('MAIN_ACTIONCANCELLED'), 'notice');
		break;
		// Enabling extension
		case 'enable_extension':
			// including Extensions class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.extensions.php');
			// creating new instance of Extensions class
			$extensions = new Extensions();
			// Running class operation
			$extensions->enableExtension();	
		break;
		// Disabling extension
		case 'disable_extension':
			// including Extensions class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.extensions.php');
			// creating new instance of Extensions class
			$extensions = new Extensions();
			// Running class operation
			$extensions->disableExtension();
		break;	
		// Deinstalling extension		
		case 'delete_extension':
			// including Extensions class
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.extensions.php');
			// creating new instance of Extensions class
			$extensions = new Extensions();
			// Running class operation
			$extensions->deleteExtension();
		break;
		// Showing help page
		case 'help':
			// loading view for task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'help.php');
		break;
		// Showing info page
		case 'info':
			// loading view for task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'info.php');
		break;
		// Storage operation in extensions
		case 'storage':
			// Loading extension name
			$ext = JRequest::getCmd('ext');
			// Including extension class file
			require_once(JPATH_COMPONENT.DS.'configuration'.DS.'extensions'.DS.$ext.DS.$ext);
			// Creating new instance of extension class
			$extClass = new GKExtension();
			// Running class operation
			$extClass->storage();
		break;
		// Slide preview
		case 'preview_slide':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running class operation
			$pluginClass->previewSlide();
		break;
		// Group preview
		case 'preview_group':
			// loading plugin name
			$plugin	= JRequest::getCmd('plugin');
			// including plugin class
			require_once($PLUGINPATH.substr($plugin, 0, -4).DS.$plugin);
			// creating new instance of plugin class
			$pluginClass = new GKPlugin();
			// running class operation
			$pluginClass->previewGroup();
		break;
		// Showing component stats
		case 'news':
			// including Stats class file
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.news.php');
			// creating new instance of Groups class
			$news = new News();
			// getting groups data
			$results = $news->newsRSS();
			// loading view for task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'view.news.php');
		break;
		// Default operation - showing groups		
		default:
			// including Groups class file
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.'class.groups.php');
			// creating new instance of Groups class
			$groups = new Groups();
			// getting groups data
			$rows = $groups->viewGroups();
			// loading view for task
			require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'view.groups.php');
		break;
	}		
?>