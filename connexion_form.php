<?php

$email = $_POST['email'];
$password = $_POST['password'];

if(isset($_POST['submit'])){
    
    if (!empty($_POST['email']) || !empty($_POST['password']));
{
	echo('Il faut un email et un mot de passe valide pour se connecter.');
    return;
}	
}




?>