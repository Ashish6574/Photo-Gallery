<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php

  $logfile = "../../logs/log.txt";
  
  if(isset($_GET['clear'])) {
		file_put_contents($logfile, '');
    
	  log_action('Logs Cleared', "by User ID {$session->user_id}");
    
    redirect_to('logfile.php');
  }
?>

<?php include("../layouts/admin_header.php"); ?>
<?php include("../layouts/nav.php"); ?>

<h1 style="margin-bottom: 40px;">Log File</h1>

<p><a style="text-decoration: none; font-size: 15px; border: 3px solid black; padding: 5px; margin: 10px 10px;" href="logfile.php?clear=true">Clear log file</a><p>

<?php

  if( file_exists($logfile) && is_readable($logfile) && 
			$handle = fopen($logfile, 'r')) {  // read
    echo "<ul class=\"log-entries\" style=\"margin-top: 10px; background: none;\">";
		while(!feof($handle)) {
			$entry = fgets($handle);
			if(trim($entry) != "") {
				echo "<li>{$entry}</li><br>";
			}
		}
		echo "</ul>";
    fclose($handle);
  } else {
    echo "Could not read from {$logfile}.";
  }

?>

<?php include("../layouts/admin_footer.php"); ?>
