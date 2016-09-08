<?php

/**
* Gavick News Image III
* @package Joomla!
* @Copyright (C) 2008 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 2.1 $
**/

// access restriction for this file haven't any sense

/*
	This file generate configuration JSON data for specified in $_GET variables module
*/
	
// set document type as text/javascript	
header("Content-Type: text/javascript");

?>

try {$Gavick;}catch(e){$Gavick = {};};

$Gavick["news_image_3-<?php echo $_GET['modid'];?>"] = {
	"anim_speed": <?php echo $_GET['anim_speed'];?>,
	"anim_interval": <?php echo $_GET['anim_interval'];?>,
	"autoanim": <?php echo $_GET['autoanim'];?>,
	"anim_type": <?php echo $_GET['anim_type'];?>,
	"anim_type_t": <?php echo $_GET['anim_type_t'];?>,
	"thumb_w":<?php echo $_GET['thumb_w'];?>,
	"thumb_h":<?php echo $_GET['thumb_h'];?>,
	"t_margin":<?php echo $_GET['t_margin'];?>,
	"t_border":<?php echo $_GET['t_border'];?>,
	"t_col":<?php echo $_GET['t_col'];?>,
	"t_row":<?php echo $_GET['t_row'];?>,
	"bgcolor":"#<?php echo $_GET['bgcolor'];?>",
	"opacity":<?php echo $_GET['opacity'];?>,
	"tooltips":<?php echo $_GET['tooltips'];?>,
	"tooltips_anim":<?php echo $_GET['tooltips_anim'];?>
};