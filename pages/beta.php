<?php

function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}


if(isset($_POST['submit'])) {
	$email = trim($_POST['email']);
	$email = stripslashes($email);
	$check_email = check_email_address($email);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: '.$email.' <'.$email.'>' . "\r\n";
	if($check_email) {
		if(mail('nikki.lamagna@gmail.com', 'ZenToDoneApp.com Newsletter Request', 'Hello! Please add '.$email.' to the newsletter. Thank you!',$headers)) {
			$output = '<p class="message success">You have successfully signed up for our newsletter. Thank you!.</p>';
		} else {
			$ouput = '<p class="message error">Oops. There seems to have been a problem with signing you up. Please try again.</p>';
		}
	} else {
		$output = '<p class="message error">That is not a valid email address. Please try again.</p>';
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zen To Done App | Online Productivity Application &raquo; Simplify</title>
<meta name="keywords" content="Zen To Done, Getting Things Done, GTD, ZTD, productivity, to-do list, simplify, simple" />
<meta name="description" content="ZenToDoneApp.com is an online productivity application that harnesses the power of GTD (Getting Things Done) & ZTD (Zen To Done)." />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
	<script type="text/javascript" src="./resources/scripts/fancybox/jquery.fancybox-1.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="./resources/scripts/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
 	<link rel="stylesheet" href="<?php echo SITE_URL; ?>/resources/styles/style.css" />
 	<link rel="stylesheet" href="<?php echo SITE_URL; ?>/resources/styles/beta.css" />
 	<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/

			$("a#example1").fancybox({
				'titleShow'		: false
			});

		});
	</script>
<script type="text/javascript">
function clickclear(thisfield, defaulttext) {
if (thisfield.value == defaulttext) {
thisfield.value = "";
}
}
function clickrecall(thisfield, defaulttext) {
if (thisfield.value == "") {
thisfield.value = defaulttext;
}
}
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
<body>

	<div id="wrapper">

		<h1>ZenToDone App</h1>
		
		<div id="content">
		
		<?php echo output_message($session->message); ?>
		
		<p id="intro"><a href="http://ZenToDoneApp.com">ZenToDoneApp.com</a> is an online productivity application that harnesses the power of GTD <em>(<strong>G</strong>etting <strong>T</strong>hings <strong>D</strong>one)</em> &amp; ZTD <em>(<strong>Z</strong>en <strong>T</strong>o <strong>D</strong>one)</em>. ZTD was created by Leo Babauta of <a href="http://zenhabits.net">Zen Habits</a>. <a href="http://ZenToDoneApp.com">ZenToDoneApp.com</a> was created by <a href="http://geekdesigngirl.com">The GeekDesignGirl Project</a>. <a href="https://www.e-junkie.com/ecom/gb.php?ii=56260&c=ib&aff=131146&cl=10747">Read more about Zen To Done.</a></p>
		<h2>Demo Video</h2>
		<iframe src="http://player.vimeo.com/video/15318794?byline=0&amp;portrait=0&amp;color=BD1D01" width="490" height="380" frameborder="0"></iframe>
		<h2>Newsletter</h2>
		<p>Invitations to the beta release of Zen To Done App are now closed. If you would like to be notified when Zen To Done App is released to the public, please sign-up below.</p>
		<?php if(isset($output)) { echo $output; } ?>
		<form action="" method="post">
			<input type="text" value="Email" name="email" onclick="clickclear(this, 'Email')" onblur="clickrecall(this,'Email')" /> <input type="submit" class="submit" value="Submit" name="submit" />
		</form>
		
		
		<div id="social">
			<script type="text/javascript">
				tweetmeme_style = 'compact';
			</script>
			<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>		
			
			<p>Get updates at <a href="http://geekdesigngirl.com/category/zen-to-done-app/">The GeekDesignGirl Project</a>, the maker of this new app!</p>	
		</div>
		
		</div>
		
		<div id="secondary">
		
		<?php if(!empty($user->id)) { ?>
		
		<h2>Welcome back,<br /><?php if(!empty($user->first_name)) { echo $user->first_name; } else { $user->username; } ?></h2>
		<p><a href="<?php echo SITE_URL.DS.'home'.DS; ?>">Go to your home page &raquo;</a></p>
		<h2>Bookmarklet</h2>
		<p>Drag this button to your Bookmark bar for easy access to all your MITs! As long as you don't log out or clear your browser cache, you'll have no problem accessing your account.<br />
		<a id="bookmark" href="<?php echo SITE_URL.DS.'home'.DS; ?>" title="ZenToDoneApp">ZenToDoneApp</a></p>
		
		<?php } else { ?>
		
		<h2>Login</h2>
		<?php if(isset($error)) { echo '<p class="error">'.$error.'</p>'; } ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login">

			<fieldset>
			
				<label for="username">Username</label>
				<input type="text" name="username" id="username" value="" />
				
				<label for="password">Password</label>
				<input type="password" name="password" id="password" />
				
				<label for="remember">Remember me</label>
				<input type="checkbox" name="remember" value="1" class="small" />
							
				<input type="submit" name="login" id="submit" class="submit" value="Log in" />
				
				<a href="<?php echo SITE_URL.DS.'forgot-password'.DS; ?>">Forgot password?</a>
			
			</fieldset>

		</form>
		
		<h2>Beta Tester?</h2>
		<p>Did you receive a beta invitation? You did? Great! Head on over to the <a href="<?php echo SITE_URL.DS.'sign-up'.DS; ?>">beta sign-up page</a> to enter your invite code.</p>
		
		<a id="button" href="<?php echo SITE_URL.DS.'sign-up'.DS; ?>">I'm a beta tester! Sign Me Up &raquo;</a>
		
		<?php } ?>
		
		
		
		<h2>FAQs</h2>
		<p>Interested in learning more. <a href="<?php echo SITE_URL.DS.'faq'.DS; ?>">Read the FAQs!</a></p>
		
		<div id="twitter_div">
		<h2 class="sidebar-title">Twitter Updates</h2>
		<ul id="twitter_update_list"></ul>
		<p><a href="http://twitter.com/ztd_app" id="twitter-link">Follow @ztd_app on Twitter &raquo;</a></p>
		</div>
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/ztd_app.json?callback=twitterCallback2&amp;count=5"></script>
				
		</div>

<?php require_once INCLUDES.DS.'public_footer.inc.php'; ?>