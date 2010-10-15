<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content">
<?php echo output_message($session->message); ?>
<h2>archived<br />
<span>TASKS</h2>

	<ul id="items">
		<?php $i = 1; foreach($mits as $mit) : ?>
		<li class="gray <?php if($i==1) { echo 'first'; } ?>"><?php if($mit->big_rock==1) { ?><div class="rocks"></div><?php } ?>
			<span class="completed">DATE COMPLETED: <?php $date_completed = explode('-',$mit->date_completed); list($y,$m,$d) = $date_completed; if(USER_DATE_FORMAT=='mm/dd/yy') { echo $m.'/'.$d.'/'.$y; } else { echo $d.'/'.$m.'/'.$y; } ?></span>
			<span class="title"><?php echo stripslashes($mit->item); ?></span>
			<div class="description-show"><?php echo stripslashes($mit->notes); ?></div>
			<!--<span class="contexts">
				<?php $contexts = Context::get_contexts($mit->id); 
				if(!empty($contexts)) {
					foreach($contexts as $context) :
						echo '@'.$context->name. ' ';
					endforeach;
				}
				?>&nbsp;		
			</span>-->
		</li>
		<?php $i++; endforeach; ?>		
	</ul>
					
</div>

<div id="secondary">

	<h4>Big Rocks<br /><span><?php echo getWeekRange($start, $end); ?></span></h4>
	
	<ul>
	<?php 
	if(!empty($big_rocks)) {
		foreach($big_rocks as $big_rock) : ?>
		<li><span>&raquo;</span> <?php echo $big_rock->item; ?></li>
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