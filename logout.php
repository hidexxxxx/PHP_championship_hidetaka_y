<?php

session_start();

//ログインしていないと動いて欲しくないので
include('login_function.php');
check_session_id();

$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
header('Location:login.php');
exit();


?>

