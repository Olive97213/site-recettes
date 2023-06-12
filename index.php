<?php 
SESSION_start();
if(!$_SESSION['cle']){
    header('Location: connexion.php');
}
?>