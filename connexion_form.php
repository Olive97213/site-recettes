<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root', '');

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $motDePasse = $_POST['password'];
    $recupUser = $bdd->prepare('SELECT user.*
    FROM user WHERE email = ?');
    $recupUser->execute(array($email));

    if ($recupUser->rowCount() > 0) {
        $user = $recupUser->fetch();

        if (isset($user['mot_de_passe']) && password_verify($motDePasse, $user['mot_de_passe'])) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $motDePasse;
            $_SESSION['id'] = $user['id'];
            header('location: user-page.php');
        } else {
            echo "Votre mot de passe est incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "Il faut un email et un mot de passe valide pour se connecter.";
    }
}
?>
