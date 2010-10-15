<?php require $_SERVER['DOCUMENT_ROOT'] . '/ztda-config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zen To Done App | Online Productivity Application</title>
<meta name="keywords" content="Zen To Done, Getting Things Done, GTD, ZTD, productivity, to-do list, simplify, simple" />
<meta name="description" content="ZenToDoneApp.com is an online productivity application that harnesses the power of GTD (Getting Things Done) & ZTD (Zen To Done)." />
<link href="<?php echo SITE_URL.DS; ?>resources/styles/style.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
 	 var _gaq = _gaq || [];
 	_gaq.push(['_setAccount', 'UA-18014125-1']);
  	_gaq.push(['_trackPageview']);

  	(function() {
    	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  	})();
</script>
</head>
<body>

	<div id="wrapper">
	
		<div id="header">
			
			<h1><a href="<?php echo SITE_URL; ?>">ZenToDone App</a></h1>
			
			<ul>
				<li><a href="<?php if(isset($_SESSION['user_id'])) { echo SITE_URL.$home_link; } else { echo SITE_URL; } ?>">Home</a></li>
				<li><a href="<?php echo SITE_URL.DS.'about'.DS; ?>">About</a></li>
				<li><a href="<?php echo SITE_URL.DS.'faq'.DS; ?>">FAQ</a></li>
				<li><a href="<?php if(isset($_SESSION['user_id'])) { echo SITE_URL.DS.'account'.DS; ?>">Account<?php } else { echo SITE_URL.DS.'login'.DS; ?>">Login<?php } ?></a></li>
			</ul>
		
		</div>