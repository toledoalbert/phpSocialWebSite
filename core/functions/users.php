<?php

//function to determine who can access.
function has_access($user_id, $type)
{
	$user_id = (int)$user_id;
	$type = (int)$type;
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = $type"), 0) == 1) ? true : false;
}

//function to recover password or username.
function recover($mode, $email)
{
	$mode = sanitize($mode);
	$email = sanitize($email);
	
	$user_data = user_data(user_id_from_email($email), 'user_id', 'first_name', 'username');
	
	if($mode == 'username')
	{
		email($email, 'Username recovery', "Hi," . $user_data['first_name'] . ", \n\nYour username is: " . $user_data['username'] . "\n\nBi daha da unutmazsin! :P" );
	}
	else if($mode == 'password')
	{
		$generated_password = substr(md5(rand(999, 9999999)), 0, 8);
		change_password($user_data['user_id'], $generated_password);
		
		update_user($user_data['user_id'], array('password_recover' => '1'));
		
		email($email, 'Temporary password information', "Hi," . $user_data['first_name'] . ", \n\nYour temporary password is: " . $generated_password . "\n\nBi daha da unutmazsin! :P" );
	}
}

//function to update user(inert info to database.).
function update_user($user_id, $update_data)
{
	array_walk($update_data, 'array_sanitize');
	
	foreach($update_data as $field => $data)
	{
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}
	
	mysql_query("UPDATE `users` SET" . implode(', ', $update) . "WHERE `user_id` = $user_id");
	
}

//activate the account via email.
function activate($email, $email_code)
{
	$email = mysql_real_escape_string($email);
	$email_code = mysql_real_escape_string($email_code);					//problem here, couldnt check for email_code
	
	if(mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `active` = 0"), 0) == 1)
	{
		mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
	}
	else
	{
	 return false;
	 echo $email_code;
	} 
	
}

//function to change the password.
function change_password($user_id, $password)
{
	$user_id = (int)$user_id;
	$password = encrypt_pass($password);  //encrypt
	mysql_query("UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id") ;
}

//function to register user(inert info to database.).
function register_user($register_data)
{
	$register_data['password'] = encrypt_pass($register_data['password']);  //encrypt
	array_walk($register_data, 'array_sanitize');
	
	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';
	
	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	email($register_data['email'], 'Activate your account.', "Hello " . $register_data['first_name'] . ",\n\nYou need to activate your account to be able to log in. Please enter the link below.\n\nhttp://www.alberttoledo.com/sourceFiles/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n\nBu da benden");  	
}

//return how many users are registered and active.
function user_count()
{
	return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
}

//get users data.
function user_data($user_id)
{
	$data = array();
	//cast the id to be secure.
	$user_id = (int)$user_id;
	
	//how many arguments func has.
	$func_num_args = func_num_args();
	//get all the args.
	$func_get_args = func_get_args();
	
	//if more than one args.
	if($func_get_args > 1)
	{
		//unset the id.
		unset($func_get_args[0]);
		//get the fields properly to insert to the query.
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		//get data from database.
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));
		
		return $data;
	}
	
}

//function to check if looged in(if has an id)
function logged_in()
{
	return (isset($_SESSION['user_id'])) ? true : false;
}

//function to check if the user exists.
function user_exists($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query, 0) == 1) ? true : false;
} 

//function to check if email exists in database.
function email_exists($email)
{
	$email = sanitize($email);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
	return (mysql_result($query, 0) == 1) ? true : false;
} 

//function to check if user has activated the account.
function user_active($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1");
	return (mysql_result($query, 0) == 1) ? true : false;
}

//function to get the id that belongs to that username.
function user_id_from_username($username)
{
	$username = sanitize($username);
	$query = mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'" );
	return mysql_result($query, 0, 'user_id');
}

//function to get the id that belongs to that email.
function user_id_from_email($email)
{
	$email = sanitize($email);
	$query = mysql_query("SELECT `user_id` FROM `users` WHERE `email` = '$email'" );
	return mysql_result($query, 0, 'user_id');
}

//checking the login info and return the id or false if incorrect.
function login($username, $password)
{
	$user_id = user_id_from_username($username);
	
	$username = sanitize($username);
	$password = encrypt_pass($password);  //encrypt
	
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
	
	return (mysql_result($query, 0) == 1) ? $user_id : false;
} 



?>