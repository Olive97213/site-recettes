<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','root');

$message = isset($_GET['message']) ? $_GET['message'] : '';

// Afficher le message dans le HTML
echo $message; ?>