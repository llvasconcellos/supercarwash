<?php

/**
* @author: GavickPro
* @copyright: 2008
**/

/**
	Class News
**/

class News
{	
	function newsRSS()
	{
		$newses = '';
		
		if(ini_get('allow_url_fopen'))
		{
			$newses = file_get_contents('http://gavick.com/index.php?format=feed&type=rss');
			$xml = & JFactory::getXMLParser('Simple');
			
			if($xml->loadString($newses))
			{
				$newses = '';
				$i = 0;
				
				while(isset($xml->document->channel[0]->item[$i]))
				{
					$newses .= '<h2><a href="'.$xml->document->channel[0]->item[$i]->link[0]->data().'">'.$xml->document->channel[0]->item[$i]->title[0]->data().'</a> <small><sub>'.$xml->document->channel[0]->item[$i]->pubDate[0]->data().'</sub></small></h2>';
					$newses .= $xml->document->channel[0]->item[$i]->description[0]->data().'<br /><br /><a href="'.$xml->document->channel[0]->item[$i]->link[0]->data().'">Read more &raquo;</a><br /><br />';
					$i++;
				}	
			}
			else
			{
				$newses = JText::_('NEWS_PARSEERROR');
			}
		}
		else{
			$newses = JText::_('NEWS_NOCONF');
		}
		
		return $newses;
	}
}

?>