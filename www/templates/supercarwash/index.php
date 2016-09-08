<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
</head>
<body>
	<? if($this->countModules("absolute")){ ?>
		<div id="absolute">
			<jdoc:include type="modules" name="absolute" style="xhtml" />
		</div>
	<? }?>
<div id="topheaderwrap"><div id="topheader"></div></div> 
<div id="topmenuwrap"><div id="topmenu"><jdoc:include type="modules" name="top" style="xhtml" />
</div></div>
<div id="headerwrap"><div id="header">
	<div id="header_content"><jdoc:include type="modules" name="advert1" style="xhtml" /></div></div></div> 
  <div id="bodywrap"> <div id="body"> 
		<div id="rightcolumn">
			<jdoc:include type="modules" name="right" style="xhtml" />
		</div>
	  <div id="mainbody">
	  <jdoc:include type="modules" name="user1" style="xhtml" />
	  <jdoc:include type="component" style="xhtml" /></div></div></div>
  <div id="footerwrap">
    <div id="footer"><jdoc:include type="modules" name="footer" style="xhtml" /><br /><jdoc:include type="modules" name="bottom" style="xhtml" />
    </div>
  </div>  
</body>
</html>