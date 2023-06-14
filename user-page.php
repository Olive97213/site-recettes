<?php
session_start();
require_once "db.php";

$message = isset($_GET['message']) ? $_GET['message'] : '';

// Afficher le message dans le HTML
echo $message; ?>