<?php
require_once('includes/inc.php');

unset($_SESSION["login_string"]);

session_unset();
session_destroy();

header('Location: login.php');
exit();
?>