<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	Class Extensions
	- extensions installation
	- enabling extension
	- disabling extensions
	- extensions deinstallation	
	Uses:
	- extension.add.php
	- extension.view.php
	
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class Extensions
{
	// Showing extensions list
	function viewExtensions()
	{
		// preparing DB interface
		$db =& JFactory::getDBO();
		// preparing SQL query
		$query = "
			SELECT 
				* 
			FROM 
				#__gk2_photoslide_extensions 
			ORDER BY 
				id ASC;";
		// make SQL query
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		// including view for task
		require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'view.extension.php');
	}
	// Showing adding extension form
	function addExtension()
	{
		// including form
		require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'add.extension.php');
	}
	// Installing extension
	function saveExtension()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// getting information about uploaded package
		$userfile = JRequest::getVar('install_zip', null, 'files', 'array' );
		// Checking PHP uploading option
		if (!(bool) ini_get('file_uploads'))
		{ 
			// Redirect if disabled
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_UPLOADPHPDISABLED'),'error');
		}

		// Checking existing of file
		if (!is_array($userfile) )
		{
			// Redirect if user didn't select file to upload
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_NOFILE'),'error');
		}

		// Checking upload errors and file size
		if ( $userfile['error'] || $userfile['size'] < 1 )
		{ 
			// Redirect if errors extisted or file is to big
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_UPLOADERRORORFILETOBIG'),'error');
		}
		// including classes JFile, JFolder and JArchive
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.archive');
		// Creating paths
		$tmp_dest = JPATH_COMPONENT.DS.'configuration'.DS.'extensions'.DS;
		$tmp_src = $userfile['tmp_name'];
		$folder_name = str_replace('.zip', '', $userfile['name']);
		// creating extension folder
		JFolder::create($tmp_dest.$folder_name, 0755);
		// moving extension file to new directory or redirect
		if(!JFile::upload($tmp_src, $tmp_dest.DS.$folder_name.DS.$userfile['name']))
		{
			// if error
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JError::raiseWarning('103', JText::_('CE_ERORMOVINGFILE')), 'error');
		}
		else
		{
			if(strpos($userfile['name'], 'ext_') !== FALSE)
			{
				// If all is OK - extract package
				if(!JArchive::extract($tmp_dest.DS.$folder_name.DS.$userfile['name'], $tmp_dest.DS.$folder_name.DS))
				{
					// if problem with extract - remove package
					JFile::delete($tmp_dest.DS.$folder_name.DS.$userfile['name']);
					// redirect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_("CE_UNPACKERROR"), 'error');
				}
				// removing package after extracting
				JFile::delete($tmp_dest.DS.$folder_name.DS.$userfile['name']);
				// loading new instance of JURI class
				$url = & JURI::getInstance();
				// loading DB interface
				$db =& JFactory::getDBO();
				// loading XML parser
				$xml = & JFactory::getXMLParser('Simple');
				// If XML file exists
				if ($xml->loadFile($tmp_dest.DS.$folder_name.DS.$folder_name.'.xml'))
				{
					// reading data from XML extension file
					$name = & $xml->document->name[0]->data();
					$type = & $xml->document->type[0]->data();
					$version = & $xml->document->version[0]->data();
					$author = & $xml->document->author[0]->data();
					$description = & $xml->document->description[0]->data();
					$filename = $folder_name.'.xml';
					$phpclassfile = $xml->document->phpclassfile[0]->data();
					// inserting extension data
					$query = '
					INSERT INTO 
						#__gk2_photoslide_extensions 
					VALUES(
						DEFAULT, 
						"'.$name.'", 
						0, 
						"'.$type.'", 
						"'.$filename.'",
						"'.$phpclassfile.'", 
						"'.$version.'", 
						"'.$author.'",
						"'.$description.'", 
						""
					);';
					// set query
					$db->setQuery($query);
					// if query is incorrect
					if(!$db->query())
					{
						// redirect
						$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_("CE_QUERYERROR"), 'error');	
					}		
				}
				else // if XML file doesn't exists
				{
					// reidrect
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_("CE_CANNOTFINDXMLFILE"), 'error');	
				}
				// When all is OK - redirect
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_INSTALLSUCCESSFUL'));
			}
			else
			{
				// When it is not a extension
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_NOTEXTENSION'));
			}
		}	
	}
	// Enabling extension
	function enableExtension()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		// getting extension id
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		// preparing place for WHERE clause
		$where_clause = '';
		// adding content for WHERE clause
		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause .= ' OR id = '.$cid[$i];	
		} 
		// preparing SQL query
		$query = '
		UPDATE 
			#__gk2_photoslide_extensions 
		SET 
			status = 1 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		// make SQL query
		$db->setQuery($query);
		$db->query();
		// Redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_EXTENSIONENABLED'));
	}
	// Disabling extensions
	function disableExtension()
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		// getting extension id
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		// preparing place for WHERE clause
		$where_clause = '';
		// adding content for WHERE clause
		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause .= ' OR id = '.$cid[$i];	
		} 
		// preparing SQL query
		$query = '
		UPDATE 
			#__gk2_photoslide_extensions 
		SET 
			status = 0 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		// make SQL query
		$db->setQuery($query);
		$db->query();
		// Redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_EXTENSIONDISABLED'));
	}
	// Deinstalling extension
	function deleteExtension()
	{
		global $mainframe;
		// basic variables
		$option	=  JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		// getting extension ID
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		// preparing place for WHERE clause
		$where_clause = '';
		// adding content to WHERE clause
		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause .= ' OR id = '.$cid[$i];		
		}
		// preparing SQL query
		$query = '
		SELECT 
			filename 
		FROM 
			#__gk2_photoslide_extensions 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		// set query
		$db->setQuery($query);
		// checking query results
		if($db->loadObjectList())
		{
			// loading files
			foreach($db->loadObjectList() as $r)
			{
				// add informations about paths to ZIP array
				$f_zip[] = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_gk2_photoslide'.DS.'configuration'.DS.'extensions'.DS.substr($r->filename, 0, -4);
			}
		}
		else // if query has blank
		{
			// redirect
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_("CE_CANNOTFINDEXT"), 'error');
		}		
		// reading plugin configuration
		$query = '
		DELETE FROM 
			#__gk2_photoslide_extensions 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		// setting query	
		$db->setQuery($query);
		// if error in query		
		if(!$db->query()){
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_("CE_CANNOTREMOVEEXT"), 'error');	
		}
		// including JFolder class
		jimport('joomla.filesystem.folder');
		// flag - folder removing error
		$delete_error = false;
		// removing folders
		for($y = 0; $y < count($f_zip); $y++)
		{
			// if error - change flag
			if(!JFolder::delete( $f_zip[$y] )) $delete_error = true;
		}
		// when removing error
		if($delete_error)
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_("CE_CANNOTREMOVEFOLDER"), 'error');
		}
		// When all is OK - redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_extension', JText::_('CE_EXTREMOVED'.$a));
	}		
}

?>