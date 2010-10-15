<div id="footer">

	<p id="copyright">Copyright &copy; <?php echo date('Y'); ?>. <a href="<?php echo SITE_URL; ?>">ZenToDoneApp.com</a><br /><a href="http://geekdesigngirl.com/">The GdG Project</a></p>
	
	<ul>
		<?php if(!empty($_SESSION['user_id'])) { ?><li><strong><a href="<?php echo SITE_URL.DS.'feedback'.DS; ?>">Feedback</a></strong></li><?php } ?>
		<li><a href="<?php echo SITE_URL.DS.'about'.DS; ?>">About</a></li>
		<li><a href="<?php echo SITE_URL.DS.'faq'.DS; ?>">FAQ</a></li>
		<li><a href="<?php echo SITE_URL.DS.'contact'.DS; ?>">Contact</a></li>
		<li><a href="<?php echo SITE_URL.DS.'terms-and-conditions'.DS; ?>">Terms &amp; Conditions</a></li>
		<?php if(isset($_SESSION['user_id'])) { ?><li><form id="logout" action="<?php echo SITE_URL.DS.'logout'.DS; ?>" method="post"><input type="submit" name="logout" value="Logout" /></form></li><?php } ?>
	</ul>

</div>

</div>

</body>
</html>