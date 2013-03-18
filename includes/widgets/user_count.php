<div class="widget">

	<h2>Users</h2>
	
	<div class="inner">
		<?php
			//count and print the users number.
			$user_count = user_count();
			//check if plural and add s.
			$suffix = ($user_count != 1) ? 's' : '';
		?>
		We currently have <?php echo $user_count; ?> registered user<?php echo $suffix; ?>.

	</div>
	
</div>