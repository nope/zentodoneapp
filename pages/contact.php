<?php require_once INCLUDES.DS.'public_header.inc.php'; ?>

<div id="content">
<h2>contact<br />
<span>ZEN TO DONE APP</span></h2>

<?php echo output_message($session->message); ?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login" class="large-inputs">

		<fieldset>
		
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="" />
			
			<label for="email">Email</label>
			<input type="text" name="email" id="email" />
			
			<label for="subject">Subject</label>
			<input type="text" name="subject" id="subject" />
			
			<label for="body">Body</label>
			<textarea name="body" id="body"></textarea>
						
			<input type="submit" name="sendContact" id="submit" class="submit" value="Send &raquo;" />
		
		</fieldset>

	</form>
				
</div>

<div id="secondary">

	<?php include INCLUDES.DS.'sidebar.inc.php'; ?>	

</div>
		
<?php require_once INCLUDES.DS.'footer.inc.php'; ?>