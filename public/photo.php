<?php require_once("../includes/initialize.php"); ?>
<?php
  if(empty($_GET['id'])) {
    $session->message("No photograph ID was provided.");
    redirect_to('index.php');
  }
  
  $photo = Photograph::find_by_id($_GET['id']);
  if(!$photo) {
    $session->message("The photo could not be located.");
    redirect_to('index.php');
  }

	if(isset($_POST['submit'])) {
	  $author = trim($_POST['author']);
	  $body = trim($_POST['body']);
	
	  $new_comment = Comment::make($photo->id, $author, $body);
	  if($new_comment && $new_comment->save()) {
      $new_comment->try_to_send_notification();
	    $message = "Comment Saved and Sent it your Email..";
	    redirect_to("photo.php?id={$photo->id}");
		} else {
			// Failed
	    $message = "There was an error that prevented the comment from being saved.";
		}
	} else {
		$author = "";
		$body = "";
	}
	
  $comment = Comment::find_commesnt_on($photo->id);
	// $comments = $photo->comments();
	
?>
<?php include_layout_template('header.php'); ?>

<h1><a style="color: black;" href="index.php">&laquo; Back</a></h1><br />
<br />

<div>
  <img src="<?php echo $photo->image_path(); ?>" width="100%" height="100%" style="border-radius: 20px;"/>
  <h1 style="text-align: center; margin: 30px 30px;"><?php echo $photo->caption; ?></h1>
</div>

<hr style="border-top: 5px dashed black;">

<div id="comment-form" >
  <h1 style="text-align: center;">New Comment</h1>
  <?php echo output_message($message); ?>
  <form action="photo.php?id=<?php echo $photo->id; ?>" method="post">
    <table style="margin: auto; width: 70%;">
      <tr>
        <td style="width: 15%;">Your name:</td>
        <td><input type="text" name="author" value="<?php echo $author; ?>" /></td>
      </tr>
      <tr>
        <td>Your comment:</td>
        <td><textarea name="body" cols="40" rows="8"><?php echo $body; ?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Submit Comment" /></td>
      </tr>
    </table>
  </form>
</div>

<div id="comments">
  <?php foreach($comment as $comments): ?>
    <div class="comment" style="margin-bottom: 2em; text-align: center; width: 70%; margin: auto; margin-bottom: 30px;">
	    <div class="author" style="background-color:#000000c2; color: white; padding: 2px; margin: 10px; margin-bottom: 0;">
	      <?php echo "<h3>@".htmlentities($comments->author)."</h3>"; ?>
	    </div>
      <div class="body"  style="border: 3px solid #000000c2; border-top: none; margin-top: 0px; margin: 10px; padding: 10px;">
				<?php echo strip_tags($comments->body, '<strong><em><p>'); ?>
        <?php echo "<p style=\"text-align: center;\">". datetime_to_text($comments->created)."</p>"; ?>
			</div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comment)) { echo "<h1 style=\"text-align: center;\">No Comments.</h1>"; } ?>
</div>

<?php include_layout_template('footer.php'); ?>
