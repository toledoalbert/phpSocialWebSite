<?php
	//include the necessary stuff
	include 'core/init.php';
	
	//redirect if already logged in.
	logged_in_redirect();
	
	//checking all the fields and assigning the right errors to the errors array.
	if(empty($_POST) === false)
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			if(empty($username) === true || empty($password) === true)
			{
				$errors[] = 'You need to enter a username and a password';
			} 
			else if(user_exists($username) === false)
			{
				$errors[] = 'User does not exist. Please <a href = "register.php" >register!</a>';
			} 
			else if(user_active($username) === false)
			{
				$errors[] = 'You have not activated your account, please activate it via your e-mail!';
			}
			else
			{
				//if all the fields are filled, get the user id.
				$login = login($username, $password);
				//if user id fails assign the error to the array.
				if($login === false)
				{
					$errors[] = 'Username - Password combination does not match.';
 				}
 				//if everything is ok, assign the userid to the session and exit and redirect to index(appears as home).
 				else
 				{
 				
 					$_SESSION['user_id'] = $login;
 					header('Location: index.php');
 					exit(); 
 				} 
			} 
			
		
		}
		else
		{
			$errors[] = 'No data received.';
		}
		
		
		//include the header.
		include 'includes/overall/header.php';
		
		if(empty($errors) === false)
		{
		
		?>
		
			<h2>You couldn't be logged in due to following errors: </h2>
		<?php
		
		echo output_errors($errors);
		}
		
		
		//include the footer.
		include 'includes/overall/footer.php';
?>
