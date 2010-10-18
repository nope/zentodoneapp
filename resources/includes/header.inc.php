<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zen To Done App | Online Productivity Application</title>
	<link href="<?php echo SITE_URL.DS; ?>resources/styles/style.css" media="screen" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo SITE_URL.DS; ?>resources/styles/datePicker.css" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo SITE_URL.DS; ?>resources/scripts/editable.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="<?php echo SITE_URL.DS; ?>resources/scripts/jquery.core.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL.DS; ?>resources/scripts/widget.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL.DS; ?>resources/scripts/datePicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		
			<?php if($page2=='contexts' && !empty($page3)) { 
			$i = 1; foreach($contexts as $mit) : ?>
		$( "#datepicker<?php echo $i; ?>" ).datepicker({dateFormat: 'yy-mm-dd',firstDay: <?php echo $week_start; ?>});
     		$('.titleEdit<?php echo $i; ?>').editable('<?php echo SITE_URL.DS; ?>resources/application/run/save-item-name.php', { 
     			indicator : "<img src='<?php echo SITE_URL.DS; ?>'resources/images/indicator.gif'>",
     			name	: 'item',
     			elemtent_id		: 'id'
     		});
     		$('.descEdit<?php echo $i; ?> ').editable('<?php echo SITE_URL.DS; ?>resources/application/run/save-notes.php', { 
     			type   : 'textarea',
      			submitdata: { _method: "put" },
      			indicator : "<img src='<?php echo SITE_URL.DS; ?>'resources/images/indicator.gif'>",
      			select : true,
      			submit : 'save',
      			cancel : 'cancel',
      			cssclass : "editable",
      			tooltip   : "Click to edit...",
      			name : 'notes',
      			element_id : 'id'
      		});
      		$('.contextEdit<?php echo $i; ?>').editable('<?php echo SITE_URL.DS; ?>resources/application/run/save-context.php', { 
     			style : 'inherit',
     			indicator : "<img src='<?php echo SITE_URL.DS; ?>'resources/images/indicator.gif'>",
     			tooltip   : "Add context",
     			name	: 'context',
     			elemtent_id		: 'id'
     		});
	       	<?php $i++; endforeach;  } elseif(!empty($mits)) { ?>
	       	
			<?php $i = 1; foreach($mits as $mit) : ?>
		$( "#datepicker<?php echo $i; ?>" ).datepicker({dateFormat: 'yy-mm-dd',firstDay: <?php echo $week_start; ?>});
     		$('.titleEdit<?php echo $i; ?>').editable('<?php echo SITE_URL.DS; ?>resources/application/run/save-item-name.php', { 
     			indicator : "<img src='<?php echo SITE_URL.DS; ?>'resources/images/indicator.gif'>",
     			name	: 'item',
     			elemtent_id		: 'id'
     		});
     		$('.descEdit<?php echo $i; ?> ').editable('<?php echo SITE_URL.DS; ?>resources/application/run/save-notes.php', { 
     			type   : 'textarea',
      			submitdata: { _method: "put" },
      			indicator : "<img src='<?php echo SITE_URL.DS; ?>'resources/images/indicator.gif'>",
      			select : true,
      			submit : 'save',
      			cancel : 'cancel',
      			cssclass : "editable",
      			tooltip   : "Click to edit...",
      			name : 'notes',
      			element_id : 'id'
      		});
      		$('.contextEdit<?php echo $i; ?>').editable('<?php echo SITE_URL.DS; ?>resources/application/run/save-context.php', { 
     			style : 'inherit',
     			indicator : "<img src='<?php echo SITE_URL.DS; ?>'resources/images/indicator.gif'>",
     			tooltip   : "Add context",
     			name	: 'context',
     			elemtent_id		: 'id'
     		});
	       	<?php $i++; endforeach; } ?>
	       	
	       	// toggles the slickbox on clicking the noted link 
	       	$('.description').hide();
	       	//$('.inbox-box').hide();
			$("a.show-hide").click(function(){
			$(this).toggleClass("show-hide-active").next().slideToggle("slow");
			});
					
			$("#secondary li").hover(
  				function () {
    				$(this).addClass("hover");
  				},
  				function () {
    				$(this).removeClass("hover");
  				}
			);
			
			
			//Following code for inbox pop-up is from here: http://www.queness.com/post/77/simple-jquery-modal-window-tutorial - Thanks Kevin!
			//select all the a tag with name equal to modal
			$('a[name=modal]').click(function(e) {
				//Cancel the link behavior
				e.preventDefault();
				//Get the A tag
				var id = $(this).attr('href');
	
				//Get the screen height and width
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
			
				//Set height and width to mask to fill up the whole screen
				$('#mask').css({'width':maskWidth,'height':maskHeight});
		
				//transition effect		
				$('#mask').fadeIn(100);	
				$('#boxes').fadeTo("fast",0.95);	
	
				//Get the window height and width
				var winH = $(window).height();
				var winW = $(window).width();
              
				//Set the popup window to center
				//$(id).css('top',  winH/3-$(id).height()/1.5);
				//$(id).css('left', winW/2-$(id).width()/1.9);
	
				//transition effect
				$(id).fadeIn(100); 
	
			});
	
			//if close button is clicked
			$('.window .close').click(function (e) {
				//Cancel the link behavior
				e.preventDefault();
				$('#mask, .window').hide();
			});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});
	
	});
 </script>
 
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
<body id="logged-in" class="<?php echo $page; ?>">

	<div id="wrapper">
	
		<div id="header">
			
			<h1><a href="<?php if(isset($_SESSION['user_id'])) { echo SITE_URL.$home_link; } else { echo SITE_URL; } ?>">ZenToDone App</a></h1>
			
			<ul>
				<li><a href="<?php if(isset($_SESSION['user_id'])) { echo SITE_URL.$home_link; } else { echo SITE_URL; } ?>" accesskey="h">Home</a></li>
				<li><a href="#dialog" name="modal" accesskey="a">Add</a></li>
				<li><a href="<?php echo SITE_URL.DS.'plan'.DS; ?>" accesskey="p">Plan</a></li>
				<li><a href="<?php if(isset($_SESSION['user_id'])) { echo SITE_URL.DS.'account'.DS; ?>">Account<?php } else { echo SITE_URL.DS.'login'.DS; ?>">Login<?php } ?></a></li>
			</ul>
		
		</div>
		
