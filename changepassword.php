<?php 

//include necessary stuff.
include 'core/init.php';

//protect from users not logged in.
protect_page();


	//if entered info
	if(empty($_POST) === false)
	{
		//set required fields.
		$required_fields = array('current_password', 'password', 'password_again');
		foreach($_POST as $key => $value)
		{
			//check if required is empty and print error if necessary.
			if(empty($value) && in_array($key, $required_fields) === true)
			{
				$errors[] = 'Fields with an asterisk are required.';
				break 1;
			}
		}
	
		//check if current password correct.
		if(encrypt_pass($_POST['current_password']) === $user_data['password'])
		{
			if(trim($_POST['password']) !== trim($_POST['password_again']))
			{
				$errors[] = 'New passwords does not match.';
			}
			else if(strlen($_POST['password']) < 6)
			{
				$errors[] = 'Password must contain at least 6 characters.';
			}
		}
		//if not print error.
		else
		{
			$errors[] = 'You entered your current password incorrectly.';
		}
	
	}
	
	//if no error change the password and redirect.
	if(empty($_POST) === false && empty($errors) === true)
	{
		change_password($session_user_id, $_POST['password']);
		header('Location: changepassword.php?success');
		exit();
	}

	//include the header.
	include 'includes/overall/header.php'; 
	
	//if there is output errors.
	if(empty($errors) === false)
			{
				echo output_errors($errors);
			}

	?>

		<h1> Change Password </h1>
		
		<?php

			//check if password changed.
			if(isset($_GET['success']) === true && empty($_GET['success']) === true)
			{
				echo 'Your password has been changed.';
			}
			else
			{
			
				if(isset($_GET['force']) === true && empty($_GET['force']) === true)
				{
					echo '<p>You must change your temporary password before you enter the site.</p>';
				}
		
		?>
		
		<form action = "" method = "post">
			<ul>
			<li>Current password*:<br>
				<input type = "password" name = "current_password">
			</li>
			
			<li>New password*: <br>
				<input type = "password" name = "password">
			</li>
			
			<li>New password again*:<br>
				<input type = "password" name = "password_again">
			</li>
			
			<li>
				<input type = "submit" value = "Change password">
			</li>
			</ul>
		</form>
		
<?php 
}
//include the footer.
include 'includes/overall/footer.php'; 

?>