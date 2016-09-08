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


/**
	access restriction
**/

defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'helper.php');

$helper = new gk_news_image_3_helper();
$helper->initialize($params);
$helper->getDatas();
$helper->generateContent();

?>