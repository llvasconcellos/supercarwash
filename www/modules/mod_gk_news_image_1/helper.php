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

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class GKNewsImage1Helper{
	
	var $module_id,
	$group_id,
	$show_text_block,
	$text_block_width,
	$text_block_margin,
	$text_block_opacity,
	$text_block_background,
	$text_block_bgcolor,
	$clean_xhtml,
	$readmore_text,
	$readmore_button,
	$title_link,
	$prev_button,
	$next_button,
	$play_button,
	$thumbnail_bar,
	$thumbnail_bar_position,
	$thumbnail_margin,
	$thumbnail_border,
	$thumbnail_border_color,
	$animation_slide_speed,
	$animation_interval,
	$autoanimation,
	$animation_slide_type,
	$animation_text_type,
	$useMoo,
	$useScript,
	$show_interface,
	$base_path_to_images,
	$module_width,
	$module_height,
	$thumbnail_width,
	$thumbnail_height,
	$base_bgcolor,
	$base_titlecolor,
	$base_textcolor,
	$base_linkcolor,
	$base_hlinkcolor,
	$clean_code,
	$slides,
	$JSON,
	$thumbnail_border_color_inactive,
	$interface_x,
	$interface_y,
	$links,
	$slidelinks,
	$image_x,
	$image_y,
	$show_ticks,
	$tick_x,
	$tick_y,
	$preloading,
	$compress_js;
	
	/**
		Initializing Class variables
	**/
	
	function initialize(&$params)
	{
		// Base settings
		$this->module_id = $params->get('module_id', '-mod');//
		$this->group_id = $params->get('group_id', 0);//
		$this->module_width = $params->get('module_width', 0);//
		$this->module_height = $params->get('module_height', 0);//
		$this->image_x = $params->get('image_x', 0);//
		$this->image_y = $params->get('image_y', 0);//
		// Content settings
		$this->show_text_block = $params->get('show_text_block', 1);//
		$this->text_block_width = $params->get('text_block_width', 0);//
		$this->text_block_margin = $params->get('text_block_margin', 0);//
		$this->text_block_opacity = $params->get('text_block_opacity', 0);//
		$this->text_block_background = $params->get('text_block_background', 0);//
		$this->text_block_bgcolor = $params->get('text_block_bgcolor', 0);//
		$this->clean_xhtml = $params->get('clean_xhtml', 0);//
		$this->readmore_text = $params->get('readmore_text','Read more');//
		$this->readmore_button = $params->get('readmore_button',1);//
		$this->title_link = $params->get('title_link',1);//
		// interface configuration
		$this->prev_button = $params->get('prev_button', 0);//
		$this->next_button = $params->get('next_button', 0);//
		$this->play_button = $params->get('play_button', 0);//
		$this->interface_x = $params->get('interface_x', 20);//
		$this->interface_y = $params->get('interface_y', 20);//
		$this->tick_x = $params->get('tick_x', 20);//
		$this->tick_y = $params->get('tick_y', 20);//
		$this->slidelinks = $params->get('slidelinks', 1);//
		$this->show_ticks = $params->get('show_ticks', 1);//
		$this->preloading = $params->get('preloading', 1);//
		// thumbnail bar configuration
		$this->thumbnail_bar = $params->get('thumbnail_bar', 0);
		$this->thumbnail_bar_position = $params->get('thumbnail_bar_position', 0);
		$this->thumbnail_margin = $params->get('thumbnail_margin', 0);
		$this->thumbnail_border = $params->get('thumbnail_border', 0);
		$this->thumbnail_border_color_inactive = $params->get('thumbnail_border_color_inactive', '#000000');
		$this->thumbnail_border_color = $params->get('thumbnail_border_color', '#FFFFFF');
		// animation configuration
		$this->animation_slide_speed = $params->get('animation_slide_speed', 0);//
		$this->animation_interval = $params->get('animation_interval', 0);//
		$this->autoanimation = $params->get('autoanimation', 0);//
		$this->animation_slide_type = $params->get('animation_slide_type', 0);//
		$this->animation_text_type = $params->get('animation_text_type', 0);//
		// scripts configuration
		$this->clean_code = (bool) $params->get('clean_code', 1);
		$this->useMoo = $params->get('useMoo', 2);
		$this->useScript = $params->get('useScript', 2);
		$this->compress_js = $params->get('compress_js', 1);
		// basic configuration
		$uri =& JURI::getInstance();
		$this->interface_x -= 20;
		$this->base_path_to_images = $uri->root().'components/com_gk2_photoslide/images';
		$this->show_interface = true;
		if($this->play_button == 0 && $this->prev_button == 0 && $this->next_button == 0) $this->show_interface = false;
	}

	/**
		Getting base configuration of group
	**/
	
	function getDatas()
	{
		// get SQL query
		$query = "
		SELECT 
			* 
		FROM 
			#__gk2_photoslide_groups 
		WHERE 
			`id` = ".$this->group_id." 
		LIMIT 1;
		";
		$database = & JFactory::getDBO();
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		
		$uri = JURI::getInstance();
		$database->setQuery($query);
		// prepare informations
		if( $dane = $database->loadObjectList() )
		{
			foreach($dane as $item)
			{
				if($this->module_width == 0) $this->module_width = $item->mediumThumbX;
				if($this->module_height == 0) $this->module_height = $item->mediumThumbY;
				$this->thumbnail_width = $item->smallThumbX;
				$this->thumbnail_height = $item->smallThumbY;
				$this->base_bgcolor = ($this->text_block_background == 1) ? $item->bgcolor : $this->text_block_bgcolor;
				$this->base_titlecolor = $item->titlecolor;
				$this->base_textcolor = $item->textcolor;
				$this->base_linkcolor = $item->linkcolor;
				$this->base_hlinkcolor = $item->hlinkcolor;
			}
		}
		else
		{
			echo '<strong>Error:</strong> You haven\'t selected slide group or selected group haven\'t any slides';
			exit();
		}

		/**
			Getting informations about images
		**/

		// get SQL query
		$query = '
		SELECT 
			`c`.`sectionid` AS `sid`,
			`i`.`file` AS `file`, 
			`i`.`title` AS `title`, 
			`i`.`text` AS `text`, 
			`i`.`linktype` AS `linktype`, 
			`i`.`linkvalue` AS `linkvalue`, 
			`i`.`article` AS `article`, 
			`i`.`wordcount` AS `wordcount`, 
			`c`.`title` AS `ctitle`, 
			`c`.`introtext` AS `introtext`, 
			`c`.`id` AS `cid` 
		FROM 
			#__gk2_photoslide_slides AS `i` 
		LEFT JOIN 
			#__content AS `c` 
			ON 
			`i`.`article` = `c`.`id` 
		WHERE 
			`i`.`group_id` = '.$this->group_id.'
			AND
			`i`.`published` = 1
			AND 
			`i`.`access` <= '.(int) $aid.'
		ORDER BY 
			`i`.`order`,
			`i`.`access` ASC;
		';
		
		$database->setQuery($query);
		// prepare array
		$this->slides = array();
		$this->links = array();
		$prepared_image = array();

		if($this->show_text_block == 1) $this->JSON = '<div class="gk_news_image_1_text_datas">';

		if( $datas = $database->loadObjectList() )
		{
			foreach($datas as $item)
			{
				unset($prepared_image);
				unset($slide_link);
		
				$prepared_image = array(
					'name' => $item->file,
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
				
				$slide_link = ($item->linktype != 0) ? JRoute::_(ContentHelperRoute::getArticleRoute($item->article, $item->cid, $item->sid)) : $item->linkvalue;
				array_push($this->links, $slide_link);
				
				if($this->show_text_block == 1)
				{ 
					$slide_title = ($item->title == '') ? $item->ctitle: $item->title;
					$slide_text = ($item->text == '') ? $item->introtext: $item->text;
					$slide_textcolor = $this->base_textcolor;
		
					if($this->clean_xhtml == 1) $slide_text = strip_tags($slide_text);
		
					if($item->wordcount != 0)
					{
						$exploded_text = explode(" ",$slide_text);
						$slide_text = '';
						for($i = 0; $i < $item->wordcount;$i++)
						{
							if($i < count($exploded_text))
							{
								$slide_text .= $exploded_text[$i].' ';
							}
						} 
						
						$slide_text .= ' ';
					}
		
					if($this->title_link == 0)
					{
						$slide_text = '<h2 style="color:'.$item->titlecolor.';">'.$slide_title.'</h2><p style="color:'.$slide_textcolor.';">'.$slide_text;
					}
					else
					{
						$hover_effect = '';
						$hover_effect .= 'style="color:'.$this->base_linkcolor.';"';
						$hover_effect .= ' onmouseover="this.style.color = \''.$this->base_hlinkcolor.'\';" ';
						$hover_effect .= 'onmouseout="this.style.color = \''.$this->base_linkcolor.'\'" ';
						$slide_text = '<h2><a href="'.$slide_link.'" '.$hover_effect.' class="gk_news_image_title">'.$slide_title.'</a></h2><p style="color:'.$slide_textcolor.';">'.$slide_text;
					}
		
					if($this->readmore_button == 1)
					{
						$hover_effect = '';
						$hover_effect .= 'style="color:'.$this->base_linkcolor.';"';
						$hover_effect .= ' onmouseover="this.style.color = \''.$this->base_hlinkcolor.'\';" ';
						$hover_effect .= 'onmouseout="this.style.color = \''.$this->base_linkcolor.'\'" ';
						$slide_text .= ' <a href="'.$slide_link.'" '.$hover_effect.' class="gk_news_image_link readon">'.$this->readmore_text.'</a>';
					}
		
					$slide_text .= '</p>';
					$slide_text = str_replace("{mosimage}","",$slide_text);
			
					$this->JSON .= '<div class="gk_news_image_1_news_text">'.$slide_text.'</div>';
				}
		
				array_push($this->slides, $prepared_image);
			}
		}
		else
		{
			echo '<strong>Error:</strong> You haven\'t selected slide group or selected group haven\'t any slides';
			exit();
		}

		if($this->show_text_block == 1) $this->JSON .= '</div>';
	}

	
	/**
		Generating content
	**/
	
	function generateContent()
	{		
		// create instances of basic Joomla! classes
		$document =& JFactory::getDocument();
		$uri =& JURI::getInstance();
		// include file content.php and parse it
		require(JModuleHelper::getLayoutPath('mod_gk_news_image_1', 'content'));
		// add stylesheets to document header
		
		$querystring = '?text_block_background='.str_replace('#','',$this->text_block_background).'&amp;text_block_bgcolor='.str_replace('#','',$this->base_bgcolor).'&amp;text_block_width='.$this->text_block_width.'&amp;text_block_opacity='.$this->text_block_opacity.'&amp;text_block_margin='.$this->text_block_margin.'&amp;module_width='.$this->module_width.'&amp;module_height='.$this->module_height.'&amp;thumbnail_bar='.$this->thumbnail_bar.'&amp;thumbnail_width='.$this->thumbnail_width.'&amp;thumbnail_height='.$this->thumbnail_height.'&amp;thumbnail_margin='.$this->thumbnail_margin.'&amp;thumbnail_border='.$this->thumbnail_border.'&amp;thumbnail_bar_position='.$this->thumbnail_bar_position.'&amp;image_x='.$this->image_x.'&amp;image_y='.$this->image_y.'&amp;slides_count='.count($this->slides).'&amp;tick_x='.$this->tick_x.'&amp;tick_y='.$this->tick_y.'&amp;modid='.$this->module_id.'&amp;thumbnail_border_color_inactive='.substr($this->thumbnail_border_color_inactive, 1).'&amp;base_bgcolor='.substr($this->base_bgcolor, 1);
		
		$document->addStyleSheet( $uri->root().'modules/mod_gk_news_image_1/css/style.php'.$querystring, 'text/css' );
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
				$headData["scripts"][$uri->root().'modules/mod_gk_news_image_1/js/mootools.js'] = "text/javascript";
				// if added mootools from module then this operation have sense
				$document->setHeadData($headData);
			}
		}
		
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
			if(array_search($uri->root().'modules/mod_gk_news_image_1/js/engine'.(($this->compress_js == 1) ? '_compress' : '').'.js', $headData_keys) > 0)
			{
				// if founded set variable to true
				$engine_founded = true;
			}
			// if mootools file doesn't exists in document head section
			if(!$engine_founded)
			{
				// add new script tag connected with mootools from module
				$headData["scripts"][$uri->root().'modules/mod_gk_news_image_1/js/engine'.(($this->compress_js == 1) ? '_compress' : '').'.js'] = "text/javascript";
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
			$headData["scripts"][$uri->root().'modules/mod_gk_news_image_1/js/importer.php?mid='.$this->module_id.'&amp;animation_slide_speed='.$this->animation_slide_speed.'&amp;animation_interval='.$this->animation_interval.'&amp;autoanimation='.$this->autoanimation.'&amp;animation_slide_type='.$this->animation_slide_type.'&amp;animation_text_type='.$this->animation_text_type.'&amp;base_bgcolor='.str_replace('#','',$this->base_bgcolor).'&amp;text_block_opacity='.$this->text_block_opacity.'&amp;thumbnail_width='.$this->thumbnail_width.'&amp;thumbnail_margin='.$this->thumbnail_margin.'&amp;thumbnail_border='.$this->thumbnail_border.'&amp;thumbnail_border_color='.str_replace('#','',$this->thumbnail_border_color).'&amp;thumbnail_border_color_inactive='.str_replace('#','',$this->thumbnail_border_color_inactive).'&amp;interface_x='.$this->interface_x.'&amp;interface_y='.$this->interface_y.'&amp;clickable_slides='.$this->slidelinks] = "text/javascript";
			
			// if added mootools from module then this operation have sense
			$document->setHeadData($headData);
		} 
						
		// add default.php template to parse if it's needed
		if($this->useMoo != 2 || $this->useScript != 2 || !$this->clean_code)
		{
			require(JModuleHelper::getLayoutPath('mod_gk_news_image_1', 'default'));
		}
	}
		
	/**
		Showing informations about error - error string as attribute
	**/
	
	function error($error)
	{
		require(JModuleHelper::getLayoutPath('mod_gk_news_image_1', 'error'));
	}
}

?>