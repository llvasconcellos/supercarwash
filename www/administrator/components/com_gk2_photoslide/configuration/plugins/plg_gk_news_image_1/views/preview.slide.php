<?php

/**
* @author: GavickPro
* @copyright: 2008
**/
	
// no direct access
defined('_JEXEC') or die('Restricted access');

// JURI
$uri =& JURI::getInstance();

?>

<h3 style="text-align: center;color: #787878;"><?php echo $LANG->SlideSettings; ?></h3>

<table class="adminlist">
<thead>
	<tr>
		<th>Property</th>
		<th>Value</th>
	</tr>
</thead>
<tbody>
<tr>	
	<td><?php echo $LANG->SlideName; ?></td>
	<td><?php echo $name; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideAccess; ?></td>
	<td><?php
		switch($access)
		{
			case 0 : echo '<strong><font color="green">'.$LANG->SLIDE_PUBLIC.'</font></strong>';break;
			case 1 : echo '<strong><font color="red">'.$LANG->SLIDE_REGISTRED.'</font></strong>';break;
			case 2 : echo '<strong><font color="gray">'.$LANG->SLIDE_SPECIAL.'</font></strong>';break;
		} 
	?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlidePreview; ?></td>
	<td>
		<a href="<?php echo $uri->root().'components/com_gk2_photoslide/images/thumbm/'.$file; ?>" onclick="new Event(event).stop();Lightbox.anchors.push(this);Lightbox.show(this.href, this.title)">
			<?php echo $LANG->SlideImage; ?>
		</a>, 
		<a href="<?php echo $uri->root().'components/com_gk2_photoslide/images/thumbs/'.$file; ?>" onclick="new Event(event).stop();Lightbox.anchors.push(this);Lightbox.show(this.href, this.title)">
			<?php echo $LANG->SlideThumb; ?>
		</a>
	</td>
</tr>
<tr>
	<td><?php echo $LANG->SlideTitle; ?></td>
	<td><?php echo ($title == '') ? '-' : $title; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideText; ?></td>
	<td><?php echo ($text == '') ? '-' : $text; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideLinkType; ?></td>
	<td><?php echo ($linktype == 0) ? 'Your own value' : 'Article link'; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideLinkValue; ?></td>
	<td><?php echo ($linkvalue == '') ? '-' : $linkvalue; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideArticle; ?></td>
	<td><?php echo ($article == 0) ? 'Your own article' : $article; ?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideWordcount; ?></td>
	<td><?php echo $wordcount;?></td>
</tr>
<tr>
	<td><?php echo $LANG->SlideStretch; ?></td>
	<td><?php echo ($stretch == 0) ? $LANG->NO : $LANG->YES; ?></td>
</tr>