<?php
if (is_auth(100))
{
	error_reporting(0);
	header("Location:".Routes::$base.'admin');
}
elseif (is_auth(1))
{
	error_reporting(0);
	header(Routes::$base);
}

/* Sign in */
if (isset($_POST['user_email']) && isset($_POST['user_pass']))
	$user->signin($_POST['user_email'], $_POST['user_pass']);

