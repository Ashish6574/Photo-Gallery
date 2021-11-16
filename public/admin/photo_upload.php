<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
?>

<?php

$max_file_size = 10485760;

if (isset($_POST['submit'])) {
    $photo = new Photograph();
    $photo->caption = $_POST['caption'];
    $photo->attach_file($_FILES['file_upload']);
    if ($photo->save()) {
        $session->message("{$photo->file_name} uploaded successfully...");
        redirect_to("list_photos.php");
    } else {
        $message = join("<br>", $photo->errors);
    }
}
?>

<?php include("../layouts/admin_header.php"); ?>
<?php include("../layouts/nav.php"); ?>
<h1>Photo Upload</h1><br>
<?php echo output_message($message) ?>
<form action="photo_upload.php" enctype="multipart/form-data" method="POST">
    <input style="font-size: 25px;" type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
    <h1><input type="file" name="file_upload" style="width: 100%;" /></h1>
    <h1 style="font-size: 20px;">Caption :- <input style=" padding: 10px;" required type="text" name="caption" value=""></h1>
    <input style="font-size: 25px;" type="submit" name="submit" value="Upload" />
</form>
<?php include("../layouts/admin_footer.php"); ?>