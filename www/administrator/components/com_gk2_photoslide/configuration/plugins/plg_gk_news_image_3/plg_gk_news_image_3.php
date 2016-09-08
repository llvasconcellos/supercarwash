<?php

/**
* @author: GavickPro
* @copyright: 2008
**/
	
// no direct access
defined('_JEXEC') or die('Restricted access');	

class GKPlugin
{	
	// Importing language file
	function importLang()
	{
		jimport('joomla.language.helper');
		jimport('joomla.filesystem.file');
		$lang = JLanguageHelper::detectLanguage();
		// finding default language file - if not exist then select en-GB file
		if(JFile::exists(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'language'.DS.$lang.'.lang.php')){
			require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'language'.DS.$lang.'.lang.php');
		}else{
			require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'language'.DS.'en-GB.lang.php');
		}
	}
	
	// Adding group form
	function addGroupForm()
	{
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// showing form
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'views'.DS.'add.group.php');
	}	

	// Adding group
	function addGroup()
	{
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// getting plugin name		
		global $mainframe;
		$db =& JFactory::getDBO();
		$plugin	= JRequest::getCmd('plugin');
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		
		$query = '
		SELECT 
			name 
		FROM 
			#__gk2_photoslide_plugins 
		WHERE 
			phpclassfile = "'.$plugin.'";
		';
		$db->setQuery($query);
		// getting name
		foreach($db->loadObjectList() as $r)
		{
			$plugin_name = $r->name;
		}
		// insert query
		$query = '
		INSERT INTO 
			#__gk2_photoslide_groups 
		SET 
			`name` = "'.$_POST['name'].'", 
			`plugin` = "'.$plugin_name.'", 
			`mediumThumbX` = '.$_POST['mediumThumbX'].', 
			`mediumThumbY` = '.$_POST['mediumThumbY'].', 
			`smallThumbX` = '.$_POST['smallThumbX'].', 
			`smallThumbY` = '.$_POST['smallThumbY'].', 
			`bgcolor` = "'.$_POST['bgcolor'].'", 
			`titlecolor` = "'.$_POST['titlecolor'].'", 
			`textcolor` = "'.$_POST['textcolor'].'", 
			`linkcolor` = "'.$_POST['linkcolor'].'", 
			`hlinkcolor` = "'.$_POST['hlinkcolor'].'",
			`quality` = "'.$_POST['quality'].'";
		';
		
		$db->setQuery($query);
		// redirects
		if($db->query()){
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->GROUP_ADDED_CORECTLY));	
		}else{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->ERROR_WHEN_ADDING_GROUP . $query), 'error');
		}	
	}
	// Editing group form
	function editGroupForm()
	{
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// getting group ID
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		// running SQL query
		$db =& JFactory::getDBO();	
		$db->setQuery("SELECT * FROM #__gk2_photoslide_groups WHERE id = ".$cid[0]." LIMIT 1;");
		// preparing data
		foreach($db->loadObjectList() as $r){
			$name = $r->name;
			$mediumThumbX = $r->mediumThumbX;
			$mediumThumbY = $r->mediumThumbY;
			$smallThumbX = $r->smallThumbX;
			$smallThumbY = $r->smallThumbY;
			$bgcolor = $r->bgcolor;
			$titlecolor = $r->titlecolor;
			$textcolor = $r->textcolor;
			$linkcolor = $r->linkcolor;
			$hlinkcolor = $r->hlinkcolor;
			$quality = $r->quality;
		}
		// showing form
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'views'.DS.'edit.group.php');
	}	
	// Editing group	
	function editGroup($apply = false){
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		global $mainframe;
		// importing image class
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'class.image.php');
		$img = new Image();
		$db =& JFactory::getDBO();
		$plugin	= JRequest::getCmd('plugin');
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// getting data
		$query = '
		SELECT 
			file, 
			stretch 
		FROM 
			#__gk2_photoslide_slides 
		WHERE 
			group_id = '.$_POST['gid'].';
		';
		$db->setQuery($query);
		// convert arrays
		$files = array();
		$stretches = array();
		// preparing datas
		foreach($db->loadObjectList() as $r){
			$files[] = $r->file;
			$stretches[] = $r->stretch;
		}	
		// creating thumbnails
		for($i = 0; $i < count($files); $i++){
			$img->createThumbnail(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.$files[$i], $files[$i],$_POST['mediumThumbX'],$_POST['mediumThumbY'],'m',$stretches[$i],$_POST['bgcolor'],JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS, $_POST['quality']);
			
			$img->createThumbnail(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.$files[$i], $files[$i],$_POST['smallThumbX'],$_POST['smallThumbY'],'s',$stretches[$i],$_POST['bgcolor'],JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS, $_POST['quality']);
		}
		// setting data in DB
		$query = '
		UPDATE 
			#__gk2_photoslide_groups 
		SET 
			`name` = "'.$_POST['name'].'", 
			`quality` = "'.$_POST['quality'].'",
			`mediumThumbX` = '.$_POST['mediumThumbX'].', 
			`mediumThumbY` = '.$_POST['mediumThumbY'].', 
			`smallThumbX` = '.$_POST['smallThumbX'].', 
			`smallThumbY` = '.$_POST['smallThumbY'].', 
			`bgcolor` = "'.$_POST['bgcolor'].'", 
			`titlecolor` = "'.$_POST['titlecolor'].'", 
			`textcolor` = "'.$_POST['textcolor'].'", 
			`linkcolor` = "'.$_POST['linkcolor'].'", 
			`hlinkcolor` = "'.$_POST['hlinkcolor'].'" 
		WHERE 
			id = '.$_POST['gid'].';
		';
		
		$db->setQuery($query);
		// if query is wrong
		if($db->query()){
			if($apply)
			{
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=edit_group&cid[]='.$_POST['gid'], JText::_($LANG->GROUP_EDITED));
			}
			else
			{
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->GROUP_EDITED));
			}	
		}else{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->GROUP_EDIT_ERROR . $query), 'error');
		}		
	}
	// Removing group
	function deleteGroup($gid = 0){
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// basic classes and variables		
		global $mainframe;
		$db =& JFactory::getDBO();
		$plugin	= JRequest::getCmd('plugin');
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		$where_clause1 = '';
		$where_clause2 = '';
		
		if($gid == 0)
		{
			for($i = 1; $i < count($cid); $i++)
			{
				$where_clause1 .= ' OR group_id = '.$cid[$i];	
				$where_clause2 .= ' OR id = '.$cid[$i];	
			}
		}
		else
		{
			$cid[0] = $gid;
		}	
		
		$query = '
		SELECT 
			id 
		FROM 
			#__gk2_photoslide_slides 
		WHERE 
			(group_id = '.$cid[0].' '.$where_clause1.');
		';
		
		$db->setQuery($query);
		// IDs array
		$ids = array();
		
		foreach($db->loadObjectList() as $r) 
		{
			$ids[] = $r->id;
		}

		jimport('joomla.filesystem.file');
		
		for($i = 0; $ids[$i]; $i++)
		{
			$this->deleteSlide($ids[$i], false);
		}
		
		$query = '
		DELETE FROM 
			#__gk2_photoslide_groups 
		WHERE 
			(id = '.$cid[0].' '.$where_clause2.');
		';
		
		$db->setQuery($query);
		
		if(!$db->query())
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->ERROR_REMOVING_GROUP . $query), 'error');
		}		
		
		$query = '
		DELETE FROM 
			#__gk2_photoslide_slides 
		WHERE 
			(group_id = '.$cid[0].' '.$where_clause1.');
		';
		
		$db->setQuery($query);
		
		if($db->query())
		{
			if($gid == 0)
			{
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->REMOVED_GROUP));
			}	
		}
		else
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_groups', JText::_($LANG->ERROR_REMOVING_GROUP . $query), 'error');
		}	
	}
	// Adding slide form
	function addSlideForm(){
		// importing language file
		$this->importLang();
		$LANG = new GKLang();		
		// creating articles list
		$db =& JFactory::getDBO();	
		$db->setQuery( 'SELECT a.`id` AS `id` , a.`title` AS `art_title`, k.`title` AS `cat_name` FROM `#__content` AS `a` LEFT JOIN `#__categories` AS `k` ON a.`catid` = k.`id` ORDER BY k.`title` ASC;' );
		// showing form
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'views'.DS.'add.slide.php');
	}
	// adding slide
	function addSlide(){
		unset($LANG);
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// basic variables		
		global $mainframe;	
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'class.image.php');
		$img = new Image();
		$db =& JFactory::getDBO();
		$plugin	= JRequest::getCmd('plugin');
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// SQL query
		$query = '
		SELECT 
			`order` 
		FROM 
			#__gk2_photoslide_slides 
		WHERE 
			group_id = '.$_POST['gid'].' 
		ORDER BY 
			`order` DESC 
		LIMIT 
			1;
		';
		// max order value
		$maxorder = $db->getRow($query);
		$maxorder = $maxorder[0];
		// group settings
		$query = 'SELECT * FROM #__gk2_photoslide_groups WHERE id = '.$_POST['gid'].';';
		$db->setQuery($query);
		// escape datas
		foreach($db->loadObjectList() as $r){
			$quality = $r->quality;
			$bg = $r->bgcolor;
			$mW = $r->mediumThumbX;
			$mH = $r->mediumThumbY;
			$sW = $r->smallThumbX;
			$sH = $r->smallThumbY;
		}
		// uploading image
		$hash = $img->upload($mW, $mH, $sW, $sH, $bg, $quality);
		// injecting data in DB
		$query = '
		INSERT INTO 
			#__gk2_photoslide_slides 
		SET 
			`id` = DEFAULT, 
			`group_id` = '.$_POST['gid'].', 
			`name` = "'.$_POST["name"].'", 
			`published` = 1, 
			`access` = '.$_POST["access"].',
			`order` = '.($maxorder+1).', 
			`file` = "'.$hash.'", 
			`article` = "'.$_POST['article'].'", 
			`title` = "'.$_POST['title'].'", 
			`text` = "'.$_POST['text'].'", 
			`linktype` = '.$_POST['linktype'].', 
			`linkvalue` = "'.$_POST['linkvalue'].'",
			`wordcount` = '.$_POST['wordcount'].', 
			`stretch` = '.$_POST['stretch'].'
		;';
		
		$db->setQuery($query);
		// if query is valid - reidrect
		if($db->query()){
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_POST['gid'], JText::_($LANG->SLIDE_ADDED));	
		}else{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_POST['gid'], JText::_($LANG->SLIDE_ADDING_ERROR . $query), 'error');
		}	
	}
	// Slide edit form
	function editSlideForm(){
		// importing language file
		$this->importLang();	
		$LANG = new GKLang();	
		// getting group ID
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		$db =& JFactory::getDBO();	
		$db->setQuery( "SELECT * FROM #__gk2_photoslide_slides WHERE id = ".$cid[0]." LIMIT 1;" );
		// reading data
		foreach($db->loadObjectList() as $r){
			$name = $r->name;
			$access = $r->access;
			$title = $r->title;
			$text = $r->text;
			$linktype = $r->linktype;
			$linkvalue = $r->linkvalue;
			$article = $r->article;
			$wordcount = $r->wordcount;
			$stretch = $r->stretch;
		}
		// creating article list
		$db->setQuery( 'SELECT a.`id` AS `id` , a.`title` AS `art_title`, k.`title` AS `cat_name` FROM `#__content` AS `a` LEFT JOIN `#__categories` AS `k` ON a.`catid` = k.`id` ORDER BY k.`title` ASC;' );
		// showing form
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'views'.DS.'edit.slide.php');
	}	
	// Editing slide
	function editSlide($apply = false){
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// basic classes and variables
		global $mainframe;
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'class.image.php');
		$img = new Image();
		$db =& JFactory::getDBO();
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );
		$plugin	= JRequest::getCmd('plugin');
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		// getting group settings
		$query = 'SELECT * FROM #__gk2_photoslide_groups WHERE id = '.$_POST['gid'].';';
		$db->setQuery($query);
		
		foreach($db->loadObjectList() as $r){
			$quality = $r->quality;
			$bg = $r->bgcolor;
			$mW = $r->mediumThumbX;
			$mH = $r->mediumThumbY;
			$sW = $r->smallThumbX;
			$sH = $r->smallThumbY;
		}	
		// getting slide settings
		$query = 'SELECT `file` FROM #__gk2_photoslide_slides WHERE id = '.$cid[0].';';
		$db->setQuery($query);
		
		foreach($db->loadObjectList() as $r)
		{
			$file = $r->file;
		}	
		jimport('joomla.filesystem.file');
		// removing files
		JFile::delete(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.'thumbm'.DS.$file);
		JFile::delete(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.'thumbs'.DS.$file);
		// creating thumbnails
		$img->createThumbnail(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.$file, $file,$mW,$mH,'m',(boolean)$_POST['stretch'],$bg,JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS, $quality);
		
		$img->createThumbnail(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.$file, $file,$sW,$sH,'s',(boolean)$_POST['stretch'],$bg,JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS, $quality);
		// setting data in DB
		$query = '
		UPDATE 
			#__gk2_photoslide_slides 
		SET 
			name = "'.$_POST["name"].'", 
			access = "'.$_POST['access'].'",
			article = "'.$_POST['article'].'", 
			title = "'.$_POST['title'].'", 
			text = "'.$_POST['text'].'", 
			linktype = '.$_POST['linktype'].', 
			linkvalue = "'.$_POST['linkvalue'].'", 
			wordcount='.$_POST['wordcount'].', 
			stretch = '.$_POST['stretch'].' 
		WHERE 
			id = '.$cid[0].';
		';
		// update datas
		$db->setQuery($query);
		// if all is ok - redirect
		if($db->query()){
			if($apply)
			{
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=edit_slide&cid[]='.$_POST['cid'].'&plugin='.$_POST['plugin'].'&gid='.$_POST['gid'], JText::_($LANG->SLIDE_EDITED));	
			}
			else
			{
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_POST['gid'], JText::_($LANG->SLIDE_EDITED));		
			}
		}else{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_POST['gid'], JText::_($LANG->SLIDE_EDIT_ERROR . $query), 'error');
		}
	}
	// Removing slide
	function deleteSlide($sid = 0, $redirect = true){
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// basic variables
		global $mainframe;
		$db =& JFactory::getDBO();
		$plugin	= JRequest::getCmd('plugin');
		$option	= JRequest::getCmd('option');
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$cid    = JRequest::getVar( 'cid', array(0), '', 'array' );	
		$where_clause = '';
		
		if($sid == 0)
		{
			for($i = 1; $i < count($cid); $i++)
			{
				$where_clause .= ' OR id = '.$cid[$i];	
			}
		}
		else
		{
			$cid[0] = $sid;	
		}
		
		$query = '
		SELECT 
			file 
		FROM 
			#__gk2_photoslide_slides 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		
		$db->setQuery($query);
		
		jimport('joomla.filesystem.file');
		// removing files
		foreach($db->loadObjectList() as $r)
		{
			unset($file);
			$file = $r->file;
			JFile::delete(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.$file);
			JFile::delete(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.'thumbm'.DS.$file);
			JFile::delete(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.'thumbs'.DS.$file);
		}
		// removing datas from DB
		$query = '
		DELETE FROM 
			#__gk2_photoslide_slides 
		WHERE 
			(id = '.$cid[0].' '.$where_clause.');
		';
		$db->setQuery($query);
		// if query is correct - redirect
		if($db->query()){
			if($redirect) $mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_GET['gid'], JText::_($LANG->SLIDE_REMOVED));	
		}else{
			if($redirect) $mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=view_group&cids='.$_GET['gid'], JText::_($LANG->SLIDE_REMOVE_ERROR . $query), 'error');
		}		
	}
	// preview for group	
	function previewGroup()
	{
		// importing language file
		$this->importLang();
		$LANG = new GKLang();
		// running SQL query
		$db =& JFactory::getDBO();	
		$db->setQuery("SELECT * FROM #__gk2_photoslide_groups WHERE id = ".$_GET['gid']." LIMIT 1;");
		// preparing data
		foreach($db->loadObjectList() as $r){
			$name = $r->name;
			$mediumThumbX = $r->mediumThumbX;
			$mediumThumbY = $r->mediumThumbY;
			$smallThumbX = $r->smallThumbX;
			$smallThumbY = $r->smallThumbY;
			$bgcolor = $r->bgcolor;
			$titlecolor = $r->titlecolor;
			$textcolor = $r->textcolor;
			$linkcolor = $r->linkcolor;
			$hlinkcolor = $r->hlinkcolor;
			$quality = $r->quality;
		}
		// showing form
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'views'.DS.'preview.group.php');	
	}
	// preview for slide
	function previewSlide()
	{
		// importing language file
		$this->importLang();	
		$LANG = new GKLang();	
		// getting group ID
		$db =& JFactory::getDBO();	
		$db->setQuery( "SELECT * FROM #__gk2_photoslide_slides WHERE id = ".$_GET['sid']." LIMIT 1;" );
		// reading data
		foreach($db->loadObjectList() as $r){
			$name = $r->name;
			$file = $r->file;
			$access = $r->access;
			$title = $r->title;
			$text = $r->text;
			$linktype = $r->linktype;
			$linkvalue = $r->linkvalue;
			$article = $r->article;
			$wordcount = $r->wordcount;
			$stretch = $r->stretch;
		}
		// showing form
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'plugins'.DS.'plg_gk_news_image_3'.DS.'views'.DS.'preview.slide.php');		
	}	
}

?>