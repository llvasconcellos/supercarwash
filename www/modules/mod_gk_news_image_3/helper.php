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
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
//
class gk_news_image_3_helper
{
	//
	var $module_id, 
	$group_id, 
	$show_text_block, 
	$text_block_opacity, 
	$text_block_background, 
	$text_block_bgcolor, 
	$clean_xhtml, 
	$readmore_text, 
	$readmore_button, 
	$title_link, 
	$tabs_col, 
	$tabs_row, 
	$tabs_border, 
	$tabs_padding, 
	$tabs_margin, 
	$tabs_position, 
	$animation_slide_speed, 
	$animation_interval, 
	$autoanimation, 
	$animation_slide_type, 
	$animation_text_type, 
	$useMoo, 
	$useScript, 
	$base_path_to_images, 
	$tooltips, 
	$tooltips_anim, 
	$tabs_amount, 
	$JSON, 
	$module_width, 
	$module_height, 
	$thumbnail_width, 
	$thumbnail_height, 
	$base_bgcolor, 
	$base_titlecolor, 
	$base_textcolor, 
	$base_linkcolor, 
	$base_hlinkcolor, 
	$slides, 
	$module_bg,
	$preloading,
	$clean_code,
	$compress_js,
	$text_block_height,
	$clickable_slides;
	//
	function initialize(&$params)
	{
		//
		$this->module_id = $params->get('module_id', 'newsimage3');
		$this->group_id = $params->get('group_id', 0); 
		$this->show_text_block = $params->get('show_text_block', 1);
		$this->text_block_opacity = $params->get('text_block_opacity', 0.45);
		$this->text_block_height = $params->get('text_block_height', 100);
		$this->text_block_background = $params->get('text_block_background', 0);
		$this->text_block_bgcolor = $params->get('text_block_bgcolor', 0);
		$this->clean_xhtml = $params->get('clean_xhtml', 0);
		$this->readmore_text = $params->get('readmore_text','Read more');
		$this->readmore_button = $params->get('readmore_button',1);
		$this->title_link = $params->get('title_link',1);
		$this->preloading = $params->get('preloading', 1);
		//
		$this->tabs_col = $params->get('tabs_col', 4);
		$this->tabs_row = $params->get('tabs_row', 4);
		$this->tabs_border = $params->get('tabs_border', 2);
		$this->tabs_margin = $params->get('tabs_margin', 5);
		$this->tabs_padding = $params->get('tabs_padding', 3);
		$this->tabs_position = $params->get('tabs_position', 'left');
		//
		$this->animation_slide_speed = $params->get('animation_slide_speed', 0);
		$this->animation_interval = $params->get('animation_interval', 0);
		$this->autoanimation = $params->get('autoanimation', 0);
		$this->animation_slide_type = $params->get('animation_slide_type', 0);
		$this->animation_text_type = $params->get('animation_text_type', 0);
		$this->clean_code = $params->get('clean_code', 1);
		$this->useMoo = $params->get('useMoo', 2);
		$this->useScript = $params->get('useScript', 2);
		$this->compress_js = $params->get('compress_js', 1);
		$this->clickable_slides = $params->get('clickable_slides', 1);
		//
		$uri =& JURI::getInstance();
		//
		$this->base_path_to_images = $uri->root().'components/com_gk2_photoslide/images';
		//
		$this->tooltips = $params->get('tooltips', 1);
		$this->tooltips_anim = $params->get('tooltips_anim', 1);
		//
		$this->tabs_amount = $this->tabs_col * $this->tabs_row;
		//
		$this->module_bg = $params->get('module_bg', '');
	}
	//
	function getDatas()
	{
		//
		$query = "SELECT * FROM #__gk2_photoslide_groups WHERE id = ".$this->group_id." LIMIT 1;";
		//
		$database = & JFactory::getDBO();
		$uri = JURI::getInstance();
		$database->setQuery($query);
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		//
		if( $dane = $database->loadObjectList() )
		{
			foreach($dane as $item)
			{
				$this->module_width = $item->mediumThumbX;
				$this->module_height = $item->mediumThumbY;
				$this->thumbnail_width = $item->smallThumbX;
				$this->thumbnail_height = $item->smallThumbY;
				//
				$this->base_bgcolor = $item->bgcolor;
				$this->base_titlecolor = $item->titlecolor;
				$this->base_textcolor = $item->textcolor;
				$this->base_linkcolor = $item->linkcolor;
				$this->base_hlinkcolor = $item->hlinkcolor;
			}
		}
		//
		$query = "
		SELECT 
			i.file AS name, 
			i.title AS title, 
			i.text AS text, 
			i.linktype AS linktype, 
			i.linkvalue AS linkvalue, 
			i.article AS article, 
			i.wordcount AS wordcount, 
			c.title AS ctitle, 
			c.introtext AS introtext, 
			c.id AS cid, 
			c.sectionid AS sid 
		FROM 
			#__gk2_photoslide_slides AS i 
		LEFT JOIN 
			#__content AS c 
			ON 
			i.article = c.id 
		WHERE 
			group_id = ".$this->group_id." 
			AND
			`i`.`published` = 1
			AND 
			`i`.`access` <= ".(int) $aid."
		ORDER BY 
			i.order ASC 
		LIMIT 
			".$this->tabs_amount.";";
		//
		$database->setQuery($query);
		// prepare array
		$this->slides = array();
		$prepared_image = array();
		//
		if($this->show_text_block == 1) $this->JSON = '<div class="gk_news_image_3_text_datas">';
		//
		if( $datas = $database->loadObjectList() )
		{
			foreach($datas as $item)
			{
				unset($prepared_image);
				//
				$prepared_image = array(
					'name' => $item->name,
					'title' => $item->title,
					'text' => $item->text,
					'linktype' => $item->linktype,
					'linkvalue' => $item->linkvalue,
					'article' => $item->article,
					'wordcount' => $item->wordcount,
					'introtext' => $item->introtext,
					'ctitle' => $item->ctitle,
					'sid' => $item->sid,
					'cid' => $item->cid
				);
				//
				if($this->show_text_block == 1)
				{ 
					$slide_title = ($item->title == '') ? $item->ctitle: $item->title;
					$slide_text = ($item->text == '') ? $item->introtext: $item->text;
					$slide_textcolor = $this->base_textcolor;
					//
					if($this->clean_xhtml == 1) $slide_text = strip_tags($slide_text);
					//
					if($item->wordcount != 0)
					{
						$exploded_text = explode(" ",$slide_text);
						$slide_text = '';
						//
						for($i = 0; $i < $item->wordcount;$i++)
						{
							if(count($exploded_text) > $i)
							{
								$slide_text .= $exploded_text[$i].' ';
							}
						}
						//
						$slide_text .= ' ';
					}
					//
					$slide_link = ($item->linktype != 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($item->article, $item->cid, $item->sid)) : $item->linkvalue;
					//
					if($this->title_link == 0)
					{
						$slide_text = '<h2 style="color:'.$this->base_titlecolor.';">'.$slide_title.'</h2><p style="color:'.$slide_textcolor.';">'.$slide_text;
					}
					else
					{
						$hover_effect = '';
						$hover_effect .= 'style="color:'.$this->base_titlecolor.';"' ;
						$hover_effect .= ' onmouseover="this.style.color = \''.$this->base_hlinkcolor.'\';" ';
						$hover_effect .= 'onmouseout="this.style.color = \''.$this->base_titlecolor.'\'" ';
						$slide_text = '<h2><a href="'.$slide_link.'" '.$hover_effect.' class="gk_news_image_title">'.$slide_title.'</a></h2><p style="color:'.$slide_textcolor.';">'.$slide_text;
					}
					//
					if($this->readmore_button == 1)
					{
						$hover_effect = '';
						$hover_effect .= 'style="color:'.$this->base_linkcolor.';"';
						$hover_effect .= ' onmouseover="this.style.color = \''.$this->base_hlinkcolor.'\';" ';
						$hover_effect .= 'onmouseout="this.style.color = \''.$this->base_linkcolor.'\'" ';
						$slide_text .= ' <a href="'.$slide_link.'" '.$hover_effect.' class="gk_news_image_link readon">'.$this->readmore_text.'</a>';
					}
					//
					$slide_text .= '</p>';
					$slide_text = str_replace("{mosimage}","",$slide_text);
					//
					$this->JSON .= '<div class="gk_news_image_3_news_text">'.$slide_text.'</div><div class="gk_news_image_3_news_bgcolor">'.$this->base_bgcolor.'</div>';
				}
				//
				array_push($this->slides, $prepared_image);
			}
		}
		//
		if($this->show_text_block == 1) $this->JSON .= '</div>';
	}
	//
	function generateContent()
	{
		// create instances of basic Joomla! classes
		$document =& JFactory::getDocument();
		$uri =& JURI::getInstance();
		// include file content.php and parse it
		require(JModuleHelper::getLayoutPath('mod_gk_news_image_3', 'content'));
		// add stylesheets to document header
		$document->addStyleSheet( $uri->root().'modules/mod_gk_news_image_3/css/style.css', 'text/css' );
		// init $headData variable
		$headData = false;
		// add scripts with automatic mode to document header
		if($this->useMoo == 2)
		{
			// getting module head section datas
			unset($headData);
			$headData = $document->getHeadData();
			// generate keys of script section
			$headData_keys = array_keys($headData["scripts"]);
			// set variable for false
			$mootools_founded = false;
			// searching phrase mootools in scripts paths
			for($i = 0;$i < count($headData_keys); $i++)
			{
				if(preg_match('/mootools/i', $headData_keys[$i]))
				{
					// if founded set variable to true and break loop
					$mootools_founded = true;
					break;
				}
			}
			// if mootools file doesn't exists in document head section
			if(!$mootools_founded)
			{
				// add new script tag connected with mootools from module
				$headData["scripts"][$uri->root().'modules/mod_gk_news_image_3/js/mootools.js'] = "text/javascript";
				// if added mootools from module then this operation have sense
				$document->setHeadData($headData);
			}
		}
		//
		if($this->useScript == 2)
		{
			// getting module head section datas
			unset($headData);
			$headData = $document->getHeadData();
			// generate keys of script section
			$headData_keys = array_keys($headData["scripts"]);
			// set variable for false
			$engine_founded = false;
			// searching phrase mootools in scripts paths
			if(array_search($uri->root().'modules/mod_gk_news_image_3/js/engine'.(($this->compress_js == 1) ? '_compressed' : '').'.js', $headData_keys) > 0)
			{
				// if founded set variable to true
				$engine_founded = true;
			}
			// if mootools file doesn't exists in document head section
			if(!$engine_founded)
			{
				// add new script tag connected with mootools from module
				$headData["scripts"][$uri->root().'modules/mod_gk_news_image_3/js/engine'.(($this->compress_js == 1) ? '_compressed' : '').'.js'] = "text/javascript";
				// if added mootools from module then this operation have sense
				$document->setHeadData($headData);
			}
		}
	
		// if clean code is enable use importer.php to include 
		// module settings in head section of document
		if($this->clean_code)
		{
			/* 
				add script tag with module configuration to document head section
			*/	
			
			// get head document section data 
			unset($headData);
			$headData = $document->getHeadData();
			// add new script tag to head document section data array	
			$headData["scripts"][$uri->root().'modules/mod_gk_news_image_3/js/importer.php?modid='.$this->module_id.'&amp;anim_speed='.$this->animation_slide_speed.'&amp;anim_interval='.$this->animation_interval.'&amp;autoanim='.$this->autoanimation.'&amp;anim_type='.$this->animation_slide_type.'&amp;anim_type_t='.$this->animation_text_type.'&amp;thumb_w='.$this->thumbnail_width.'&amp;thumb_h='.$this->thumbnail_height.'&amp;t_margin='.$this->tabs_margin.'&amp;t_border='.$this->tabs_border.'&amp;t_col='.$this->tabs_col.'&amp;t_row='.$this->tabs_row.'&amp;bgcolor='.substr($this->base_bgcolor,1).'&amp;opacity='.$this->text_block_opacity.'&amp;tooltips='.$this->tooltips.'&amp;tooltips_anim='.$this->tooltips_anim] = "text/javascript";
			
			// if added mootools from module then this operation have sense
			$document->setHeadData($headData);
		} 
						
		// add default.php template to parse if it's needed
		if($this->useMoo != 2 || $this->useScript != 2 || !$this->clean_code)
		{
			require(JModuleHelper::getLayoutPath('mod_gk_news_image_3', 'default'));
		}
	}
	
}

?>