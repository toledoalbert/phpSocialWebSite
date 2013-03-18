<?php 
ob_start();
//include necessary stuff.
include 'core/init.php';
include 'includes/overall/header.php'; 



if(isset($_GET['username']) === true && empty($_GET['username']) === false)
{
	$username = $_GET['username'];        //.htaccess kullanarak linki /username yapmak istedim ama sorun cikti.
	//$username = user_data['username'];  bu da bi secenekti ama baska userlar profile giremezdi herkes sadece kendi profilini gorurdu.
	if(user_exists($username) === true)
	{
	$user_id = user_id_from_username($username);
	$profile_data = user_data($user_id, 'first_name', 'last_name', 'email');
	?>
	
		<h1><?php echo $profile_data['first_name']; ?>'s Profile</h1>
		<ul>
			<li>Username: <?php echo $username; ?></li>
			<li>First name: <?php echo $profile_data['first_name']; ?></li>
			<li>Last name: <?php echo $profile_data['last_name']; ?></li>
			<li>Email: <?php echo $profile_data['email']; ?></li>		
		</ul>
	
	<?php
	}
	else
	{
		//if no user exist print error.
		echo 'Sorry, that user does not exist.';
	}
}
else
{
	header('Location: index.php');
	exit();
} 


//include the footer.
include 'includes/overall/footer.php'; 

?>