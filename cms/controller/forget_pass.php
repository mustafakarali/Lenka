<?php
if (is_auth(1))
	header("Location:".$site['url']);

/* Forget my password */
if (isset($_POST['user_email']))
	$user->forget_password($_POST['user_email']);
