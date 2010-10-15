<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content">
<h2><?php echo TODAY; ?><br />
<span>M.I.T.</span> <span id="small-header">Today's Most Important Tasks</span></h2>

<?php if(isset($timezone_message)) { echo output_message($timezone_message); }
echo output_message($session->message); ?>
<?php if(!empty($mits)) { ?>
	<ul id="items">
		<?php $i = 1; foreach($mits as $mit) : ?>
		<li class="<?php if($mit->completed==1) { echo 'dull'; } elseif($i==1 && $mit->completed==1) { echo 'dull first'; } elseif($i==1 && $mit->completed==0) { echo 'first'; } ?>"><?php if($mit->big_rock==1) { ?><div class="rocks"></div><?php } ?><span class="actions"><a href="<?php echo SITE_URL.DS.'?'; if($mit->completed==1) { echo 'archive'; } else { echo 'complete'; } echo'='.$mit->id; ?>" title="<?php if($mit->completed==1) { echo 'archive'; } else { echo 'complete'; } ?>" class="archive">&#10003;</a> <a href="<?php echo SITE_URL.DS.'?delete='.$mit->id; ?>" title="delete" class="delete">&#10007;</a></span>
		<?php if($mit->date_scheduled<date('Y-m-d') && $mit->completed==0) { echo '<span class="overdue">overdue</span> '; } ?>
			<span class="<?php if($mit->completed!=1) { echo 'titleEdit'.$i.' '; } ?>title" id="<?php echo $mit->id; ?>"><?php echo stripslashes($mit->item); ?></span>
			<a href="#" class="show-hide" title="Show description">&darr;</a>
			<div class="<?php if($mit->completed!=1) { echo 'descEdit'.$i.' '; } ?> description" id="<?php echo $mit->id; ?>"><?php echo stripslashes($mit->notes); ?></div>
			<span class="contexts">
				<?php $contexts = Context::get_contexts($mit->id); 
				if(!empty($contexts)) {
					foreach($contexts as $context) :
						echo '<a href="'.SITE_URL.DS.'home'.DS.'contexts'.DS.$context->name.'">@'.$context->name.'</a> ';
					endforeach;
				}
				?>&nbsp;		
			</span>
			<div class="contextEdit<?php echo $i; ?> context-input-div" id="<?php echo $mit->id; ?>">@</div>
		</li>
		<?php $i++; endforeach; ?>		
	</ul>
<?php } else { ?>
	<?php if($user->last_login=='0000-00-00') { ?><p><h4>First time here?</h4><p>To get started, click the <a href="#dialog" name="modal">Add</a> link at top there.</p><?php } ?>
	<p>There are no MITs scheduled for today. MITs show up on the date you schedule them, whether or not it is a Big Rock. Why don't you add a MIT now?</p>
	<form action="" method="post" id="dashboard-input">
		<input type="text" class="inbox-input" name="inbox" value="" />
		<input type="hidden" name="submitting_page" value="<?php echo $page; ?>" />
		<input type="submit" class="submit" name="addInboxDashboard" value="ADD" />
		<a href="#dialog" id="key" name="modal">KEY</a>
	</form>
	
<?php } ?>	
</div>

<div id="secondary">

	<h4>Big Rocks<br /><span><?php echo $week_range; ?></span></h4>
	
	<ul id="big_rocks">
	<?php 
	if(!empty($big_rocks)) {
		foreach($big_rocks as $big_rock) : ?>
		<li><span>&raquo;</span> <?php echo stripslashes($big_rock->item); ?></li>
		<?php endforeach; 
	} else { ?>
		<li>None scheduled</li>
	<?php } ?>
	</ul>
	
	<!-- Advertisement block if free account -->
	<?php if($user->paid==0) { require_once INCLUDES.DS.'adverts.inc.php'; } ?>
	
	<h4 class="inbox-header">Contexts <span><a href="<?php echo SITE_URL.DS.'home'.DS.'contexts'.DS; ?>">&#9776;</a></span></h4>
	<ul class="inbox-list">
		<?php foreach($labels as $context) : ?>
		<li><a href="<?php echo SITE_URL.DS.'home'.DS.'contexts'.DS.$context->name; ?>"><span>@</span> <?php echo stripslashes($context->name); ?></a></li>
		<?php endforeach; ?>
	</ul>
	
	<h4 class="inbox-header">Inbox <span><a href="<?php echo SITE_URL.DS.'inbox'.DS; ?>">&#9776;</a></span></h4>
	<ul class="inbox-list">
		<?php foreach($inbox_items as $inbox_item) : ?>
		<li><span>&raquo;</span> <?php echo stripslashes($inbox_item->item); ?></li>
		<?php endforeach; ?>
	</ul>

</div>


<?php require_once INCLUDES.DS.'footer.inc.php'; ?>