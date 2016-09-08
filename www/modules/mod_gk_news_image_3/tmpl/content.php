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
//
if($this->tabs_position != 'bottom')
{
	$block_width = $this->module_width + (($this->thumbnail_width + (($this->tabs_margin + $this->tabs_border + $this->tabs_padding) * 2)) * $this->tabs_col);
	$block_height = $this->module_height + (2 * $this->tabs_margin);	
}
else
{
	$block_width = $this->module_width;
	$block_height = $this->module_height+(($this->thumbnail_height+(($this->tabs_margin*(1/2)+$this->tabs_border + $this->tabs_padding)*2))*$this->tabs_row);	
}

$width2 = (($this->thumbnail_width + (($this->tabs_margin + $this->tabs_border + $this->tabs_padding) * 2)) * $this->tabs_col);
$height2 = (($this->thumbnail_height + (($this->tabs_margin * 2) + (2 * $this->tabs_border) + (2* $this->tabs_padding))) * $this->tabs_row);
$text_overlay_bgcolor = $this->base_bgcolor;

?>

<div id="news_image_3-<?php echo $this->module_id;?>" class="gk_news_image_main" style="width: <?php echo $block_width; ?>px;height: <?php echo $block_height?>px;<?php echo ($_GET['module_bg'] == '') ? '' : 'background-color: '.$this->base_bgcolor.';'; ?>">
	
	<div class="gk_news_image_3_wrapper" style="width: <?php echo $this->module_width; ?>px;height: <?php echo $this->module_height; ?>px;background-color: <?php echo $this->base_bgcolor; ?>;<?php if($this->tabs_position != 'bottom') : ?>float: <?php echo (($this->tabs_position == 'left') ? 'right' : 'left'); ?>;<?php endif; ?>">

	<?php if($this->show_text_block == 1) : ?>
		<div class="gk_news_image_3_json"><?php echo $this->JSON;?></div>
	<?php endif; ?>
		
	<?php 
		$highest_layer = 0;
		for($i = 0; $i < count($this->slides); $i++)
		{
			if($this->preloading == 0)
			{				
				echo '<div class="gk_news_image_3_slide" '.(($this->clickable_slides == 1) ? 'title="'.(($this->slides[$i]['linktype'] != 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($this->slides[$i]['article'], $this->slides[$i]['cid'], $this->slides[$i]['sid'])) : $this->slides[$i]['linkvalue']).'"' : '').' style="background-image:url('.$this->base_path_to_images.'/thumbm/'.$this->slides[$i]['name'].');z-index:'.$i.';width: '.$this->module_width.'px;height: '.$this->module_height.'px;'.(($this->clickable_slides == 1) ? 'cursor: pointer;' : '').'"></div>';
			}
			else
			{
				echo '<div class="gk_news_image_3_slide" '.(($this->clickable_slides == 1) ? 'title="'.(($this->slides[$i]['linktype'] != 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($this->slides[$i]['article'], $this->slides[$i]['cid'], $this->slides[$i]['sid'])) : $this->slides[$i]['linkvalue']).'"' : '').' style="z-index:'.$i.';width: '.$this->module_width.'px;height: '.$this->module_height.'px;'.(($this->clickable_slides == 1) ? 'cursor: pointer;' : '').'">'.$this->base_path_to_images.'/thumbm/'.$this->slides[$i]['name'].'</div>';
			}
			
			$highest_layer = $i;
		}
		$highest_layer += 5; 
	?>

	<?php if($this->show_text_block == 1) : ?>
		<?php $text_overlay_bgcolor = ($this->text_block_background == 0) ? $this->text_block_bgcolor : $this->base_bgcolor; ?>
		<div class="gk_news_image_3_text_bg" style="z-index:<?php echo $highest_layer;?>;background-color: <?php echo $text_overlay_bgcolor; ?>;opacity: <?php echo $this->text_block_opacity; ?>;top: <?php echo $this->module_height-$this->text_block_height; ?>px;height: <?php echo $this->text_block_height; ?>px;"></div>
		<?php $highest_layer += 1; ?>
		<div class="gk_news_image_3_text" style="z-index:<?php echo $highest_layer;?>;top: <?php echo $this->module_height - $this->text_block_height; ?>px;"></div>
	<?php endif; ?>

	</div>
	
	<div class="gk_news_image_3_tabsbar" style="width: <?php echo $width2; ?>px;<?php if($this->tabs_position != 'bottom') : ?>float: left;<?php endif; ?>">	
		
	<?php
         //
		 for($i = 0;$i < count($this->slides);$i++)
		 {
			$field = "";
			$margins = $this->tabs_margin.'px ';
			($this->slides[$i]["title"] === "") ? $field = "ctitle" : $field = "title";
			//
			$margins .= (($i+1) % $this->tabs_col == 0) ? ' 0 ' : ' '.$this->tabs_margin.'px ';
			$margins .= ' 0 ';
			$margins .=	(($i+1) % $this->tabs_col == 1) ? ' 0 ' : ' '.$this->tabs_margin.'px ';
			//
			echo '<img class="gk_news_image_3_tab TipsGK" src="'.$this->base_path_to_images.'/thumbs/'.$this->slides[$i]['name'].'" title="'.htmlspecialchars($this->slides[$i][$field]).'" alt="thumbnail" style="margin: '.$margins.';border-width: '.$this->tabs_border.'px;padding: '.$this->tabs_padding.'px;width: '.$this->thumbnail_width.'px;height: '.$this->thumbnail_height.'px;" />';
		}

	?>

	</div>
	
	<?php if($this->preloading == 1) : ?>
	<div class="gk_news_image_3_preloader" style="width: <?php echo $block_width; ?>px;height:<?php echo $block_height; ?>px;"></div>	
	<?php endif; ?>
</div>