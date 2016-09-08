<?php

/**
*	@author: GavickPro
* 	@date: 2008
**/

class GKExtensionRainbow
{	
	function init()
	{
		$task = JRequest::getCmd( 'task' );
		
		if($task == 'add_group' || $task == 'edit_group' || $task == 'add_slide' || $task == 'edit_slide')
		{
			echo '<script type="text/javascript" src="components/com_gk2_photoslide/configuration/extensions/ext_rainbow/js/jquery.js"></script>';
			echo '<link rel="stylesheet" media="screen" type="text/css" href="components/com_gk2_photoslide/configuration/extensions/ext_rainbow/css/colorpicker.css" />';
			echo '<script type="text/javascript" src="components/com_gk2_photoslide/configuration/extensions/ext_rainbow/js/colorpicker.js"></script>';
			echo '<script type="text/javascript">
			jQuery.noConflict();
			window.addEvent("load",function(){	
       			$ES(\'input[id$=color]\').each(function(elementss, indexx){
					jQuery(\'#\'+elementss.id).ColorPicker({
						onSubmit: function(hsb, hex, rgb) {
							jQuery(\'#\'+elementss.id).val(\'#\'+hex);
						},
						onBeforeShow: function () {
							jQuery(this).ColorPickerSetColor(this.value);
						}
					}).bind(\'keyup\', function(){
						jQuery(this).ColorPickerSetColor(this.value);
					});
				});
     		});
			</script>';
		}	
	}
}

GKExtensionRainbow::init();

?>