<?php require_once INCLUDES.DS.'public_header.inc.php'; ?>

<div id="content">
<h2>reset<br />
<span>PASSWORD</span></h2>

<?php echo output_message($session->message); ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login" class="large-inputs">

		<fieldset>
		
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="" />
			
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
			
			<label for="confirm">Password</label>
			<input type="password" name="confirm" id="confirm" />
			
			<input type="hidden" name="url" value="<?php echo $page2; ?>" />
						
			<input type="submit" name="new_password" id="submit" class="submit" value="Reset Password" />
		
		</fieldset>

	</form>
				
</div>

<div id="secondary">

	<?php include INCLUDES.DS.'sidebar.inc.php'; ?>	

</div>
		
<?php require_once INCLUDES.DS.'footer.inc.php'; ?>