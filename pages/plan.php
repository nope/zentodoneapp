<?php 
if(!isset($_SESSION['user_id'])) {
	redirect_to(SITE_URL.DS.'login'.DS);
}
require_once INCLUDES.DS.'header.inc.php'; 
?>

<div id="content">
<h2>weekly<br />
<span>PLAN</span></h2>
<?php echo output_message($session->message); ?>
	<ul id="items" class="weekly-plan">
		<?php $i = 1; foreach($mits as $mit) : ?>
		
		<li class="<?php if($mit->completed==1) { echo 'dull'; } elseif($i==1 && $mit->completed==1) { echo 'dull first'; } elseif($i==1 && $mit->completed==0) { echo 'first'; } ?>">
		<div class="plan-item">
		<?php if($mit->big_rock==1) { ?><div class="rocks"></div><?php } ?><span class="actions"><a href="<?php echo SITE_URL.DS.'?'; if($mit->completed==1) { echo 'archive'; } else { echo 'complete'; } echo'='.$mit->id; ?>" title="<?php if($mit->completed==1) { echo 'archive'; } else { echo 'complete'; } ?>" class="archive">&#10003;</a> <a href="<?php echo SITE_URL.DS.'?delete='.$mit->id; ?>" title="delete" class="delete">&#10007;</a></span>
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
			</div>
			
			<span class="item-plan">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			Date: <input type="text" id="datepicker<?php echo $i; ?>" name="date_scheduled" size="8" value="<?php if($mit->date_scheduled!="0000-00-00") { echo $mit->date_scheduled; } ?>" /> 
			<input type="checkbox" value="1" name="bigrock"<?php if($mit->big_rock==1) { echo ' checked="checked"'; } ?> /> Big Rock<br /><?php if($mit->date_scheduled<date('Y-m-d') && $mit->date_scheduled!='0000-00-00' && $mit->completed==0) { echo '<span class="item-overdue">overdue</span> '; } ?>
			<input type="hidden" name="submitting_page" value="<?php echo $page; ?>" />
			<input type="hidden" name="task_id" value="<?php echo $mit->id; ?>" />
			<input type="submit" value="Save" name="submitPlan" class="submit-plan" />
			</form>
			</span>
			
		</li>
			
		<?php $i++; endforeach; ?>		
	</ul>
					
</div>

<div id="secondary">

	<!-- Advertisement block if free account -->
	<?php if($user->paid==0) { require_once INCLUDES.DS.'adverts.inc.php'; } ?>
	
	<?php 
	$time = time(); 
	$today = date('j',$time);
	$days = array($today=>array(NULL,NULL,'<span class="today" title="Today">'.$today.'</span>')); 
	echo generate_calendar(date('Y', $time), date('n', $time), $days, 3, NULL, $week_start); 
	
	$time = strtotime("+1 month");
	echo generate_calendar(date('Y', $time), date('n', $time), NULL, 3, NULL, $week_start);
	
	$time = strtotime("+2 month");
	echo generate_calendar(date('Y', $time), date('n', $time), NULL, 3, NULL, $week_start);
	
	?>

</div>

<?php require_once INCLUDES.DS.'footer.inc.php'; ?>