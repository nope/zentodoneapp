<?php require_once INCLUDES.DS.'public_header.inc.php'; ?>

<div id="content">
<h2>Welcome to<br />
<span>Zen To Done App</span></h2>

<h3>Log In</h3>

<?php echo output_message($session->message); ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login" class="large-inputs">

		<fieldset>
		
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="" />
			
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
			
			
						
			<input type="submit" name="login" id="submit" class="submit" value="Log in" />
		
		</fieldset>

	</form>
				
</div>

<div id="secondary">

	<?php include INCLUDES.DS.'sidebar.inc.php'; ?>	

</div>
		
<?php require_once INCLUDES.DS.'footer.inc.php'; ?>