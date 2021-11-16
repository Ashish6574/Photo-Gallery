<?php require_once("../../includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {
  redirect_to("login.php");
} ?>
<?php
// Find all the photos
$photos = Photograph::find_only_user();
?>
<?php include("../layouts/admin_header.php"); ?>
<?php include("../layouts/nav.php"); ?>
<h1 style="text-align: center;">Images<br><br><?php echo output_message($message) ?></h1> 
<div class="content">
  <div class="row">
    <?php foreach ($photos as $photo) : ?>
      <div class="column">
          <img class="image" src="../<?php echo $photo->image_path(); ?>" style="border-radius: 10px;">
          <p class="img">Name :- <?php echo $photo->file_name; ?></p>
          <p class="img">Size :- <?php echo $photo->size_as_text(); ?></p>
          <p class="img">Type :- <?php echo $photo->file_type; ?></p>
          <p class="img">Caption :- <?php echo $photo->caption; ?></p>
          <p class="img">Comment :- <a href="comments.php?id=<?php echo $photo->id ?>"><?php echo count(comment::find_commesnt_on($photo->id)); ?></a></p>
          <button class="btn img"><a style="text-decoration: none; color: black;" href="delete_photo.php?id=<?php echo $photo->id; ?>">Detele Photo</a></button>
        </div>
    <?php endforeach; ?>
  </div>
</div>
<?php include("../layouts/admin_footer.php"); ?>