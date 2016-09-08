<?php
/**
* YOOtoppanel Joomla! Module
*
* @author    yootheme.com
* @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
* @license	 GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;

// count instances
if (!isset($GLOBALS['yoo_toppanels'])) {
	$GLOBALS['yoo_toppanels'] = 1;
} else {
	$GLOBALS['yoo_toppanels']++;
}

// include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// disable edit ability icon
$access = new stdClass();
$access->canEdit	= 0;
$access->canEditOwn = 0;
$access->canPublish = 0;

$list = modYOOtoppanelHelper::getList($params, $access);

// check if any results returned
$items = count($list);
if (!$items) {
	return;
}

// init vars
$style             = $params->get('style', 'default');
$top_position      = $params->get('top_position', '0');
$left_position     = $params->get('left_position', '50');
$module_height     = $params->get('module_height', '340');
$module_width      = $params->get('module_width', '600');
$trigger_label     = $params->get('trigger_label', 'Toppanel');
$button_label      = $params->get('button_label', 'close');
$button            = $params->get('button', 1);
$fx_duration       = $params->get('fx_duration', 500);
$module_base       = JURI::base() . 'modules/mod_yoo_toppanel/';

// css parameters
$toppanel_id       = 'yoo-toppanel-' . $GLOBALS['yoo_toppanels'];
$css_top_position  = 'top: ' . $top_position . 'px;';
$css_left_position = 'left: ' . $left_position . '%;';
$css_module_height = 'height: ' . $module_height . 'px; margin-top: -' . $module_height . 'px;';
$css_module_width  = 'width: ' . $module_width . 'px;';

// js parameters
$javascript_var    = 'panelFx' . $GLOBALS['yoo_toppanels'];
$javascript        = "var $javascript_var = new YOOtoppanel('$toppanel_id', { offset: $module_height, transition: Fx.Transitions.expoOut, duration: $fx_duration });";
$javascript       .= "\n$javascript_var.addTriggerEvent('#$toppanel_id .trigger')";
$javascript       .= "\n$javascript_var.addTriggerEvent('#$toppanel_id .close');";

switch ($style) {
	case "transparent":
		require(JModuleHelper::getLayoutPath('mod_yoo_toppanel', 'transparent'));
   		break;
	default:
    	require(JModuleHelper::getLayoutPath('mod_yoo_toppanel', 'default'));
}

$document =& JFactory::getDocument();
$document->addStyleSheet($module_base . 'mod_yoo_toppanel.css.php');
$document->addScript($module_base . 'mod_yoo_toppanel.js');
echo "<script type=\"text/javascript\">\n// <!--\n$javascript\n// -->\n</script>\n";