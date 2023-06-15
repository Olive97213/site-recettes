<?php

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root', '');
// $bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','root');
if (isset($_GET['iduser']) and !empty($_GET['iduser']) and isset($_GET['cle']) and !empty($_GET['iduser'])) {
    $getid = $_GET['iduser'];
    $getCle = $_GET['cle'];
    $recupUser = $bdd->prepare('SELECT * FROM user WHERE iduser = ? AND cle = ?');
    $recupUser->execute(array($getid, $getCle));
    if ($recupUser->rowCount() > 0) {
        $userInfo = $recupUser->fetch();
        if ($userInfo['confirme'] != 1) {
            $updateConfirmation = $bdd->prepare('UPDATE user SET confirme = ? WHERE iduser = ?');
            $updateConfirmation->execute(array(1, $getid));
            $_SESSION['cle'] = $getCle;
            header('Location: index.php');
        } else {
            $_SESSION['cle'] = $getCle;
            header('Location: index.php');
        }
    } else {
        echo "Votre clé ou identifiant est incorrect";
    }
} else {
    echo "Aucun utilisateur trouvé";
}
