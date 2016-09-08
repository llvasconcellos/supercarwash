<?php

/**
* @author: GavickPro
* @copyright: 2008
**/
	
// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<h3 style="text-align: center;color: #787878;"><?php echo $LANG->GroupSettings; ?></h3>

<table class="adminlist">
<thead>
	<tr>
		<th>Property</th>
		<th>Value</th>
	</tr>
</thead>
<tbody>
<tr>	
	<td><?php echo $LANG->GroupName; ?></td>
	<td><?php echo $name; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->ImageSize; ?></td>
	<td><?php echo $mediumThumbX.' x '.$mediumThumbY.'px'; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->ThumbnailSize; ?></td>
	<td><?php echo $smallThumbX.' x '.$smallThumbY.'px'; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->Backgroud; ?></td>
	<td><div style="width: 10px;height: 10px;border: 2px solid #DDD;margin-right: 5px;background: <?php echo $bgcolor; ?>;float: left;"></div><?php echo $bgcolor; ?></td>
</tr>
<tr>	
	<td><?php echo $LANG->Title; ?></td>
	<td><div style="width: 10px;height: 10px;border: 2px solid #DDD;margin-right: 5px;background: <?php echo $titlecolor; ?>;float: left;"></div><?php echo $titlecolor; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->Link; ?></td>
	<td><div style="width: 10px;height: 10px;border: 2px solid #DDD;margin-right: 5px;background: <?php echo $linkcolor; ?>;float: left;"></div><?php echo $linkcolor; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->HoverLink; ?></td>
	<td><div style="width: 10px;height: 10px;border: 2px solid #DDD;margin-right: 5px;background: <?php echo $hlinkcolor; ?>;float: left;"></div><?php echo $hlinkcolor; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->Quality; ?></td>
	<td><?php echo $quality; ?>%</td>
</tr>
</tbody>
</table>