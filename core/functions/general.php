<?php

//activation email.
function email($to, $subject, $body)
{
	mail($to, $subject, $body);
}

//not to allow to register etc. while  logged in.
function logged_in_redirect()
{
	if(logged_in() === true)
	{
		header('Location: already.php');
		exit();
	}
}


//redirect if not admin.
function admin_protect()
{
	global $user_data;  //bi burda kullandim global variable o da zorunluluktan :D
	if(has_access($user_data['user_id'], 1) === false)
	{
		header('Location: index.php');
		exit();
	}
}

//function to protect page.
function protect_page()
{
	if(logged_in() === false)
	{
		header('Location: protected.php');
		exit();
	}
}

//function to sanitize all the elements of an array at once.
function array_sanitize(&$item)
{
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

//just the function to sanitize the username for security.
function sanitize($data)
{
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

//function to output the errors. (printing an array nicely)
function output_errors($errors)
{
	return '<ul><li>' . implode('</li><li>', $errors) . '</li><ul>';
}

//function to encrypt the password.
function encrypt_pass($str)
{
  $key = "abcdefgh12345678";
  for($i=0; $i<strlen($str); $i++) 
  {
     $char = substr($str, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)+ord($keychar));
     $result.=$char;
  }
  return urlencode(base64_encode($result));
}

/*//function to decrypt.
function decrypt_pass($str)
{
  $str = base64_decode(urldecode($str));
  $result = '';
  $key = "abcdefgh12345678";
  for($i=0; $i<strlen($str); $i++) 
  {
    $char = substr($str, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
return $result;
}
*///// didnt use this function.
?>