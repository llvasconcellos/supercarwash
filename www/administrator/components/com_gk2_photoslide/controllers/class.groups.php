<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	Class Groups
	- Shows all groups
	- Shows selected group
	- Saving slide order
	Uses:
	- view.groups.php
	- view.group.php	
**/

class Groups
{
	// Showing all groups
	function viewGroups()
	{
		// initializing DB interface
		$db =& JFactory::getDBO();
		// SQL query
		$query = '
		SELECT 
			g.id AS id, 
			g.name AS name, 
			g.plugin AS plugin, 
			p.status AS status, 
			p.phpclassfile AS pfile,
			COUNT( DISTINCT s.id ) AS amount 
		FROM 
			#__gk2_photoslide_groups AS g 
		LEFT JOIN 
			#__gk2_photoslide_slides AS s 
			ON 
			s.group_id = g.id 
		LEFT JOIN 
			#__gk2_photoslide_plugins AS p 
			ON 
			g.plugin = p.name 
		GROUP BY 
			g.id;';
		// run SQL query	
		$db->setQuery($query);
		// return results of SQL query
		return $db->loadObjectList();
	}
	// Showing selected group
	function viewGroup(& $plugin, & $gid)
	{
		// basic variables
		$db =& JFactory::getDBO();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$gid = (isset($_GET['cids'])) ? $_GET['cids'] : $cid[0];
		// preparing SQL query
		$query = '
		SELECT 
			p.phpclassfile AS file 
		FROM 
			#__gk2_photoslide_plugins AS p 
		LEFT JOIN 
			#__gk2_photoslide_groups AS g 
			ON 
			g.plugin = p.name 
		WHERE 
			g.id = '.$gid.';';
		// set qery
		$db->setQuery($query);
		// if SQL query returns some data
		if($db->loadObjectList())
		{
			// set plugin name
			foreach($db->loadObjectList() as $r)
			{ 
				$plugin = $r->file;
			}
		}
		// Preparing second query
		$query = '
		SELECT 
			`id`, 
			`name`,
			`published`, 
			`access`,
			`file`, 
			`order` 
		FROM 
			#__gk2_photoslide_slides 
		WHERE 
			group_id = '.$gid.' 
		ORDER BY 
			`order`;';
		// set query
		$db->setQuery($query);
		// returns query results
		return $db->loadObjectList();
	}
	// Saving slide order
	function order()
	{
		global $mainframe, $option;
		// basic variables
		$db	 = & JFactory::getDBO();
		$order = JRequest::getVar( 'order', array (0), 'get', 'array' );
		$gid = JRequest::getString( 'gid', '', 'get' );
		// make query
		$query = '
		SELECT 
			* 
		FROM 
			#__gk2_photoslide_slides 
		WHERE 
			group_id = '.$gid.' 
		ORDER BY 
			`order` ASC;';
		$db->setQuery($query);
		// creating array of query results
		$rows = array();
		// storage query results in $rows variable
		foreach($db->loadObjectList() as $row)
		{
			array_push($rows, array(
				"rorder" => $row->order, 
				"rid" => $row->id
			));
		}
		// for each array element mak
		for($j = 0; $j < count($rows); $j++){
			// actualization of slide
			$query = '
					UPDATE 
						#__gk2_photoslide_slides 
					SET 
						`order` = '.$order[$j].' 
					WHERE 
						id = '.$rows[$j]["rid"].';';
			// make query
			$db->setQuery($query);
			$db->query();
		}
		// Rediredct
		$mainframe->enqueueMessage( JText::_('CG_ORDERSAVED') );		
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$gid);
	}
	// Publishing slide
	function publishSlide($mode)
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		// getting group id
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		// preparing place for WHERE clause	
		$where_clause = '';
		// adding data for clause
		for($i = 1; $i < count($cid); $i++)
		{
			$where_clause .= ' OR id = '.$cid[$i];	
		} 
		// preparing SQL query
		$query = '
		UPDATE 
			#__gk2_photoslide_slides 
		SET 
			published = '.$mode.' 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		// make SQL query
		$db->setQuery($query);
		$db->query();
		// Redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_GET['gid'], JText::_('CG_SLIDES'.(($mode)?'':'UN').'PUBLISHED'));
	}
	// Access slide
	function accessSlide($mode)
	{
		global $mainframe;
		// basic variables
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$db		=& JFactory::getDBO();
		// getting group id
		$cid  = JRequest::getVar( 'cid', array(0), '', 'array' );
		// preparing SQL query
		$query = '
		UPDATE 
			#__gk2_photoslide_slides 
		SET 
			access = '.$mode.' 
		WHERE 
			id = '.$cid[0].';
		';
		// make SQL query
		$db->setQuery($query);
		$db->query();
		// Redirect
		$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_GET['gid'], JText::_('CG_SLIDESACCESSCHANGED'));
	}
}

?>