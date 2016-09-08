<?php


/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task add_plugin
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
// getting variable
$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

?>

<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm">
	<table class="adminlist">
		<tbody>
		<tr>
			<td colspan="2" style="text-align: center;"><?php echo JText::_('AP_ZIPINFO'); ?></td>
		</tr>
		<tr>
			<td style="text-align: right;width: 50%;"><?php echo JText::_('AP_ZIPPACKAGE'); ?></td>
			<td>
				<input type="file" name="install_zip" size="50" id="install_zip" />
				<button onclick="javascript: submitbutton('save_plugin');"><?php echo JText::_('AP_INSTALL'); ?></button>
			</td>
		</tr>	
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_gk2_photoslide" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="save_plugin" />
</form>