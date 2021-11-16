<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
    redirect_to("login.php");
} ?>
<?php
if (empty($_GET['id'])) {
    $session->message("No photograph ID was provided.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if (!$photo) {
    $session->message("The photo could not be located.");
    redirect_to('index.php');
}

$comments = Comment::find_commesnt_on($photo->id);

?>
<?php include("../layouts/admin_header.php"); ?>

<h1><a href="list_photos.php">&laquo; Back</a><br /></h1>
<br />

<hr style="border-top: 5px dashed black;">
<h1 style="text-align: center;">Comments on <?php echo $photo->file_name; ?></h1>
<hr style="border-top: 5px dashed black;"><br>
<?php echo output_message($message); ?>
<div id="comments" style="margin-top: 30px;">
    <?php foreach ($comments as $comment) : ?>
        <div class="comment" style="margin-bottom: 2em; text-align: center; width: 70%; margin: auto; margin-bottom: 30px;">
            <div class="author" style="background-color:#000000c2; color: white; padding: 2px; margin: 10px; margin-bottom: 0;">
                <?php echo "<h3>@" . htmlentities($comment->author) . "</h3>"; ?>
            </div>
            <div class="body" style="border: 3px solid #000000c2; border-top: none; margin-top: 0px; margin: 10px; padding: 10px;">
                <?php echo strip_tags($comment->body, '<strong><em><p>'); ?>
                <?php echo "<p style=\"text-align: center;\">" . datetime_to_text($comment->created) . "</p>"; ?>
                <hr style="border-top: 3px dashed black;">
                <h3><a style="color: red;" href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete Comment</a></h3> 
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($comment)) {
        echo "<h1 style=\"text-align: center;\">No Comments.</h1>";
    } ?>
</div>


<?php include("../layouts/admin_footer.php"); ?>