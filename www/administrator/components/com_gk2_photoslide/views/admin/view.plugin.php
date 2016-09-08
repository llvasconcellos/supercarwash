<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task view_plugin
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
// getting client variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

?>

<form action="index.php" method="get" name="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<th width="3%" class="title" align="center">#</th>
				<th width="3%" class="title" align="center">ID</th>
				<th width="3%" class="title" align="center"><input type="checkbox" onclick="checkAll(<?php echo count($rows); ?>);" value="" name="toggle"/></th>
				<th width="4%" class="title" align="center"><?php echo JText::_('VPS_STATUS'); ?></th>
				<th width="20%" class="title" align="center"><?php echo JText::_('VPS_NAME'); ?></th>
				<th width="47%" align="center" align="center"><?php echo JText::_('VPS_DESC'); ?></th>
				<th width="10%" class="title" align="center"><?php echo JText::_('VPS_TYPE'); ?></th>
				<th width="10%" class="title" align="center"><?php echo JText::_('VPS_VERSION'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8"><?php echo JText::_('VPS_TFOOTINFO'); ?></td>
			</tr>
		</tfoot>
		<tbody>
	
		<?php 	
			// wypisanie wierszy tabeli
			if(count($rows) > 0){
				for ($i = 0, $n = count($rows); $i < $n; $i++) { 
					$row =& $rows[$i]; 
		?>
			
			<tr class="<?php echo 'row'. $i; ?>">
				<td width="3%" align="center"><?php echo $i+1; ?></td>
				<td width="3%" align="center"><?php echo $row->id; ?></td>		
				<td width="3%" align="center">
					<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" />
				</td>
				<td width="4%" align="center">
					<?php 
						// status lightbulb
						echo ($row->status) ? 
						'<img src="components/com_gk2_photoslide/interface/images/plugin_enabled.png" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'disable_plugin\');" style="cursor:pointer;" alt="enabled"/>' : 
						'<img src="components/com_gk2_photoslide/interface/images/plugin_disabled.png" onclick="javascript:$$(\'.inputs\').removeProperty(\'checked\');$(\'cb'.$i.'\').checked=\'checked\';isChecked($(\'cb'.$i.'\').checked);submitbutton(\'enable_plugin\');" style="cursor:pointer;" alt="disabled"/>';
					?>
				</td>	
				<td width="20%" align="left"><?php echo $row->name;?></td>
				<td width="47%" align="left"><?php echo $row->desc; ?></td>
				<td width="10%" align="center"><?php echo $row->type; ?></td>
				<td width="10%" align="center"><?php echo $row->version; ?></td>
			</tr>		
		<?php }}else{ ?>
			<tr>
				<td width="100%" align="center" colspan="9"><?php echo JText::_('VPS_ANYPLUGINS'); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>		