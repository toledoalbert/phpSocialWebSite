<?php 
ob_start();
//include necessary stuff.
include 'core/init.php';

//redirect if already logged in.
logged_in_redirect();

//include header.
include 'includes/overall/header.php'; 

if(isset($_GET['success']) === true && empty($_GET['success']) === true)
{
	?>
		<h2>Your account is activated successfully.</h2>
	<?php
}
//check if get variables are set.
else if(isset($_GET['email'], $_GET['email_code']) === true)
{
	//trim if there is any space.
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	
	//check if email in database.
	if(email_exists($email) === false)
	{
		$errors[] = 'Something went wrong. Could not find the email address in database.';
	}
	//check if activate fails
	else if(activate($email, $email_code) === false)
	{
		$errors[] = 'We had problems activating your account.';
	}
	
	//if there are errors.
	if(empty($errors) === false)
	{
		?>
			<h2>Oooopss.. :P</h2>
		<?php
			echo output_errors($errors);
	}
	else
	{
		//if successfully activated redirect.
		header('Location: activate.php?success');
		exit();
	}
	
}
else
{
	//if everything is ok, redirect to the index.
	header('Location: index.php');
	exit();
}
//include the footer.
include 'includes/overall/footer.php'; 

?>