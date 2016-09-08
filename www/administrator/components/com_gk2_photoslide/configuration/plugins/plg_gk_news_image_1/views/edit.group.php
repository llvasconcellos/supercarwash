<?php

/**
* @author: GavickPro
* @copyright: 2008
**/
	
// no direct access
defined('_JEXEC') or die('Restricted access');

?>
		
<tr>
	<td><?php echo $LANG->GROUP_NAME; ?></td>
	<td><input type="text" name="name" value="<?php echo $name; ?>" id="group_name" maxlength="100" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->IMAGE_QUALITY; ?></td>
	<td><input type="text" name="quality" value="<?php echo $quality; ?>" id="quality" size="3" maxlength="3" />%</td>
</tr>
		
<tr>
	<td><?php echo $LANG->IMAGE_WIDTH; ?></td>
	<td><input type="text" name="mediumThumbX" value="<?php echo $mediumThumbX; ?>" id="group_width" size="5" maxlength="4" />px</td>
</tr>
		
<tr>
	<td><?php echo $LANG->IMAGE_HEIGHT; ?></td>
	<td><input type="text" name="mediumThumbY" value="<?php echo $mediumThumbY; ?>" id="group_height" size="5" maxlength="4" />px</td>
</tr>

<tr>
	<td><?php echo $LANG->THUMB_WIDTH; ?></td>
	<td><input type="text" name="smallThumbX" value="<?php echo $smallThumbX; ?>" id="thumb_width" size="5" maxlength="4" />px</td>
</tr>
		
<tr>
	<td><?php echo $LANG->THUMB_HEIGHT; ?></td>
	<td><input type="text" name="smallThumbY" value="<?php echo $smallThumbY; ?>" id="thumb_height" size="5" maxlength="4" />px</td>
</tr>

<tr>
	<td><?php echo $LANG->BG_COLOR; ?></td>
	<td><input type="text" name="bgcolor" value="<?php echo $bgcolor; ?>" id="bgcolor" size="7" maxlength="9" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->TITLE_COLOR; ?></td>
	<td><input type="text" name="titlecolor" value="<?php echo $titlecolor; ?>" id="titlecolor" size="9" maxlength="7" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->TEXT_COLOR; ?></td>
	<td><input type="text" name="textcolor" value="<?php echo $textcolor; ?>" id="textcolor" size="9" maxlength="7" /></td>
</tr>		
		
<tr>
	<td><?php echo $LANG->LINK_COLOR; ?></td>
	<td><input type="text" name="linkcolor" value="<?php echo $linkcolor; ?>" id="linkcolor" size="9" maxlength="7" /></td>
</tr>	
		
<tr>
	<td><?php echo $LANG->HLINK_COLOR; ?></td>
	<td><input type="text" name="hlinkcolor" value="<?php echo $hlinkcolor; ?>" id="hlinkcolor" size="9" maxlength="7" /></td>
</tr>	
		
<script type="text/javascript">
	window.addEvent("domready", function(){
		$E("#toolbar-save .toolbar").onclick = function(){
    		var alert_content = '';
				
			if($("group_name").getValue() == '') alert_content += '<?php echo $LANG->EGROUPNAME; ?>'; 
			if(isNaN($("group_width").value) || $("group_width").value == '') alert_content += '<?php echo $LANG->EIMAGEWIDTH; ?>'; 
			if(isNaN($("group_height").value) || $("group_height").value == '') alert_content += '<?php echo $LANG->EIMAGEHEIGHT; ?>';
				
			if(isNaN($("thumb_width").value) || $("thumb_width").value == '') alert_content += '<?php echo $LANG->ETHUMBWIDTH; ?>'; 
			if(isNaN($("thumb_height").value) || $("thumb_height").value == '') alert_content += '<?php echo $LANG->ETHUMBHEIGHT; ?>';
				
			var hexre = new RegExp(/^#([0-9a-fA-F]){3}(([0-9a-fA-F]){3})?$/);
				
			if(!hexre.test($("bgcolor").value)) alert_content += '<?php echo $LANG->EBGCOLOR; ?>';
			if(!hexre.test($("titlecolor").value)) alert_content += '<?php echo $LANG->ETITLECOLOR; ?>';
			if(!hexre.test($("textcolor").value)) alert_content += '<?php echo $LANG->ETEXTCOLOR; ?>';
			if(!hexre.test($("linkcolor").value)) alert_content += '<?php echo $LANG->ELINKCOLOR; ?>';
			if(!hexre.test($("hlinkcolor").value)) alert_content += '<?php echo $LANG->EHLINKCOLOR; ?>';
				
			(alert_content != '') ? alert(alert_content) : submitbutton('apply_group');
		}
	});
</script>