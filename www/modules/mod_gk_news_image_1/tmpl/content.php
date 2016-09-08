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
// vars
$highest_layer = 0;

?>

<div id="gk_news_image_1-<?php echo $this->module_id;?>" class="gk_news_image_1_wrapper">
	<?php if($this->show_text_block == 1) : ?>
	<div class="gk_news_image_1_json"><?php echo $this->JSON;?></div>
	<?php endif; ?>

	<?php for($i = 0; $i < count($this->slides); $i++) : ?>
	<?php if($this->preloading == 0) : ?>
	<img src="<?php echo $this->base_path_to_images.'/thumbm/'.$this->slides[$i]['name']; ?>" class="gk_news_image_1_slide" style="z-index:<?php echo $i;$highest_layer = $i;?>;" alt="<?php echo $this->links[$i]; ?>" />	
	<?php else : ?>
	<span class="gk_news_image_1_slide" style="z-index:<?php echo $i;$highest_layer = $i;?>;" title="<?php echo $this->links[$i]; ?>"><?php echo $this->base_path_to_images.'/thumbm/'.$this->slides[$i]['name']; ?></span>						
	<?php endif; ?>	
	<?php endfor; ?>
	<?php $highest_layer += 5; ?>

	<?php if($this->show_text_block == 1) : ?>
	<div class="gk_news_image_1_text_bg" style="z-index: <?php echo $highest_layer;?>;"></div>
	<div class="gk_news_image_1_text" style="z-index:<?php $highest_layer+=1;echo $highest_layer;?>;"></div>
	<?php endif; ?>
	
	<?php if($this->thumbnail_bar == 1 && $this->show_text_block == 1) : ?>	
	<div class="gk_news_image_1_thumbnails" style="z-index: <?php $highest_layer += 1;echo $highest_layer;?>;">
		<div class="gk_news_image_1_tb_prev"></div>
		<div class="gk_news_image_1_tb">
			<div class="gk_news_image_1_tbo">
			<?php for($i = 0;$i < count($this->slides);$i++) : ?>
				<img src="<?php echo $this->base_path_to_images.'/thumbs/'.$this->slides[$i]['name']; ?>" class="gk_news_image_1_thumb" alt="<?php echo $this->links[$i]; ?>" />
			<?php endfor; ?>
			</div>
		</div>
		<div class="gk_news_image_1_tb_next"></div>
	</div>
	<?php endif; ?>

	<?php if($this->show_interface) : ?>
	<div class="gk_news_image_1_interface_buttons" style="z-index: <?php echo $highest_layer+3; ?>;">
		<?php if($this->play_button == 1) : ?>
			<a href="#" class="gk_news_image_1_play"></a><a href="#" class="gk_news_image_1_pause"></a>
		<?php endif; ?>
		<?php if($this->prev_button == 1) : ?>
			<a href="#" class="gk_news_image_1_prev"></a>
		<?php endif; ?>
		<?php if($this->next_button == 1) : ?>
			<a href="#" class="gk_news_image_1_next"></a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	
	<?php if($this->show_ticks) : ?>
	<ul class="gk_news_image_1_tick_buttons" style="z-index: <?php echo $highest_layer+3; ?>;">
		<?php for($i = 0;$i < count($this->slides);$i++) : ?>
		<li><img src="<?php $ur =& JURI::getInstance();echo $ur->root().'modules/mod_gk_news_image_1/images/tick.png'; ?>" class="tick" alt="" /></li>
		<?php endfor; ?>
	</ul>
	<?php endif; ?>
	<?php if($this->preloading == 1) : ?>
	<div class="gk_news_image_1_preloader" style="z-index: 1000;"></div>
	<?php endif; ?>
</div>