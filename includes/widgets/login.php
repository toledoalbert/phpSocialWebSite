<div class="widget">

	<h2>Login</h2>
	
	<div class="inner">
		
		<form action = "login.php" method = "post" >
		
			<ul id = "login" >
				
				<li>
					Username: <br>
					<input type = "text" name = "username" >					
				</li>
				
				<li>
					Password: <br>
					<input type = "password" name = "password">
				</li>
				
				<li>
					<input type = "submit" value = "Login" >
				</li>
				
				<li>
					<a href = "register.php" > Not registered? Register Here! </a>
				</li>
				
				<li>
					 Forgot your <a href = "recover.php?mode=username">username</a> or <a href = "recover.php?mode=password">password? </a>
				</li>
				
			</ul>
		
		</form>
	</div>
	
</div>