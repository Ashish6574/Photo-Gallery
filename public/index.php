<?php require_once("../includes/initialize.php"); ?>
<?php
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$per_page = 6;

$total_count = Photograph::count_all();


$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql);

?>

<?php include_layout_template('header.php'); ?>

<?php foreach ($photos as $photo) : ?>
	<div style="float: left; margin-left: 18px;">
		<a href="photo.php?id=<?php echo $photo->id; ?>">
			<img src="<?php echo $photo->image_path(); ?>" width="390" height="250" style="border-radius: 10px;" />
		</a>
		<h3 style="text-align: center;">From :- <?php echo $photo->photo_author; ?></h3>
	</div>
<?php endforeach; ?>

<div id="pagination" style="clear: both; font-size: 25px; text-align: center; padding-top: 25px;">
	<?php
	if ($pagination->total_pages() > 1) {

		if ($pagination->has_previous_page()) {
			echo "<a href=\"index.php?page=";
			echo $pagination->previous_page();
			echo "\">&laquo; Previous</a> ";
		}

		for ($i = 1; $i <= $pagination->total_pages(); $i++) {
			if ($i == $page) {
				echo " <span class=\"selected\">{$i}</span> ";
			} else {
				echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
			}
		}

		if ($pagination->has_next_page()) {
			echo " <a href=\"index.php?page=";
			echo $pagination->next_page();
			echo "\">Next &raquo;</a> ";
		}
	}

	?>
</div>


<?php include_layout_template('footer.php'); ?>