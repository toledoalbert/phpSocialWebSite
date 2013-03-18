<?php 
ob_start();
//include necessary stuff.
include 'core/init.php';

//protect from users not logged in.
protect_page();

//include the header.
include 'includes/overall/header.php'; 

//if nothing entered.
if(empty($_POST) === false)
{
	//put required fields in array.
	$required_fields = array('first_name', 'email');
	foreach($_POST as $key => $value)
	{
		if(empty($value) && in_array($key, $required_fields) === true)
		{
			$errors[] = 'Fields with an asterisk are required.';
			break 1;
		}
	}

//if no errors.
if(empty($errors) === true)
{
	//check if email valid.
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
	{
		$errors[] = 'Please enter a valid email address.';
	}
	//check if new email exists.
	else if(email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email'])
	{
		$errors[] = 'Sorry there is already an account with this email.';
	}
}

}
?>
	<h1>Settings</h1>
	
	<?php 
		//check if already success.
		if(isset($_GET['success']) === true && empty($_GET['success']) === true)
		{
			echo 'Your information has been updated successfully.';
		}
		else
		{
			//check if everything ok.
			if(empty($errors) === true && empty($_POST) === false)
			{
				$update_data = array(
					'first_name' 	=> $_POST['first_name'],
					'last_name' 	=> $_POST['last_name'],
					'email' 		=> $_POST['email']
				);
			
				//if everything ok then update info.
				update_user($session_user_id, $update_data);
				header('Location: settings.php?success');
				exit();
			
			}	
			//if errors print them.
			else if(empty($errors) === false)
			{
			echo output_errors($errors);
			} 
		  
	?>
	
	<form action = "" method = "post">
		<ul>
			<li>First name*: <br>
				<input type = "text" name = "first_name" value = "<?php echo $user_data['first_name']; ?>" >
			</li>
			
			<li>Last name: <br>
				<input type = "text" name = "last_name" value = "<?php echo $user_data['last_name']; ?>">
			</li>
			
			<li>E-mail*: <br>
				<input type = "text" name = "email" value = "<?php echo $user_data['email']; ?>">
			</li>
			
			<li>
				<input type = "submit"  value = "Update">
			</li>
			
		</ul>
	</form>
	
<?php	
}
//include the footer.
include 'includes/overall/footer.php'; 

?>