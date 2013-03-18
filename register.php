<?php 

//include necessary stuff.
include 'core/init.php';

//dont show if logged in.
logged_in_redirect();

//if they entered something check if all.
if(empty($_POST) === false)
{
	$required_fields = array('username', 'password', 'password_again', 'first_name', 'email');
	foreach($_POST as $key => $value)
	{
		if(empty($value) && in_array($key, $required_fields) === true)
		{
			$errors[] = 'Fields with an asterisk are required.';
			break 1;
		}
	}
	
	//if everything entered check for other errors.
	if(empty($errors) === true)
	{
		//check if username exists.
		if(user_exists($_POST['username']) === true)
		{
			$errors[] = 'Sorry, the username \'' . $_POST['username'] . '\' is already taken.';
		}
		//check if there is space in username.
		if(preg_match("/\\s/", $_POST['username']) == true)
		{
			$errors[] = 'Username cannot contain spaces.';
		}
		//check if password has 6 or more chars.
		if(strlen($_POST['password']) < 6)
		{
			$errors[] = 'Password must contain at least 6 characters.';
		}
		//check if pass again is the same with password.
		if($_POST['password'] !== $_POST['password_again'])
		{
			$errors[] = 'Passwords do not match.';
		}
		//check if email is valid.
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
		{
			$errors[] = 'Please enter a valid email address.';
		}
		//check if there is a user with same email.
		if(email_exists($_POST['email']) === true)
		{
		 $errors[] = 'Sorry, there is already an account with this email.';
		}
	}
}

//if no error and not registered.	
if(empty($_POST) === false && empty($errors) === true)
{
     //get the info into the array.
	 $register_data = array
     (
             'username'       => $_POST['username'],
             'password'       => $_POST['password'],
    	     'first_name'     => $_POST['first_name'],
        	 'last_name'      => $_POST['last_name'],
        	 'email'          => $_POST['email'],
        	 'email_code'	  => encrypt_pass($_POST['username'] + microtime())	
     );  
        
    //call register func to insert info to the databse, redirect and exit code.	
    register_user($register_data);
    header('Location: register.php?success');
    exit();
        
}

//include header.
include 'includes/overall/header.php'; 

//if there is error output them.
if(empty($errors) === false)
{
    echo output_errors($errors);
}
	 
?>

	<h1> Register </h1>
	<?php
	
	//check if registered.
	if(isset($_GET['success']) && empty($_GET['success']))
	{
		echo 'You have been registered successfully! Please check your emails to activate your account.';
	}
	else
	{
	
	?>
	<form action = "register.php" method = "post">
		<ul>
			<li>Username*:<br> <input type = "text" name = "username" </li>
			<li>Password*:<br> <input type = "password" name = "password" </li>
			<li>Password again*: <br><input type = "password" name = "password_again" </li>
			<li>First name*: <br><input type = "text" name = "first_name" </li>
			<li>Last name:<br> <input type = "text" name = "last_name" </li>
			<li>Email*:<br> <input type = "text" name = "email" </li>
			<li><input type = "submit" value = "Register"> </li>
		</ul>
	</form>	
		
<?php
}//end of else not to show the form if registered.

//include the footer.
include 'includes/overall/footer.php'; 

?>