<?include('../../../wp-config.php');include('../../../wp-admin/includes/admin.php');$title = "Manage your account";include('./header.php');?><?// Verify e-mail addressif ($_GET['action'] == "verify") {	$verify = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "wpmailer_users WHERE id=".$_GET['id']);	if ($_GET['pass'] == $verify->pass) {		$wpdb->query("UPDATE ".$wpdb->prefix . "wpmailer_users SET verified = 1 WHERE ID = ".$_GET['id']);		echo "<h2 style=\"color: #ff6633;\">Thanks!</h2>Your e-mail address has been verified. You will start receiving e-mails immediately.";	} else {		echo "<h2 style=\"color: #ff6633;\">Uh-oh</h2>Looks like your password and ID didn't match. Please check your URL.";	}}// Unsubscribeif ($_GET['action'] == "unsubscribe") {	$unsubscribe = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "wpmailer_users WHERE id=".$_GET['id']);	if ($_GET['pass'] == $unsubscribe->pass) {		$wpdb->query("DELETE FROM ".$wpdb->prefix . "wpmailer_users WHERE id=".$_GET['id']);		echo "<h2 style=\"color: #ff6633;\">Done!</h2>You have been unsubscribed from the mailing list, and your information has been deleted from our database.";	}}// Manage actionif (isset($_POST['manage_submit'])) {    $categories = $_POST['cats'];	$cats = "";	foreach ($categories as $cat) {		$cats .= $cat.", ";	}	$wpdb->query("UPDATE ".$wpdb->prefix . "wpmailer_users SET cats = '".$cats."' WHERE ID = ".$_GET['id'])  or die(mysql_error());	echo "<h2 style=\"color: #ff6633;\">Fin&eacute;!</h2>Your subscriptions have been updated, as reflected below.";}// Manage subscriptionsif ($_GET['action'] == "manage") {	$manage = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . "wpmailer_users WHERE id=".$_GET['id']) or die(mysql_error());	if ($_GET['pass'] == $manage->pass) {		echo "<h2 style=\"color: #ff6633;\">Manage your subscription</h2>Hello $manage->first_name,<br />		You can manage your subscriptions below:<br />"; ?>		<form name="manage" action="" method="post">			<?	$categories = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix . 'wpmailer_structure ORDER BY ID') or die(mysql_error());		foreach ($categories as $category) {			$pos = strpos($manage->cats,$category->title_slug);			if($pos === false) { $checked = ""; }				else { $checked = "CHECKED";			}	?>		<input type="checkbox" name="cats[]" value="<? echo $category->title_slug; ?>" <?=$checked ?> /> <? echo "<b>".$category->title.": </b>".$category->description; ?><br />		<?	}	?>		<input type="submit" name="manage_submit" id="manage_submit" value="Submit" />		</form>	<?	}}// View an e-mail.if ($_GET['action'] == "viewmail") {    $id = $_GET['id'];	$body = $wpdb->get_var("SELECT body FROM ".$wpdb->prefix . "wpmailer_mails WHERE id='".$id."'");	echo $body;}include('./footer.php');?>