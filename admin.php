<?php 
ob_start();
//include necessary stuff.
include 'core/init.php';
include 'includes/overall/header.php'; 
//check if logged in.
protect_page();
//check if admin.
admin_protect();

?>

		<h1> Admin </h1>
		<p>Admin Page</p>
	
<?php 

//include the footer.
include 'includes/overall/footer.php'; 

?>