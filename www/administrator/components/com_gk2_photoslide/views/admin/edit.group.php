<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task edit_group
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
// getting group ID
$cid = JRequest::getVar( 'cid', array(0), '', 'array' );

/** 
	Loading extensins - for description read file add.group.php :-)
**/

$db =& JFactory::getDBO();
$query = "
SELECT 
	phpclassfile 
FROM 
	#__gk2_photoslide_extensions 
WHERE 
	status = 1 
ORDER BY 
	id ASC;
";
$db->setQuery($query);
// some plugins to load exists ?
if($db->loadObjectList())
{
	// Yes - start loading plugins
	foreach($db->loadObjectList() as $ext)
	{
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'extensions'.DS.substr($ext->phpclassfile,0,-4).DS.$ext->phpclassfile);
	}
}

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<tbody>
			<?php 
				// Loading form
				$pluginClass->editGroupForm(); 
			?>		
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="plugin" value="<?php echo $plugin;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="gid" value="<?php echo $cid[0]; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
</form>