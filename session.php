<?php

	session_start();
	
	require_once 'objects/class.user.php';
	$session = new USER();
	

	if(!$session->is_loggedin())
	{
		// session no set redirects to login page
		$session->redirect('sign_in.php');
	}