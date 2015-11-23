<?php
if (is_auth(100))
{
	header("Location:".$site['url'].'yonetim');
}
if (is_auth(1))
{
	header("Location:".$site['url']);
}

/* Sign up */
if (isset($_POST['user_email']) && isset($_POST['user_pass1']) && $_POST['user_pass1'] == $_POST['user_pass2'])
	$user->signup($_POST['user_email'], $_POST['user_pass1'], $_POST['user_pass2']);