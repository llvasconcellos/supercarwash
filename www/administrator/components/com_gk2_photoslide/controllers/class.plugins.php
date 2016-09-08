<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	Class Plugins
	- plugins install
	- plugins enabling
	- plugins disabling
	- plugins deinstall
	
	Uses:
	- plugins.add.php
	- plugins.view.php
	
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class Plugins
{
	// All plugins
	function viewPlugins()
	{
		$db =& JFactory::getDBO();

		$query = "
			SELECT 
				* 
			FROM 
				#__gk2_photoslide_plugins 
			ORDER BY 
				id ASC;";
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		// load view for task
		require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'view.plugin.php');
	}
	
	// plugin install form
	function addPlugin()
	{
		// load view for task
		require_once(JPATH_COMPONENT.DS.'views'.DS.'admin'.DS.'add.plugin.php');
	}
	// installing plugin - simply to saveExtension	
	function savePlugin()
	{
		global $mainframe;
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$userfile = JRequest::getVar('install_zip', null, 'files', 'array' );
		
		if (!(bool) ini_get('file_uploads'))
		{ 
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_UPLOADPHPDISABLED'),'error');
		}
		
		if (!is_array($userfile) )
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_NOFILE'),'error');
		}

		if ( $userfile['error'] || $userfile['size'] < 1 )
		{ 
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_UPLOADERRORORFILETOBIG'),'error');
		}
		
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.archive');

		$tmp_dest = JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS;
		$tmp_src = $userfile['tmp_name'];
		$folder_name = str_replace('.zip', '', $userfile['name']);
		
		JFolder::create($tmp_dest.$folder_name, 0755);
	
		if(!JFile::upload($tmp_src, $tmp_dest.DS.$folder_name.DS.$userfile['name']))
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JError::raiseWarning('103', JText::_('CP_ERORMOVINGFILE')), 'error');
		}
		else
		{
			if(strpos($userfile['name'], 'plg_') !== FALSE)
			{
				if(!JArchive::extract($tmp_dest.DS.$folder_name.DS.$userfile['name'], $tmp_dest.DS.$folder_name.DS))
				{
					JFile::delete($tmp_dest.DS.$folder_name.DS.$userfile['name']);
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_UNPACKERROR"), 'error');
				}
				
				JFile::delete($tmp_dest.DS.$folder_name.DS.$userfile['name']);
				$url = & JURI::getInstance();
				$db =& JFactory::getDBO();
				$xml = & JFactory::getXMLParser('Simple');
				
				if ($xml->loadFile($tmp_dest.DS.$folder_name.DS.$folder_name.'.xml'))
				{
					$name = & $xml->document->name[0]->data();
					$type = & $xml->document->type[0]->data();
					$version = & $xml->document->version[0]->data();
					$author = & $xml->document->author[0]->data();
					$description = & $xml->document->description[0]->data();
					$filename = $folder_name.'.xml';
					$phpclassfile = $xml->document->phpclassfile[0]->data();
					
					$gfields = '';
					$sfields = '';
					$reserved_gfields = '';
					$reserved_sfields = '';
					
					$query = '
					SELECT 
						gfields,
						sfields 
					FROM 
						#__gk2_photoslide_plugins;
					';
					$db->setQuery($query);
					$results = $db->loadObjectList();
	
					foreach($results as $result)
					{
						$reserved_gfields .= $result->gfields.',';
						$reserved_sfields .= $result->sfields.',';
					}
					
					$reserved_gfields = substr($reserved_gfields,0,(strlen($reserved_gfields)-1));
					$reserved_sfields = substr($reserved_sfields,0,(strlen($reserved_sfields)-1));
					
					$reserved_gfields = explode(',',$reserved_gfields);
					$reserved_sfields = explode(',',$reserved_sfields);
					
					$gfields = '';
					$sfields = '';
					
					$groupdb = & $xml->document->groupdb[0];
					
					if($groupdb)
					{
						for($i = 0; isset($groupdb->field[$i]); $i++)
						{
							$field_name = $groupdb->field[$i]->name[0]->data();
							$field_type = $groupdb->field[$i]->type[0]->data();
							$field_default = $groupdb->field[$i]->default[0]->data();
							
							$gfields .= $field_name.',';
							
							if(!in_array($field_name, $reserved_gfields))
							{
								$query = "
								ALTER TABLE 
									#__gk2_photoslide_groups 
									ADD 
									`".$field_name."` ".$field_type." NOT NULL DEFAULT ".$field_default.";
								";
								
								$db->setQuery($query);
								
								if(!$db->query())
								{
									$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_CANNOTADDNEWCOLUMN").$query, 'error');	
								}
							}
						}
					}	
					
					$slidedb = & $xml->document->slidedb[0];
					
					if($slidedb)
					{
						for($i = 0; isset($slidedb->field[$i]); $i++)
						{
							$field_name = $slidedb->field[$i]->name[0]->data();
							$field_type = $slidedb->field[$i]->type[0]->data();
							$field_default = $slidedb->field[$i]->default[0]->data();
							
							$sfields .= $field_name.',';
							
							if(!in_array($field_name, $reserved_sfields))
							{
								$query = "
								ALTER TABLE 
									#__gk2_photoslide_slides 
									ADD 
									`".$field_name."` ".$field_type." NOT NULL DEFAULT ".$field_default.";
								";
								
								$db->setQuery($query);
								
								if(!$db->query())
								{
									$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_CANNOTADDNEWCOLUMN").$query, 'error');	
								}
							}
						}
					}				
					
					$gfields = substr($gfields,0,(strlen($gfields)-1));
					$sfields = substr($sfields,0,(strlen($sfields)-1));
					
					$query = '
					INSERT INTO 
						#__gk2_photoslide_plugins 
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
						"'.$gfields.'", 
						"'.$sfields.'"
					);';
					
					$db->setQuery($query);
					
					if(!$db->query())
					{
						$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_QUERYERROR"), 'error');	
					}
					
				}
				else
				{
					$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_CANNOTFINDXMLFILE"), 'error');	
				}
				
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_INSTALLSUCCESSFUL'));
			}
			else
			{
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_NOTPLUGIN'));
			}
		}	
	}
	// enabling plugin simply to enabling extension
	function enablePlugin()
	{
		global $mainframe;
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		
		$where_clause = '';
		
		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause .= ' OR id = '.$cid[$i];	
		} 
	
		$query = '
		UPDATE 
			#__gk2_photoslide_plugins 
		SET 
			status = 1 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		
		$db->setQuery($query);
		$db->query();
		
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_PLUGINENABLED'));
	}
	
	// Disabling plugin simply to disabling extension
	function disablePlugin()
	{
		global $mainframe;
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		
		$where_clause = '';
		
		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause .= ' OR id = '.$cid[$i];	
		} 
		
		$query = '
		UPDATE 
			#__gk2_photoslide_plugins 
		SET 
			status = 0 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		
		$db->setQuery($query);
		$db->query();
		
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_PLUGINDISABLED'));
	}
	
	// Deinstalling plugin simply to deinstalling extension
	function deletePlugin()
	{
		global $mainframe;
		$option	=  JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		$gfields = '';
		$sfields = '';
		$reserved_gfields = '';
		$reserved_sfields = '';
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		
		$where_clause1 = '';
		$where_clause2 = '';
		$where_clause3 = '';

		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause1 .= ' OR id = '.$cid[$i];	
			$where_clause2 .= ' AND id != '.$cid[$i];
			$where_clause3 .= ' OR p.id = '.$cid[$i];	
		}
		
		$query = '
		SELECT 
			filename, 
			phpclassfile, 
			gfields, 
			sfields 
		FROM 
			#__gk2_photoslide_plugins 
		WHERE 
			(id = '.$cid[0].' '.$where_clause1.');
		';
		
		$db->setQuery($query);
		
		if($db->loadObjectList())
		{
			foreach($db->loadObjectList() as $r)
			{
				$f_zip[] = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_gk2_photoslide'.DS.'configuration'.DS.'plugins'.DS.substr($r->filename, 0, -4);
				$gfields .= $r->gfields.",";
				$sfields .= $r->sfields.",";
			}
			//
			$gfields = substr($gfields,0,(strlen($gfields)-1));
			$sfields = substr($sfields,0,(strlen($sfields)-1));
			$gfields = explode(',',$gfields);
			$sfields = explode(',',$sfields);
		}
		else
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_NOTFOUND"), 'error');
		}
		
		$query = '
		SELECT 
			gfields, 
			sfields 
		FROM 
			#__gk2_photoslide_plugins 
		WHERE 
			(id != '.$cid[0].' '.$where_clause2.');
		';
		
		$db->setQuery($query);
		
		foreach($db->loadObjectList() as $row)
		{
			$reserved_gfields .= $row->gfields.',';
			$reserved_sfields .= $row->sfields.',';
		}
		//
		$reserved_gfields = substr($reserved_gfields,0,(strlen($reserved_gfields)-1));
		$reserved_sfields = substr($reserved_sfields,0,(strlen($reserved_sfields)-1));		
		$reserved_gfields = explode(',',$reserved_gfields);
		$reserved_sfields = explode(',',$reserved_sfields);
			//	
			$gfields = array_unique($gfields);	
			//	
			for($i = 0; $i < count($gfields); $i++)
			{
				if(!in_array($gfields[$i], $reserved_gfields))
				{
					$query = "
					ALTER TABLE 
						#__gk2_photoslide_groups 
					DROP 
						`".$gfields[$i]."`;";	
					$db->setQuery($query);
						
					if(!$db->query()){
						$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_NOTREMOVEDCOLUMN").$query, 'error');	
					}
				}
			}
			//
			$sfields = array_unique($sfields);	
			//	
			for($i = 0; $i < count($sfields); $i++)
			{
				if(!in_array($sfields[$i], $reserved_sfields))
				{
					$query = "
					ALTER TABLE 
						#__gk2_photoslide_slides 
					DROP 
						`".$sfields[$i]."`;
					";
						
					$db->setQuery($query);
						
					if(!$db->query())
					{
						$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_NOTREMOVEDCOLUMN").$query, 'error');	
					}
				}
			}

		$query = '
		SELECT 
			g.id AS id, 
			p.filename AS file 
		FROM 
			#__gk2_photoslide_groups AS g 
		LEFT JOIN 
			#__gk2_photoslide_plugins AS p 
			ON 
			g.plugin = p.name 
		WHERE 
			(p.id = '.$cid[0].' '.$where_clause3.') 
		ORDER BY 
			p.name;
		';		
		
		$db->setQuery($query);	

		if($db->loadObjectList())
		{
			$actual_file = '';
			foreach($db->loadObjectList() as $r)
			{
				require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.substr($r->file,0,-4).DS.substr($r->file,0,-4).'.php');
				if($actual_file != $r->file) 
				{
					unset($pluginClass);
					$pluginClass = new GKPlugin();
				}
				$pluginClass->deleteGroup($r->id);	
			}
		}	
		// wczytanie konfiguracji pluginu do bazy danych
		$query = '
		DELETE FROM 
			#__gk2_photoslide_plugins 
		WHERE 
			(id = '.$cid[0].' '.$where_clause1.');
		';	
		$db->setQuery($query);
				
		if(!$db->query()){
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_NOTREMOVEDDATA"), 'error');	
		}

		jimport('joomla.filesystem.folder');
		$delete_error = false;

		for($y = 0; $y < count($f_zip); $y++)
		{
			if(!JFolder::delete( $f_zip[$y] )) $delete_error = true;
		}
		
		if($delete_error)
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_("CP_NOTREMOVEDFILES"), 'error');
		}	
		// redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_plugin', JText::_('CP_SUCCESS'));
	}	
}

?>