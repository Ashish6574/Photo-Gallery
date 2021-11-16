<?php
require_once("../../includes/initialize.php");

if($session->is_logged_in()) {
  redirect_to("index.php");
}

if (isset($_POST['submit'])) {
	
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$email = trim($_POST['email']);

	$found_user = User::add_user($first_name, $last_name, $username, $password, $email);

	if ($found_user) {
		$session->login($found_user);
		redirect_to("index.php");
	} else {
		$message = "Username/password combination incorrect.";
	}
} else {
    $first_name = "";
    $last_name = "";
	$username = "";
	$password = "";
	$email = "";
}

?>
<html>

<head>
	<title>Photo Gallery</title>
	<link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="box">
		<h1 class="temp">Photo Gallery</h1><br><br>
		<h2>Create New Account</h2>
		<p>Create your Photo Gallery Account</p>
		<form action="newac.php" method="post">
			<div class="inputBox">
				<input type="text" name="first_name" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($first_name); ?>" />
				<label>First Name</label>
			</div>
			<div class="inputBox">
				<input type="text" name="last_name" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($last_name); ?>" />
				<label>Last Name</label>
			</div>
			<div class="inputBox">
				<input type="text" name="username" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($username); ?>" />
				<label>Username</label>
			</div>
			<div class="inputBox">
				<input type="email" name="email" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($email); ?>" />
				<label>Email</label>
			</div>
			<div class="inputBox">
				<input type="password" name="password" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($password); ?>" />
				<label>Password</label>
			</div>
			<button type="submit" name="submit" value="Login">Login</button>
			<button type="submit" name="submit1" value="Login"><a href="./login.php" style="text-decoration: none; color: #1a73e8;">Go Back</a></button>
		</form>
	</div>
</body>

</html>
<?php if (isset($database)) {
	$database->close_connection();
} ?>