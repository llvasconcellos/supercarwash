<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	View for task system_check	
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<h2><?php echo JText::_('SC_SYSTEMINFORMATION'); ?></h2>

<p><?php echo JText::_('SC_COMPONENTVERSION'); ?> <?php echo $systemcheck->version; ?></p>

<p><?php echo JText::_('SC_WHATNEED'); ?></p>

<h3><?php echo JText::_('SC_CHECKFORUPDATE'); ?></h3>
<script type="text/javascript">
function checkk(e){
	var event = new Event(e);
	var version='2.2';
	var el=event.target;
	el.innerHTML='<?php echo JText::_('SC_LOADING');?>';
	el.disabled=true;
	new Asset.javascript('http://update.gavick.com/index.php/json/data/components/com_gk2_photoslide',{
		onload: function(){	
			var info=new Element('div');
			var content='';
			if($defined($G_available['components'])){
				if($defined($G_available['components']['com_gk2_photoslide'])){
					if($G_available.components['com_gk2_photoslide'].version != version){
						content='<a href="http://update.gavick.com/index.php/update/html/components/com_gk2_photoslide/'+$G_available.components['com_gk2_photoslide'].version+'"><?php echo JText::_('SC_NEWVERSION');?> ('+$G_available.components['com_gk2_photoslide'].version+')</a>';
					}else{
						content='<?php echo JText::_('SC_NONEWVERSION');?>';
					}
				}
				else{
					content='<?php echo JText::_('SC_NONEWVERSION');?>';
				}	
			}
			else{
				content='<?php echo JText::_('SC_NONEWVERSION');?>';
			}
			info.innerHTML=content;
			info.injectAfter(el);
			el.remove();
		}
	});
	
	if(window.ie){
		var timerr = (function(){
			if($defined($G_available)){
				$clear(timerr);
				var info=new Element('div');
				var content='';
				if($defined($G_available['components'])){
					if($defined($G_available['components']['com_gk2_photoslide'])){
						if($G_available.components['com_gk2_photoslide'].version != version){
							content='<a href="http://update.gavick.com/index.php/update/html/components/com_gk2_photoslide/'+$G_available.components['com_gk2_photoslide'].version+'"><?php echo JText::_('SC_NEWVERSION');?> ('+$G_available.components['com_gk2_photoslide'].version+')</a>';
						}else{
							content='<?php echo JText::_('SC_NONEWVERSION');?>';
						}
					}
					else{
						content='<?php echo JText::_('SC_NONEWVERSION');?>';
					}	
				}
				else{
					content='<?php echo JText::_('SC_NONEWVERSION');?>';
				}
				info.innerHTML=content;
				info.injectAfter(el);
				el.remove();
			}
		}).periodical(250);
	}
}
</script>

<p><button id="checker" onclick="checkk(event);"><?php echo JText::_('SC_CHECKFORUPDATE'); ?></button></p>

<h3><?php echo JText::_('SC_GD'); ?></h3>

<p><?php echo JText::_('SC_GDSTATUS'); ?> <?php $systemcheck->GDStatus(); ?></p>
<p><?php echo JText::_('SC_GDVERSION'); ?> <?php $systemcheck->GDVersion(); ?></p>
<p><?php echo JText::_('SC_GDPNGSUPPORT'); ?> <?php $systemcheck->PNGSupport(); ?></p>

<h3><?php echo JText::_('SC_CATALOGPERMISSIONS'); ?></h3>

<table class="adminlist">
	<thead>
		<tr>
			<th width="4%" class="title" align="center">#</th>
			<th width="48%" class="title" align="center"><?php echo JText::_('SC_CATALOG'); ?></th>
			<th width="48%" class="title" align="center"><?php echo JText::_('SC_PERMISSIONS'); ?></th>
		</tr>
	</thead>
	<tfoot>
			<tr>
				<td colspan="3"><?php echo JText::_('SC_TFOOTINFO1'); ?></td>
			</tr>
	</tfoot>
	<tbody>
		<tr>
			<td align="center">1</td>
			<td align="center">images/</td>
			<td align="center"><?php $systemcheck->folderStatus(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'); ?></td>
		</tr>
		<tr>
			<td align="center">2</td>
			<td align="center">images/thumbm/</td>
			<td align="center"><?php $systemcheck->folderStatus(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.'thumbm'); ?></td>
		</tr>
		<tr>
			<td align="center">3</td>
			<td align="center">images/thumbs/</td>
			<td align="center"><?php $systemcheck->folderStatus(JPATH_SITE.DS.'components'.DS.'com_gk2_photoslide'.DS.'images'.DS.'thumbs'); ?></td>
		</tr>
		<tr>
			<td align="center">4</td>
			<td align="center">configuration/</td>
			<td align="center"><?php $systemcheck->folderStatus(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_gk2_photoslide'.DS.'configuration'); ?></td>
		</tr>
		<tr>
			<td align="center">5</td>
			<td align="center">configuration/plugins/</td>
			<td align="center"><?php $systemcheck->folderStatus(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_gk2_photoslide'.DS.'configuration'.DS.'plugins'); ?></td>
		</tr>
		<tr>
			<td align="center">6</td>
			<td align="center">configuration/extensions/</td>
			<td align="center"><?php $systemcheck->folderStatus(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_gk2_photoslide'.DS.'configuration'.DS.'extensions'); ?></td>
		</tr>
	</tbody>
</table>

<h3><?php echo JText::_('SC_TABLESTATUS'); ?></h3>	

<table class="adminlist">
	<thead>
		<tr>
			<th width="4%" class="title" align="center">#</th>
			<th width="48%" class="title" align="center"><?php echo JText::_('SC_TABLE'); ?></th>
			<th width="48%" class="title" align="center"><?php echo JText::_('SC_TABLEEXIST'); ?></th>
		</tr>
	</thead>
	<tfoot>
			<tr>
				<td colspan="3"><?php echo JText::_('SC_TFOOTINFO2'); ?></td>
			</tr>
	</tfoot>
	<tbody>
		<tr>
			<td align="center">1</td>
			<td align="center"><?php echo $systemcheck->prefix; ?>gk2_photoslide_groups</td>
			<td align="center"><?php $systemcheck->DBTableStatus('gk2_photoslide_groups');?></td>
		</tr>
		<tr>
			<td align="center">2</td>
			<td align="center"><?php echo $systemcheck->prefix; ?>gk2_photoslide_slides</td>
			<td align="center"><?php $systemcheck->DBTableStatus('gk2_photoslide_slides');?></td>
		</tr>
		<tr>
			<td align="center">3</td>
			<td align="center"><?php echo $systemcheck->prefix; ?>gk2_photoslide_plugins</td>
			<td align="center"><?php $systemcheck->DBTableStatus('gk2_photoslide_plugins');?></td>
		</tr>
		<tr>
			<td align="center">4</td>
			<td align="center"><?php echo $systemcheck->prefix; ?>gk2_photoslide_extensions</td>
			<td align="center"><?php $systemcheck->DBTableStatus('gk2_photoslide_extensions');?></td>
		</tr>
	</tbody>
</table>