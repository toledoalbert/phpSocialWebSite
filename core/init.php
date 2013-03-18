<?php 
	//start the session.
	session_start();
	
	//connect the database.
	require 'database/connect.php';
	
	//import necessary functions from general.php
	require 'functions/general.php';
	
	//import necessary functions from user.php
	require 'functions/users.php';
	
	//create an array to store the error messages.
	$errors = array();
	
	//check current page.
	$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
	$current_file = end($current_file);
	
	//if user is logged in set userid, user data. 
	if(logged_in() === true)
	{
		$session_user_id = $_SESSION['user_id'];
		$user_data = user_data($session_user_id, 'user_id', 'password', 'username', 'first_name', 'last_name', 'email', 'password_recover', 'type');
	
		//if user not active logout and redirect to index.
		if(user_active($user_data['username']) === false)
		{
			session_destroy();
			header('Location: index.php');
			exit();
		}  
		///check if recently changed password.
		if($current_file !== 'changepassword.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1)
		{
			header('Location: changepassword.php?force');
			exit();
		}
	
	} 
	
	
?>