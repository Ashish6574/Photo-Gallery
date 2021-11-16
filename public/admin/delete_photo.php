<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) {
	redirect_to("login.php");
} ?>

<?php

if(empty($_GET['id'])) {
    $session->message("No Photograph ID was Provided.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if($photo && $photo->destroy()) {
    $session->message("The Photo {$photo->file_name} was deleted.");
    redirect_to('list_photos.php');
} else {
    $session->message("The {$photo->file_name} could not be deleted.");
    redirect_to('list_photos.php');
}

?>

<?php if(isset($database)) { $database->close_connection(); } ?>