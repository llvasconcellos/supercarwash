<?php

/**
* Gavick News Slide III
* @package Joomla!
* @Copyright (C) 2008 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 2.1 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

?>

<?php if($this->useMoo == 1) : ?><script type="text/javascript" src="modules/mod_gk_news_image_3/js/mootools.js"></script><?php endif; ?>
<?php if($this->useScript == 1) : ?><script type="text/javascript" src="modules/mod_gk_news_image_3/js/engine<?php echo ($this->compress_js) ? '_compressed' : ''; ?>.js"></script><?php endif; ?>

<?php if($this->clean_code == 0) : ?>
<script type="text/javascript">
	try {$Gavick;}catch(e){$Gavick = {};};
	$Gavick["news_image_3-<?php echo $this->module_id;?>"] = {
		"anim_speed":<?php echo $this->animation_slide_speed;?>,
		"anim_interval":<?php echo $this->animation_interval;?>,
		"autoanim":<?php echo $this->autoanimation;?>,
		"anim_type":<?php echo $this->animation_slide_type;?>,
		"anim_type_t":<?php echo $this->animation_text_type;?>,
		"thumb_w":<?php echo $this->thumbnail_width;?>,
		"thumb_h":<?php echo $this->thumbnail_height;?>,
		"t_margin":<?php echo $this->tabs_margin;?>,
		"t_border":<?php echo $this->tabs_border;?>,
		"t_col":<?php echo $this->tabs_col;?>,
		"t_row":<?php echo $this->tabs_row;?>,
		"bgcolor":"<?php echo $this->base_bgcolor;?>",
		"opacity":<?php echo $this->text_block_opacity;?>,
		"tooltips":<?php echo $this->tooltips;?>,
		"tooltips_anim":<?php echo $this->tooltips_anim;?>
	};
</script>
<?php endif; ?>