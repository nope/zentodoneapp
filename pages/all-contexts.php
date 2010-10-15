<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content">
<?php echo output_message($session->message); ?>
<h2>contexts<br />
<span>@all</h2>

	<ul id="all-contexts">
		<?php foreach($contexts as $context) : ?>
		<li<?php $weight = Context::get_weight($context->name); echo ' style="font-size: '.$weight.'em;"'; ?>><a href="<?php echo SITE_URL.DS.'home'.DS.'contexts'.DS.$context->name; ?>"><?php echo $context->name; ?></a></li>
		<?php endforeach; ?>		
	</ul>
					
</div>

<div id="secondary">

	<h4>Big Rocks<br /><span><?php echo getWeekRange($start, $end); ?></span></h4>
	
	<ul>
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
		
	<h4 class="inbox-header">Inbox <span><a href="<?php echo SITE_URL.DS.'inbox'.DS; ?>">&#9776;</a></span></h4>
	<ul class="inbox-list">
		<?php foreach($inbox_items as $inbox_item) : ?>
		<li><span>&raquo;</span> <?php echo stripslashes($inbox_item->item); ?></li>
		<?php endforeach; ?>
	</ul>

</div>


<?php require_once INCLUDES.DS.'footer.inc.php'; ?>