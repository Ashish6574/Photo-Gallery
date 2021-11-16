<html>

<head>
	<!-- <link href="../stylesheets/main.css" rel="stylesheet"/> -->
</head>

<body>
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="photo_upload.php">Upload Photo</a></li>
		<li><a href="list_photos.php">Show all Photo</a></li>
		<li class="dropdown" style="float: right;">
			<a href="javascript:void(0)" class="dropbtn" style=" background-color: #4CAF50;">
				<?php
				$user = User::find_by_id($_SESSION['user_id']);
				echo $user->full_name();
				?>
			</a>
			<div class="dropdown-content">
				<a href="logfile.php">View Log file</a>
				<a href="profile.php">Profile</a>
				<a href="logout.php">Log Out</a>
				<a href="delete.php">Delete Account</a>
			</div>
		</li>
	</ul>
</body>

</html>