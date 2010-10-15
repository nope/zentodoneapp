<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content" class="wide">
<?php echo output_message($session->message); ?>
<h2>administration<br />
<span>OPTIONS</span></h2>

<h3>User Info</h3>
<p style="text-align: right;"><?php echo User::user_stats(); ?></p>
<?php $usersInfo = User::find_by_sql('SELECT * FROM users WHERE register_date!="0000-00-00" ORDER BY last_login DESC');
	echo '<table>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Username</th>
		<th>Email</th>
		<th>Last Login</th>
		<th>Newsletter</th>
	</tr>';
	foreach($usersInfo as $info) : ?>
	<tr>
		<td><?php echo $info->id; ?></td>
		<td><?php echo $info->full_name(); ?></td>
		<td><?php echo $info->username; ?></td>
		<td><?php echo $info->email; ?></td>
		<td><?php if($info->register_date=='0000-00-00') { echo 'Never'; } else { echo $info->last_login; } ?></td>
		<td><?php if($info->newsletter==1) { echo 'Yes'; } else { echo 'No'; } ?></td>
	</tr>
	<?php endforeach; ?>
	</table>

<h3>Add emails to database</h3>
<p>This is for initial import and will add emails into the database, at the same time generating a beta invite code.</p>
	<form id="invite" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<textarea name="database_emails" id="database_emails"></textarea>
		<input type="hidden" name="submitting_page" value="<?php echo $page; ?>" />
		<input type="submit" id="submit" class="submit" name="addEmailsToDatabase" value="Add Emails" />
	</form>
<div class="clearer"></div>	
<h3>Send Out Beta Invites</h3>
	<form id="sendBetaInvites" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div id="emailDbBox">
			<?php $emailsFromDb = User::find_by_sql('SELECT id,email FROM users WHERE register_date = "0000-00-00"');
			foreach($emailsFromDb as $email) : ?>
			<input type="checkbox" name="user_id[]" value="<?php echo $email->id; ?>" checked="checked" /><?php echo $email->email; ?><br />
			<?php endforeach; ?>
		</div>
		<h4>Email Body</h4>
		<textarea name="emailBody"></textarea>
		<p>The following text is displayed at the top of the email:<br />
		<code>Your Beta Invite Code is: XXXXXXXXXXXXXXXX<br />
		You may sign up for your account here: <?php echo SITE_URL.DS.'sign-up'.DS; ?></code></p>
		<input type="hidden" name="submitting_page" value="<?php echo $page; ?>" />
		<input type="submit" id="submit" class="submit" name="sendBetaInvitesOut" value="Send Beta Invites" />
	</form>		
</div>




<?php require_once INCLUDES.DS.'footer.inc.php'; ?>