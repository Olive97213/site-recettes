<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','root');

function getUserByEmail($email) {
    global $bdd;
    $query = $bdd->prepare('SELECT * FROM user WHERE email = ?');
    $query->execute([$email]);
    return $query->fetch();
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $motDePasse = $_POST['password'];

        if ($email === false) {
            echo "L'e-mail saisi n'est pas valide.";
            header('location: connexion.php?message=' . urlencode($message));
        } else {
            $user = getUserByEmail($email);
            if ($user !== false) {
                if (password_verify($motDePasse, $user['mot_de_passe'])) {
                    $_SESSION['id'] = $user['iduser'];
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['password'] = $user['mot_de_passe'];
                    
                    $message = "Connexion réussie. Bienvenue, " . $_SESSION['nom'] . "!";
                    header('location: user-page.php?message=' . urlencode($message));
                } else {
                    $message = "Mot de passe incorrect.";
                    header('location: connexion.php?message=' . urlencode($message));    
                }
            } else {
                $message = "Aucun utilisateur trouvé avec cet e-mail.";
                header('location: connexion.php?message=' . urlencode($message));
            }
        }
    } else {
        $message = "Il faut remplir tous les champs du formulaire.";
        header('location: connexion.php?message=' . urlencode($message));
    }
}
?>
