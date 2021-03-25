<?php

$validUser = false;
if ($_POST["email"] == "admin@admin.com" && $_POST["password"] == "password")
{
  setcookie('id', '0', time() + (86400 * 30), "");
  $validUser = true;
} else if ($_POST["email"] == "john@john.com" && $_POST["password"] == "123") {
  setcookie('id', '1', time() + (86400 * 30), "");
  $validUser = true;
}


if($validUser) {
   header("Location: profile.php"); die();
} else { 
	echo "Invalid username or password. <a href='index.php'> Back to login</a>"; 
}