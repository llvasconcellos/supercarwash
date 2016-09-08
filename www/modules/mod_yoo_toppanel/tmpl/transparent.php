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
?>
<div class="<?php echo $style ?>">
	<div id="<?php echo $toppanel_id ?>" class="yoo-toppanel">

		<div class="panel-container" style="<?php echo $css_top_position ?>">
			<div class="panel-wrapper">
				<div class="panel" style="<?php echo $css_module_height . modYOOtoppanelHelper::correctPng($module_base."styles/".$style."/images/panel_bg.png") ?>">
					<div class="content" style="<?php echo $css_module_width ?>">
						<?php if ($button): ?>
						<div class="close">
							<?php echo $button_label ?>
						</div>
						<?php endif; ?>
						<?php for ($i=0; $i < $items; $i++) : ?>
						<?php modYOOtoppanelHelper::renderItem($list[$i], $params, $access); ?>
						<?php endfor; ?>
					</div>
				</div>
			</div>
								
			<div class="trigger" style="<?php echo $css_left_position ?>">
				<div class="trigger-l" style="<?php echo modYOOtoppanelHelper::correctPng($module_base."styles/".$style."/images/trigger_l.png") ?>"></div>
				<div class="trigger-m"><?php echo $trigger_label ?></div>
				<div class="trigger-r" style="<?php echo modYOOtoppanelHelper::correctPng($module_base."styles/".$style."/images/trigger_r.png") ?>"></div>
			</div>
		</div>
			
	</div>		
</div>