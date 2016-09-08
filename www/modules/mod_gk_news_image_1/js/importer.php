<?php

/**
* Gavick News Image I
* @package Joomla!
* @Copyright (C) 2008 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 2.1.2 $
**/

// access restriction for this file haven't any sense

/*
	This file generate configuration JSON data for specified in $_GET variables module
*/
	
// set document type as text/javascript	
header("Content-Type: text/javascript");

?>

try {$Gavick;}catch(e){$Gavick = {};};

$Gavick["gk_news_image_1-<?php echo $_GET['mid'];?>"] = {
	"anim_speed":<?php echo $_GET['animation_slide_speed'];?>,
	"anim_interval":<?php echo $_GET['animation_interval'];?>,
	"autoanim":<?php echo $_GET['autoanimation'];?>,
	"anim_type":<?php echo $_GET['animation_slide_type'];?>,
	"anim_type_t":<?php echo $_GET['animation_text_type'];?>,
	"bgcolor":"#<?php echo $_GET['base_bgcolor'];?>",
	"opacity":<?php echo $_GET['text_block_opacity'];?>,
	"thumbnail_width":<?php echo $_GET['thumbnail_width'];?>,
	"thumbnail_margin":<?php echo $_GET['thumbnail_margin'];?>,
	"thumbnail_border":<?php echo $_GET['thumbnail_border'];?>,
	"thumbnail_border_color":"#<?php echo $_GET['thumbnail_border_color'];?>",
	"thumbnail_border_color_inactive":"#<?php echo $_GET['thumbnail_border_color_inactive']; ?>",
	"interface_x":<?php echo $_GET['interface_x'];?>,
	"interface_y":<?php echo $_GET['interface_y'];?>,
	"clickable_slides":<?php echo $_GET['clickable_slides'];?>,
	"actual_animation":false,
	"actual_animation_p":false,
	"actual_slide":0
};