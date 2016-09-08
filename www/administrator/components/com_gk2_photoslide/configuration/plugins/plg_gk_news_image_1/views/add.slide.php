<?php

/**
* @author: GavickPro
* @copyright: 2008
**/
	
// no direct access
defined('_JEXEC') or die('Restricted access');

$actual_group = '';
$flag = false; 
$first = false;

?>


<tr>
	<td><?php echo $LANG->SLIDE_NAME; ?></td>
	<td><input type="text" name="name" value="" id="slide_name" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_IMAGE; ?></td>
	<td><input type="file" name="image" value="" id="slide_image" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_ACCESS; ?></td>
	<td>
		<select name="access">
			<option value="0" selected="selected"><?php echo $LANG->SLIDE_PUBLIC; ?></option>
			<option value="1"><?php echo $LANG->SLIDE_REGISTRED; ?></option>
			<option value="2"><?php echo $LANG->SLIDE_SPECIAL; ?></option>
		</select>
	</td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_TITLE; ?></td>
	<td><input type="text" name="title" value="" id="slide_title" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_TEXT; ?></td>
	<td><input type="text" name="text" value="" id="slide_text" maxlength="255" size="40" /></td>
</tr>

<tr>
	<td><?php echo $LANG->SLIDE_LINKTYPE; ?></td>
	<td>
		<select name="linktype" id="slide_linktype">
			<option value="1" selected="selected"><?php echo $LANG->SLIDE_ARTICLE_LINK; ?></option>
			<option value="0"><?php echo $LANG->SLIDE_OWN_LINK; ?></option>
		</select>
	</td>
</tr>

<tr>
	<td><?php echo $LANG->SLIDE_LINKVALUE; ?></td>
	<td><input type="text" name="linkvalue" value="" id="slide_linkvalue" maxlength="255" size="40" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_ARTICLE; ?></td>
	<td>
		<select name="article" id="slide_article">
			<option value="0" selected="selected" /><?php echo $LANG->SLIDE_OWN_ARTICLE; ?></option>			
			<?php 
				foreach($db->loadObjectList() as $art){
					if($actual_group != $art->cat_name){ 
						if($flag) echo '</optgroup>'; else $flag = true;
						echo '<optgroup label="'.$art->cat_name.'">';
						$actual_group = $art->cat_name;
					}
			
				echo '<option '.(!$first ? 'selected="selected"' : '').' value="'.$art->id.'" /> '.$art->art_title;
				if(!$first) $first = true;
				}
			?>	
		</select>
	</td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_WORDCOUNT; ?></td>
	<td><input type="text" name="wordcount" value="30" id="slide_wordcount" maxlength="4" size="5" /></td>
</tr>
		
<tr>
	<td><?php echo $LANG->SLIDE_STYLE; ?></td>
	<td>
		<select name="stretch">
			<option value="0" selected="selected"><?php echo $LANG->SLIDE_NONSTRETCH; ?></option>
			<option value="1"><?php echo $LANG->SLIDE_STRETCH; ?></option>
		</select>
	</td>
</tr>	
		
<script type="text/javascript">
	window.addEvent("domready", function(){
		$E("#toolbar-save .toolbar").onclick = function(){
    		var alert_content = '';
				
			if($("slide_name").getValue() == '') alert_content += '<?php echo $LANG->ESLIDENAME;?>'; 
			if($("slide_image").value == '') alert_content += '<?php echo $LANG->EFILE;?>'; 
			if(($("slide_article").value == 0) && ($("slide_title").value == '' || $("slide_text").value == '')) alert_content += '<?php echo $LANG->ECONTENT;?>';
				
			if(($("slide_linktype").value == 0) && ($("slide_linkvalue").value == '')) alert_content += '<?php echo $LANG->ELINKVALUE;?>';
				
			if(isNaN($("slide_wordcount").value) || $("slide_wordcount").value == '') alert_content += '<?php echo $LANG->EWORDCOUNT;?>';
				
			(alert_content != '') ? alert(alert_content) : submitbutton('save_slide');
		}
	});
</script>