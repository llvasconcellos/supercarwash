<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task view_groups
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

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
if($db->loadObjectList())
{
	foreach($db->loadObjectList() as $ext)
	{
		require_once(JPATH_COMPONENT.DS.'configuration'.DS.'extensions'.DS.substr($ext->phpclassfile,0,-4).DS.$ext->phpclassfile);
	}
}

$query = "
SELECT 
	* 
FROM 
	#__gk2_photoslide_plugins 
WHERE 
	status = 1 
ORDER BY 
	id ASC;
";
$db->setQuery($query);
$plugins = $db->loadObjectList();

?>

<?php if(count($plugins) == 0) : ?>

<dl id="system-message">
<dt class="notice">notice</dt>
<dd class="notice message">
	<ul>
		<li><?php echo JText::_('VGS_NOPLUGIN'); ?></li>
	</ul>
</dd>
</dl>

<?php endif; ?>

<div style="float: left;width: 75%;">
<form action="index.php" method="get" name="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="3%" class="title" align="center">#</th>
				<th width="3%" class="title" align="center">ID</th>
				<th width="3%" class="title" align="center"><input type="checkbox" onclick="checkAll(<?php echo count($rows); ?>);" value="" name="toggle"/></th>
				<th width="50%" class="title" align="center"><?php echo JText::_( 'VGS_NAME' ); ?></th>
				<th width="14%" align="center" align="center"><?php echo JText::_( 'VGS_MODULEPLUGIN' ); ?></th>
				<th width="14%" class="title" align="center"><?php echo JText::_( 'VGS_SLIDESAMOUNT' ); ?></th>
				<th width="13%" class="title" align="center"><?php echo JText::_( 'VGS_PREVIEW' ); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7"><?php echo JText::_('VGS_TFOOTINFO'); ?></td>
			</tr>
		</tfoot>
		<tbody>
	
		<?php 	
			// wypisanie wierszy tabeli	
			if($rows){
				for ($i = 0; $i < count($rows); $i++) { 
					$row =& $rows[$i]; 
		?>
			
			<tr class="<?php echo 'row'. $i; ?>" <?php if($row->status == 0) echo ' style="color: rgb(153, 153, 153);"'; ?>>
				<td width="3%" align="center"><?php echo $i+1; ?></td>
				<td width="3%" align="center"><?php echo $row->id; ?></td>		
				<td width="3%" align="center">
					<input type="checkbox" class="inputs" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" />
				</td>	
				<td width="50%" align="left">
					<span style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('view_group');" title="<?php echo JText::_( 'VGS_CLICKTOSHOW' ); ?>">
						<?php echo $row->name;?>
					</span>
				</td>
				<td width="14%" align="center"><?php echo $row->plugin; ?></td>
				<td width="14%" align="center"><?php echo $row->amount; ?></td>
				<td width="13%" align="center"><a href="index.php?option=com_gk2_photoslide&client=0&task=preview_group&plugin=<?php echo $row->pfile; ?>&gid=<?php echo $row->id; ?>&tmpl=component&format=raw" onclick="javascript: new Event(event).stop();new Ajax(this.href, {onRequest: function(){$('group_preview').innerHTML = '<img src=\'components/com_gk2_photoslide/interface/js/css/loader.gif\' style=\'display:block;margin: 0 auto;\' alt=\'Loading data...\'/>';},onComplete: function(){$('group_preview').innerHTML = this.response.text;}}).request();"><?php echo JText::_('VGS_PREVIEWSETTINGS'); ?></a></td>
			</tr>		
		<?php }}else{ // gdy brak grup do za³adowania ?>
			<tr>
				<td width="100%" align="center" colspan="7"><?php echo JText::_( 'VGS_ANYGROUPS' ); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>	
</div>
<div style="float: left;width: 25%;">
	<div style="margin: 0 0 10px 10px;padding: 10px;border: 1px solid #CDCDCD;" id="group_preview">
		<?php echo JText::_('VGS_CLICK'); ?>
	</div>
</div>