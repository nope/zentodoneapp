<div id="footer">

	<p id="copyright">Copyright &copy; <?php echo date('Y'); ?>. <a href="<?php echo SITE_URL; ?>">ZenToDoneApp.com</a><br /><a href="http://geekdesigngirl.com/">The GdG Project</a></p>
	
	<ul>
		<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']==1) { ?><li><strong><a href="<?php echo SITE_URL.DS.'admin-options'.DS; ?>">Admin</a></strong></li><?php } ?>
		<?php if(isset($_SESSION['user_id'])) { ?><li><strong><a href="<?php echo SITE_URL.DS.'feedback'.DS; ?>">Feedback</a></strong></li><?php } ?>
		<li><a href="<?php echo SITE_URL.DS.'about'.DS; ?>">About</a></li>
		<li><a href="<?php echo SITE_URL.DS.'faq'.DS; ?>">FAQ</a></li>
		<li><a href="<?php echo SITE_URL.DS.'terms-and-conditions'.DS; ?>">Terms &amp; Conditions</a></li>
		<li><a href="<?php echo SITE_URL.DS.'contact'.DS; ?>">Contact</a></li>
		<?php if(isset($_SESSION['user_id'])) { ?><li><form id="logout" action="<?php echo SITE_URL.DS.'logout'.DS; ?>" method="post"><input type="submit" name="logout" value="Logout" /></form></li><?php } ?>
	</ul>

</div>

<p id="github"><a href="http://github.com/geekdesigngirl/zentodoneapp">This source code for this site is publicly available on GitHub</a></p>

</div>

<div id="boxes">

	
	<!-- #customize your modal window here -->

	<div id="dialog" class="window">
		
		<!-- close button is defined as close class -->
		<a href="#" class="close" accesskey="x">X</a>
		<h4>Inbox</h4>
		<form action="" method="post">
			<input type="text" class="inbox-input" name="inbox" value="" />
			<input type="hidden" name="submitting_page" value="<?php if(!empty($page2)) { echo $page.DS.$page2; } else { echo $page; } ?>" />
			<input type="submit" class="submit" name="addInbox" value="Add" />
		</form>
		<p><strong>KEY</strong> (ex. <em>design new website 9/22/10 bigrock @computer @work *mockups need to be eco-green themed for this client*</em>)<br />
		<strong>bigrock</strong>: makes item a big rock<br />
		<strong>9/22/2010 OR 9/22/10 OR 9/22</strong>: puts the item on the calendar (no year given inserts current year)<br />
		<strong>*lorem ipsum*</strong>: words between asterisks become the description (ex. <em>*mockups need to be eco-green themed for this client*</em>)<br />
		<strong>@</strong>: add a context (ex. <em>@computer @work</em>)</p>
	</div>
		
	<!-- Do not remove div#mask, because you'll need it to fill the whole screen -->	
 	<div id="mask"></div>
</div>

<?php if($page=='account' || $page =='feedback') { ?>
<script type="text/javascript">
  var uservoiceOptions = {
    key: 'zentodoneapp',
    host: 'zentodoneapp.uservoice.com', 
    forum: '80217',
    lang: 'en',
    showTab: false
  };
  function _loadUserVoice() {
    var s = document.createElement('script');
    s.src = ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js";
    document.getElementsByTagName('head')[0].appendChild(s);
  }
  _loadSuper = window.onload;
  window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
</script>

<script type="text/javascript">
var uservoiceOptions = {
  /* required */
  key: 'zentodoneapp',
  host: 'zentodoneapp.uservoice.com', 
  forum: '80217',
  showTab: true,  
  /* optional */
  alignment: 'left',
  background_color:'#f00', 
  text_color: 'white',
  hover_color: '#06C',
  lang: 'en'
};

function _loadUserVoice() {
  var s = document.createElement('script');
  s.setAttribute('type', 'text/javascript');
  s.setAttribute('src', ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js");
  document.getElementsByTagName('head')[0].appendChild(s);
}
_loadSuper = window.onload;
window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
</script>
<?php } ?>
<div id="absolute-add">
	<a href="#dialog" name="modal">Add</a>
</div>

</body>
</html>
