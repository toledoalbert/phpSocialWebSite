<?php 
ob_start();   //make the header work.

//include necessary stuff.
include 'core/init.php';

//check if logged in.
logged_in_redirect();

//include the header/
include 'includes/overall/header.php'; 
?>

		<h1> Recover Login Information </h1>
		
		<?php
		
	//check if already recovered.
	if(isset($_GET['success']) === true && empty($_GET['success']) === true)
	{
		echo '<p>We have emailed you your recovered information.</p>';
	}
	else
	{
		//set the allowed info to change.
		$mode_allowed = array('username', 'password');
		
		//if not check which info is to be recovered.
		if(isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true)
		{
			//check if they entered email.
			if(isset($_POST['email']) === true && empty($_POST['email']) === false)
			{
				//check if email exists in database.
				if(email_exists($_POST['email']) === true)
				{
					recover($_GET['mode'], $_POST['email']);
					header('Location: recover.php?success');
					exit();
				}
				else
				{
					//if email not in db print error.
					echo '<p>The email you entered is not registered.</p>';
				}
			}
			
			?>
			
				<form action = "" method = "post">
					<ul>
						<li>
							Please enter your email address. <br>
							<input type = "text" name = "email">
						</li>
						
						<li>
							<input type = "submit" value = "Recover my information" >
						</li>
					</ul>
				</form>
			
			<?php
			
		}
		else
		{
			//if they try to enter different get variable redirect to index.
			header('Location: index.php');
		}
		
		?>
	
<?php 
}// end of else (not success)
//include the footer.
include 'includes/overall/footer.php'; 

?>