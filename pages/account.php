<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content">
<h2>zen to done app<br />
<span>ACCOUNT</span></h2>

<h3>Namaste <?php if($user->first_name!='') { echo $user->first_name; } else { echo $user->username; } ?></h3>

<?php echo output_message($session->message); ?>

<?php 
if($user->paid==0) {
	echo '<p>You currently have a free account with Zen To Done App. We are currently looking for feedback on how to generate revenue from this site since it costs money to run the server, update services, etc. Please feel free to send feedback (click the link in the footer) on what you think would work for both you, the user, and generating revenue.</p>';	
}
?>

<form id="account" class="large-inputs" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<fieldset>
		<label for="username">Username <small>can't change</small></label>
		<input type="text" name="username" id="username" disabled="disabled" value="<?php if(isset($user->username)) { echo stripslashes($user->username); } ?>" />
		<label for="first_name">First Name</label>
		<input type="text" name="first_name" id="first_name" value="<?php if(!empty($_SESSION['user_input']['first_name'])) { echo $_SESSION['user_input']['first_name']; } elseif(isset($user->first_name)) { echo stripslashes($user->first_name); } ?>" />
		<label for="last_name">Last Name</label>
		<input type="text" name="last_name" id="last_name" value="<?php if(!empty($_SESSION['user_input']['last_name'])) { echo $_SESSION['user_input']['last_name']; } elseif(isset($user->last_name)) { echo stripslashes($user->last_name); } ?>" />
		<label for="email">Email Address <small>required</small></label>
		<input type="text" name="email" id="email" value="<?php if(!empty($_SESSION['user_input']['email'])) { echo $_SESSION['user_input']['email']; } elseif(isset($user->email)) { echo stripslashes($user->email); } ?>" />
		<label for="password">Change Password</label>
		<input type="password" name="password" id="password" value="" />
		<label for="confirm">Confirm Password</label>
		<input type="password" name="confirm" id="confirm" value="" />
		<h4>Start of Week</h4>
		<p>I want my week to start on 
		<select name="week_start" class="small">
			<option value="">Please select . . .</option>
			<option value="S"<?php if(!empty($_SESSION['user_input']['week_start']) && $_SESSION['user_input']['week_start']=='S') { echo ' selected="selected"'; } elseif($user->week_start=='S') { echo ' selected="selected"'; } ?>>Sunday</option>
			<option value="M"<?php if(!empty($_SESSION['user_input']['week_start']) && $_SESSION['user_input']['week_start']=='M') { echo ' selected="selected"'; } elseif($user->week_start=='M') { echo ' selected="selected"'; } ?>>Monday</option>
		</select>.</p>
		<h4>Time Zone</h4>
		<p>Currently, time zone settings indicate that it is now <strong><?php echo date('l j \o\f F Y \a\t g:i A'); ?></strong>.<br />
		<select name="timezone">
		<option value="">Please select . . .</option>
		<?php
			$regions = array(
			    'Africa' => DateTimeZone::AFRICA,
			    'America' => DateTimeZone::AMERICA,
			    'Antarctica' => DateTimeZone::ANTARCTICA,
			    'Aisa' => DateTimeZone::ASIA,
			    'Atlantic' => DateTimeZone::ATLANTIC,
			    'Australia' => DateTimeZone::AUSTRALIA,
			    'Europe' => DateTimeZone::EUROPE,
			    'Indian' => DateTimeZone::INDIAN,
			    'Pacific' => DateTimeZone::PACIFIC
			);
			foreach ($regions as $name => $mask) {
			    $tzlist[] = DateTimeZone::listIdentifiers($mask);
			}
			
			foreach($tzlist as $tz) : foreach($tz as $z) : echo '<option value="'.$z.'"';
				if(!empty($_SESSION['user_input']['timezone']) && $_SESSION['user_input']['timezone']==$z) {
					echo ' selected="selected"';
				} elseif($user->timezone==$z) {
					echo ' selected="selected"';
				}
			echo '>'.$z.'</option>'; endforeach; endforeach;

		?>
		</select></p>
		<h4>Date Format</h4>
		<p>
			<input name="date_format" value="mm/dd/yy" type="radio" class="small" <?php if(!empty($_SESSION['user_input']['date_format']) && $_SESSION['user_input']['date_format']=='mm/dd/yy') { echo ' checked="checked"'; } elseif($user->date_format=='mm/dd/yy') { echo ' checked="checked"'; } ?> /> mm/dd/yy  <input name="date_format" value="dd/mm/yy" type="radio" class="small" <?php if(!empty($_SESSION['user_input']['date_format']) && $_SESSION['user_input']['date_format']=='dd/mm/yy') { echo ' checked="checked"'; } elseif($user->date_format=='dd/mm/yy') { echo ' checked="checked"'; } ?> /> dd/mm/yy
		</p>
		<h4>Newsletter</h4>
		<input type="checkbox" name="newsletter" id="newsletter"<?php if($user->newsletter==1) { echo ' checked="checked"'; } ?> value="1" /> <label for="newsletter" class="label-inline">Subscribe to Zen To Done App Newsletter?</label>
		<small id="info">Don't worry; we'll never sell your info to any third party and we will only use your email to send newsletters regarding Zen To Done App.</small>
		<input type="hidden" name="submitting_page" value="<?php echo $page; ?>" />
		<input type="hidden" name="id" value="<?php echo $user->id; ?>" />
		<input type="submit" name="submitAccount" id="submit" value="Update" />
	</fieldset>
</form>
				
</div>

<div id="secondary">

	<h4>Invitations</h4>
	<p>You have <strong style="big"><?php echo $user->invites_left; ?></strong> Zen To Done App invites left. Invite others by entering email addresses below, separated by commas.</p>
	<form id="invite" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<textarea name="invite_emails" id="invite_emails"></textarea>
		<input type="hidden" name="submitting_page" value="<?php echo $page; ?>" />
		<input type="submit" id="submit" class="submit" name="submitEmails" value="Send" />
	</form>
	
	<h4><a href="<?php echo SITE_URL.DS.'archive'.DS; ?>">Archive &raquo;</a></h4>
	<p>Once tasks are completed, you may archive them instead of permanently deleting them. <a href="<?php echo SITE_URL.DS.'archive'.DS; ?>">View you archive &raquo;</a></p>
	
	
	<!-- Advertisement block if free account -->
	<?php if($user->paid==0) { require_once INCLUDES.DS.'adverts.inc.php'; } ?>
	

</div>


<?php require_once INCLUDES.DS.'footer.inc.php'; ?>