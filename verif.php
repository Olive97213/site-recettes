<?php
session_start();
require_once "db.php";

if(isset($_GET['id']) AND !empty($_GET['id']) AND isset($_GET['cle']) AND !empty($_GET['id'])){
$getid = $_GET['id'];
$getCle = $_GET['cle'];
$recupUser = $bdd->prepare('SELECT * FROM user WHERE id = ? AND cle = ?');
$recupUser->execute(array($getid, $getCle));
if($recupUser->rowCount() > 0){
    $userInfo = $recupUser->fetch();
    if($userInfo['confirme'] != 1){
        $updateConfirmation = $bdd->prepare('UPDATE user SET confirme = ? WHERE id = ?');
        $updateConfirmation->execute(array(1, $getid));
        $_SESSION['cle'] = $getCle;
        header('Location: index.php');
    
    }else{
        $_SESSION['cle'] = $getCle;
        header('Location: index.php');
    }

}else{
    echo "Votre clé ou identifiant est incorrect";
}
}else{
    echo "Aucun utilisateur trouvé";
}
?>