<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task view_group
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
// getting clien variable
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

<script type="text/javascript" src="components/com_gk2_photoslide/interface/js/slimbox.js"></script>
<link type="text/css" rel="stylesheet" href="components/com_gk2_photoslide/interface/js/css/slimbox.css" />

<div style="float: left;width: 75%;">
<form action="index.php" method="get" name="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="3%" class="title" align="center">#</th>
				<th width="3%" class="title" align="center">ID</th>
				<th width="3%" class="title" align="center"><input type="checkbox" onclick="checkAll(<?php echo count($rows); ?>);" value="" name="toggle"/></th>
				<th width="41%" class="title" align="center"><?php echo JText::_( 'VG_NAME' ); ?></th>
				<th width="10%" class="title" align="center"><?php echo JText::_( 'VG_PUBLISHED' ); ?></th>
				<th width="10%" class="title" align="center"><?php echo JText::_( 'VG_ACCESS' ); ?></th>
				<th width="10%" class="title" align="center"><?php echo JText::_( 'VG_PREVIEW' ); ?></th>
				<th width="10%" class="title" align="center"><?php echo JText::_( 'VG_PREVIEWSETTINGS' ); ?></th>
				<th width="10%" align="center" align="center"><?php echo JText::_('VG_ORDER'); ?><?php echo JHTML::_('grid.order',  $rows );?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9"><?php echo JText::_('VG_TFOOTINFO'); ?></td>
			</tr>
		</tfoot>
		<tbody>
	
		<?php 	
			// writing rows
			if($rows){
				for ($i = 0; $i < count($rows); $i++) { 
					$row =& $rows[$i]; 
		?>
			
			<tr class="<?php echo 'row'. $i; ?>">
				<td width="3%" align="center"><?php echo $i+1; ?></td>
				<td width="3%" align="center"><?php echo $row->id; ?></td>		
				<td width="3%" align="center">
					<input type="checkbox" class="inputs" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" />
				</td>	
				<td width="41%" align="left">
					<span style="text-decoration: underline;cursor: pointer;" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('edit_slide');" title="<?php echo JText::_( 'VG_CLICKTOSHOW' ); ?>">
						<?php echo $row->name;?>
					</span>
				</td>
				<td width="10%" class="title" align="center"><img height="16" border="0" style="cursor:pointer;" width="16" alt="<?php echo ($row->published == 0) ? JText::_('VG_UNPUBLISHED') : JText::_('VG_PUBLISHED'); ?>" src="images/<?php echo ($row->published == 1) ? 'tick' : 'publish_x';?>.png" onclick="javascript:$$('.inputs').removeProperty('checked');$('cb<?php echo $i ?>').checked='checked';isChecked($('cb<?php echo $i ?>').checked);submitbutton('<?php echo ($row->published == 1) ? 'un' : '';?>publish_slide');" /></td>
				<td width="10%" class="title" align="center">
				<?php 
					switch($row->access)
					{
						case 0 : echo '<a href="#" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);$(\'level\').value=1;submitbutton(\'access_slide\');"><font color="green">'.JText::_('VG_PUBLIC').'</font></a>';break;
						case 1 : echo '<a href="#" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);$(\'level\').value=2;submitbutton(\'access_slide\');"><font color="red">'.JText::_('VG_REGISTERED').'</font></a>';break;
						case 2 : echo '<a href="#" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);$(\'level\').value=0;submitbutton(\'access_slide\');"><font color="gray">'.JText::_('VG_SPECIAL').'</font></a>';break;
					} 
				?>
				</td>
				<td width="10%" align="center"><a href="../components/com_gk2_photoslide/images/<?php echo $row->file; ?>" rel="lightbox"><?php echo JText::_( 'VG_PREVIEW' ); ?></a></td>
				<td width="10%" align="center"><a href="index.php?option=com_gk2_photoslide&client=0&task=preview_slide&plugin=<?php echo $plugin; ?>&sid=<?php echo $row->id; ?>&tmpl=component&format=raw" onclick="javascript: new Event(event).stop();new Ajax(this.href, {onRequest: function(){$('group_preview').innerHTML = '<img src=\'components/com_gk2_photoslide/interface/js/css/loader.gif\' style=\'display:block;margin: 0 auto;\' alt=\'Loading data...\'/>';},onComplete: function(){$('group_preview').innerHTML = this.response.text;}}).request();"><?php echo JText::_( 'VG_PREVIEWSETTINGS' ); ?></a></td>
				<td width="10%" align="center"><input type="text" name="order[]" size="5" value="<?php echo $row->order;?>" class="text_area" style="text-align: center" /></td>
			</tr>		
		<?php }}else{ // gdy brak grup do za³adowania ?>
			<tr>
				<td width="100%" align="center" colspan="9"><?php echo JText::_( 'VG_ANYSLIDES' ); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="plugin" value="<?php echo $plugin;?>" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="level" id="level" value="" />
	<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
</form>	
</div>
<div style="float: right;width: 25%;">
	<div style="margin: 0 0 10px 10px;padding: 10px;border: 1px solid #CDCDCD;" id="group_preview">
		<?php echo JText::_('VG_CLICK'); ?>
	</div>
</div>