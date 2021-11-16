<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}



?>

<?php include("../layouts/admin_header.php"); ?>
<?php include("../layouts/nav.php"); ?>
	<h1>Menu</h1>
	<?php echo output_message($message) ?> 
<?php include("../layouts/admin_footer.php"); ?>