<?php
require_once("../../includes/initialize.php");

if($session->is_logged_in()) {
  redirect_to("index.php");
}
$message = "";
if (isset($_POST['submit'])) {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	$found_user = User::authenticate($username, $password);

	if ($found_user) {
		$session->login($found_user);
		log_action('Login', "{$found_user->username} logged in");
		redirect_to("index.php");
	} else {
		$message = "<script>alert('Username/password combination incorrect.');</script>";
		//echo "<script>alert('Username/password combination incorrect.');</script>";
	}
} else {
	$username = "";
	$password = "";
}

?>

<html>

<head>
	<title>Photo Gallery</title>
	<link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="box" style="width: 31rem;">
		<h1 class="temp">Photo Gallery</h1><br><br>
		<?php echo $message?>
		<h2>Sign in</h2>
		<p>Use your Photo Gallery Account</p>
		<form action="login.php" method="post">
			<div class="inputBox">
				<input type="text" name="username" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($username); ?>" />
				<label>Username</label>
			</div>
			<div class="inputBox">
				<input type="password" name="password" required onkeyup="this.setAttribute('value', this.value);" maxlength="30" value="<?php echo htmlentities($password); ?>" />
				<label>Password</label>
			</div>
			<button type="submit" name="submit" value="Login">Login</button>
			<button type="submit" name="submit1" value="Login"><a href="./newac.php" style="text-decoration: none; color: #1a73e8;">Create Account</a></button>
			<button type="submit" name="submit1" value="Login"><a href="../index.php" style="text-decoration: none; color: #1a73e8;">Back</a></button>
		</form>
	</div>
</body>

</html>
<?php if (isset($database)) {
	$database->close_connection();
} ?>