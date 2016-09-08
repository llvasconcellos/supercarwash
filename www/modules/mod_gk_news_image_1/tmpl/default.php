<?php

/**
* Gavick News Slide I
* @package Joomla!
* @Copyright (C) 2008 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 2.1.2 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

?>

<?php if(!$this->clean_code) : ?>
<script type="text/javascript">
	try {$Gavick;}catch(e){$Gavick = {};};
	$Gavick["gk_news_image_1-<?php echo $this->module_id;?>"] = {
		"anim_speed":<?php echo $this->animation_slide_speed;?>,
		"anim_interval":<?php echo $this->animation_interval;?>,
		"autoanim":<?php echo $this->autoanimation;?>,
		"anim_type":<?php echo $this->animation_slide_type;?>,
		"anim_type_t":<?php echo $this->animation_text_type;?>,
		"bgcolor":"<?php echo $this->base_bgcolor;?>",
		"opacity":<?php echo $this->text_block_opacity;?>,
		"thumbnail_width":<?php echo $this->thumbnail_width; ?>,
		"thumbnail_margin":<?php echo $this->thumbnail_margin; ?>,
		"thumbnail_border":<?php echo $this->thumbnail_border; ?>,
		"thumbnail_border_color":"#<?php echo $this->thumbnail_border_color; ?>",
		"actual_animation":false,
		"actual_animation_p":false,
		"actual_slide":0
	};
</script>
<?php endif; ?>

<?php if($this->useMoo == 1) : ?><script type="text/javascript" src="<?php echo $uri->root(); ?>modules/mod_gk_news_image_1/js/mootools.js"></script><?php endif; ?>
<?php if($this->useScript == 1) : ?><script type="text/javascript" src="<?php echo $uri->root(); ?>modules/mod_gk_news_image_1/js/engine<?php echo ($this->compress_js == 1) ? '_compress' : ''; ?>.js"></script><?php endif; ?>