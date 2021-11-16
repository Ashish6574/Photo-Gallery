<?php

$path = dirname(__FILE__);
require_once("config.php");
require_once("functions.php");
require_once("session.php");
require_once("database.php");
require_once("database_object.php");
require_once("user.php");
require_once("photographs.php");
require_once("comment.php");
require_once("pagination.php");
require_once($path."\phpmailer\Exception.php");
require_once($path."\phpmailer\PHPMailer.php");
require_once($path."\phpmailer\SMTP.php");
?>