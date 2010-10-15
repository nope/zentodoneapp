<?php require_once INCLUDES.DS.'public_header.inc.php'; ?>

<div id="content">
<h2>Welcome to<br />
<span>Zen To Done App</span></h2>

<h3>Sign Up</h3>

<?php echo output_message($session->message); ?>
<p class="success" style="display:none">You have successfully registered.</p>
<p class="error" style="display:none"> Please Enter Valid Data</p>
	<form action="" method="post" name="form" class="large-inputs">

		<fieldset>
		
			<label for="username">Username <small class="instruction-username">You will not be able to change this once chosen.</small><small class="error-username" style="display:none">You must enter a valid username</small></label>
			<input type="text" name="username" id="username" value="<?php if(isset($_SESSION['signUp']['username'])) { echo $_SESSION['signUp']['username']; } ?>" />
			
			<label for="password">Password <small class="instruction-password">Must be between 8 &#045; 32 characters.</small><small class="error-password" style="display:none">Please create a password</small></label>
			<input type="password" name="password" id="password" />
			
			<label for="confirm">Confirm Password <small class="instruction-confirm">Please retype your password.</small><small class="error-confirm" style="display:none">Your passwords do not match</small></label>
			<input type="password" name="confirm" id="confirm" />
			<!--
			<label for="first_name">First Name <small>Your first name, so we may greet you when you log in.</small></label>
			<input type="text" name="first_name" id="first_name" />
			
			<label for="last_name">Last Name <small>Your last name, so we may be more professional.</small></label>
			<input type="text" name="last_name" id="last_name" />
			-->
			<label for="invite_code">Beta Invite Code <small class="instruction-beta">Please enter the beta invite code you received in your email.</small><small class="error-beta" style="display:none">The Beta Invite Code is incorrect.</small></label>
			<input type="text" name="invite_code" id="invite_code" value="<?php if(isset($_SESSION['signUp']['invite_code'])) { echo $_SESSION['signUp']['invite_code']; } ?>" />
			
			<label for="email">Email <small class="instruction-email">This must match the email the beta invite code was sent to.</small><small class="error-email" style="display:none">You must enter a valid email</small></label>
			<input type="text" name="email" id="email" value="<?php if(isset($_SESSION['signUp']['email'])) { echo $_SESSION['signUp']['email']; } ?>" />
			
			<input type="checkbox" name="newsletter" value="1" id="newsletter" <?php if(isset($_SESSION['signUp']['newsletter'])) { echo 'checked="checked"'; } ?> /> <label for="newsletter" class="checkbox-label">Subscribe to Zen To Done App Newsletter?</label>
			
			<input type="submit" name="betaSignUp" id="submit" class="submit" value="Create account" />
		
		</fieldset>

	</form>
				
</div>

<div id="secondary">

	<?php include INCLUDES.DS.'sidebar.inc.php'; ?>	

</div>
		
<?php require_once INCLUDES.DS.'footer.inc.php'; ?>