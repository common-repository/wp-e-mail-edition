<?define('WP_USE_THEMES', false);require('../../../wp-blog-header.php');query_posts('showposts=10');$title = "Preview your e-mail";include('./header.php');?><?if (isset($_POST['mailer_preview'])) {	if (isset($_POST['body'])) {		echo stripslashes($_POST['body']); 	} else {		include('themes/'.$_POST['cat'].'/html.php');	}	?>	<div style="clear:both; border-top: 1px dotted #00AEEF;"></div><br>		<div class="postbox">			<form id="mailer_form" method="post" action="">				<input type="hidden" name="cat" value="<?=$_POST['cat']; ?>">				<div><label for="subject">Subject:</label><br />					<? if ($_POST['subject'] == "") {						echo "<h1 style='color:#ff0000;'>Don't forget your subject!</h1>";					} ?>				<input type="text" id="subject" size="80" name="subject" value="<?=$_POST['subject']; ?>" /></div>				<div><label for="body">Body:</label><br />				<textarea rows="15" cols="75" name="body" id="body">					<? if (isset($_POST['body'])) {						echo stripslashes($_POST['body']); 					} else {						include('themes/'.$_POST['cat'].'/html.php');					} ?>				</textarea>				</div>				<div class="submit">					<input type="submit" name="mailer_preview" id="mailer_preview" value="Preview e-mail" /> &nbsp;&nbsp;&nbsp;<input type="submit" name="mailer_submit" id="mailer_submit" value="Send e-mail" onclick="mailer_form.action='mail.php'; return true;" />				</div>			</form>		</div><? }include ('./footer.php');?>