<?php
require_once ('database.php');

	$user = $_POST['username'];
	$password = $_POST['password'];

	$ip_location = findMyIPDetails();

	try {
		checkUserExistence($user, $password);
		$userDetails = getUserInfo($user, $password);
		setUserSession($userDetails);
		trackLoginAttempt($user, $ip_location, 'success');
		header('Location:'.BASEURL.'/?folded=false');
	} catch (Exception $e) {
		trackLoginAttempt($user, $ip_location, 'failed');
		session_destroy();
		header('Location:'.BASEURL.'/login/?status=failed');
	}
