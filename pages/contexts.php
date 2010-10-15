<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content">
<?php echo output_message($session->message); ?>
<h2>contexts<br />
<span>@<?php echo stripslashes($page3); ?></h2>

	<ul id="items">
	<?php $mit = new Task(); ?>
		<?php $i = 1; foreach($contexts as $context) : 
		$mit = Task::find_by_id($context->task_id); 
		if($mit->archived!=1) { ?>
		<li class="<?php if($mit->completed==1) { echo 'dull'; } elseif($i==1 && $mit->completed==1) { echo 'dull first'; } elseif($i==1 && $mit->completed==0) { echo 'first'; } ?>"><?php if($mit->big_rock==1) { ?><div class="rocks"></div><?php } ?><span class="actions"><a href="<?php echo SITE_URL.DS.'?'; if($mit->completed==1) { echo 'archive'; } else { echo 'complete'; } echo'='.$mit->id; ?>" title="<?php if($mit->completed==1) { echo 'archive'; } else { echo 'complete'; } ?>" class="archive">&#10003;</a> <a href="<?php echo SITE_URL.DS.'?delete='.$mit->id; ?>" title="delete" class="delete">&#10007;</a></span>
		<?php if($mit->date_scheduled<date('Y-m-d') && $mit->completed==0 && $mit->date_scheduled!='0000-00-00') { echo '<span class="overdue">overdue</span> '; } ?>
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
		<?php } $i++; endforeach; ?>		
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