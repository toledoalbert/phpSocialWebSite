<div class="widget">
	<!-- widget to say hello to logged in user. -->
	<h2>Hi, <?php echo $user_data['first_name']; ?></h2>
	
	<div class="inner">
		
		<ul>
			<li><a href = "profile.php?username=<?php echo $user_data['username']; ?>" >Profile</a></li>
			<li><a href = "logout.php"> Log out</a></li>
			<li><a href = "changepassword.php" > Change Password </a></li>
			<li><a href = "settings.php" > Settings </a></li>
			<?php
			
			//check if admin.
			if(has_access($session_user_id, 1))
			{
				echo '<li><a href = "admin.php" > Admin Page </a></li>';
			}
			
			 ?>
		</ul>
		
	</div>
	
</div>