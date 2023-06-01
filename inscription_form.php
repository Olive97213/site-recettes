<?php
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','');
$email = $_POST['email'];
$password = $_POST['password'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];

if (isset($_POST['submit'])){
    $pseudo = htmlspecialchars($_POST['nom,prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
    $insertUser = $bdd->prepare('INSERT INTO user (pseudo, email, mdp)VALUES(?, ?, ?)');
    $insertUser->execute(array($pseudo, $email, $mdp));

    if (!empty($_POST['email']) || !empty($_POST['password']) || !empty($_POST['nom']) || !empty($_POST['prenom']));
{
	
}
    echo('Il faut un email un mot de passe un nom et prenom pour soumettre le formulaire.');
    	
}




?>