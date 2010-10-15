<?php require_once INCLUDES.DS.'public_header.inc.php'; ?>

<div id="content">
<h2>leave<br />
<span>FEEDBACK</span></h2>

<?php echo output_message($session->message); ?>

<p>Hi there! The only way to improve this service is to get your feedback. I've decided to give UserVoice a go since I have received so many different requests. UserVoice will allow you to see the feedback others have left, as well as vote up any feature requests. Don't worry; if you've already sent me feedback, I still have them and are working through them all. Either <a href="#" onclick="UserVoice.Popin.show(uservoiceOptions); return false;">click here to give feedback</a> or click on the red button on the left side of your screen. Thanks so much!</p>

<!--	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="feedback" class="large-inputs">

		<fieldset>
		
			<label for="name">Name</label>
			<input type="text" name="name" id="name" value="<?php if(!empty($user->first_name)) { echo $user->full_name(); } else { echo $user->username; } ?>" />
			
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="<?php if(!empty($user->email)) { echo $user->email; } ?>" />
			
			<label for="subject">Subject</label>
			<input type="text" name="subject" id="subject" value="Feedback for . . ." />
			
			<label for="body">Body</label>
			<textarea name="body" id="body"></textarea>
						
			<input type="submit" name="sendFeedback" id="submit" class="submit" value="Send &raquo;" />
		
		</fieldset>

	</form> -->
				
</div>

<div id="secondary">

	<?php include INCLUDES.DS.'sidebar.inc.php'; ?>	

</div>

<?php require_once INCLUDES.DS.'footer.inc.php'; ?>