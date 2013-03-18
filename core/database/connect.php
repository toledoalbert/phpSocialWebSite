<?php
	
	//try to connect to database if not print errors.
	$connection_error = "Sorry we are having connection problems";

	mysql_connect('localhost', 'albertto', 'Fernandovela16!') or die($connection_error);
	mysql_select_db('albertto_groups') or die($connection_error);
	
?>