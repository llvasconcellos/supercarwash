<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task add_group
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
// getting variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

/** 
	including plugins
**/

$db =& JFactory::getDBO();
// SQL query preparing
$query = "SELECT phpclassfile FROM #__gk2_photoslide_extensions WHERE status = 1 ORDER BY id ASC;";
// set query
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

/*
	If user has 0 or more than one plugin
*/

if(!isset($_GET['step']) && (count($plugins) > 1 || count($plugins) == 0)) : 

?>

<form action="index.php" method="get" name="adminForm" id="adminForm">
	<table class="adminlist">
		<tbody>
			<tr>
				<td width="100%" align="center" colspan="2"><h2><?php echo JText::_('AG1_SELECTMODULE1'); ?></h2></td>		
			</tr>
			
			<tr>
				<td width="100%" align="center" colspan="2">
					<p style="color: rgb(153, 153, 153);">
						<?php echo JText::_('AG1_ONLYENABLED'); ?>
					</p>
				</td>		
			</tr>
			
			<tr>
				<td width="50%" align="center"><?php echo JText::_('AG1_SELECTMODULE2'); ?></td>
				<td width="50%" align="center">
					<?php 
						if(count($plugins) > 0)
						{
							// showing only active plugins
							echo '<ol style="float: left;text-align: left;">';
							//
							for($i = 0; $i < count($plugins); $i++)
							{
								echo '<li style="float: left;width: 100%;"><label><input type="radio" '.(($i == 0) ? ' checked="checked" ' : '').' name="plugin" value="'.$plugins[$i]->value.'" />'.$plugins[$i]->text.'</label></li>';
							}
							//
							echo '</ol>';
						}
						else
						{
							echo JText::_('AG1_NOPLUGINSTOSHOW');	
						}
					?>
				</td>		
			</tr>		
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="add_group" />
	<input type="hidden" name="step" value="2" />
	<input type="hidden" name="boxchecked" value="0" />
</form>	

<?php 
// When plugin has been selected
else : 
?>

<?php if(count($plugins) == 1) : ?>

<dl id="system-message">
<dt class="notice">notice</dt>
<dd class="notice message fade">
	<ul>
		<li><?php echo JText::_('AG2_ONLYONEPLUGIN'); ?></li>
	</ul>
</dd>
</dl>

<?php endif; ?>

<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">
	<table class="adminlist">
		<tbody>
			<?php $pluginClass->addGroupForm(); ?>		
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="plugin" value="<?php echo $plugin;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>

<?php endif; ?>