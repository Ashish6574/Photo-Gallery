<?php
require_once('../../includes/initialize.php');

User::delete($_SESSION['user_id']);
$session->logout();
redirect_to("login.php");

?>