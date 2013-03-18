<?php

//start and end the session and redirect to the index.
session_start();
session_destroy();
header('Location: index.php');


?>