<?php
require_once("../../includes/initialize.php");

$user = User::find_by_id($_SESSION['user_id']);

?>

<?php include("../layouts/admin_header.php"); ?>
<?php include("../layouts/nav.php"); ?>
<h1 style="text-align: center; margin-top: 30px;">Profile</h1>
<br>
<div style="text-align: center; width: 50%; margin: auto; border: 3px solid black; margin-bottom: 25px; border-radius: 25px; margin-top: 15px; font-size: 15px;">
    <h3>First Name :- <?php echo $user->first_name ?></h3>
    <hr>
    <h3>Last Name :- <?php echo $user->last_name ?></h3>
    <hr>
    <h3>UserName :- <?php echo $user->username ?></h3>
    <hr>
    <h3>Email :- <?php echo $user->email ?></h3>
    <hr>
    <h3>Password :- <?php echo $user->password ?></h3>
    <br>
    <button style="font-size: 25px; background-color: #333; border-radius: 10px; border: 3px solid #4CAF50;">
        <a style="text-decoration: none; color: white;" href="logout.php">
            Log Out
        </a>
    </button>
    <button style="font-size: 25px; background-color: #333; border-radius: 10px; border: 3px solid #4CAF50;">
        <a style="text-decoration: none; color: white;" href="delete.php">
            Delete Account
        </a>
    </button><br><br><br>
</div>
<?php include("../layouts/admin_footer.php"); ?>