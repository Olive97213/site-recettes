<?php

require_once "db.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;



require "vendor/autoload.php";

// if (isset($_POST['submit'])) {

//     if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
//         // stocker information de l'utilisateur
//         $nom = htmlspecialchars($_POST['nom']);
//         $prenom = htmlspecialchars($_POST['prenom']);
//         $email = htmlspecialchars($_POST['email']);
//         $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

//         // mise en place d'une clé aleatoire
//         $cle = rand(1000000, 9000000);
//         // requete d'insertion
//         // $nom = $nom . ' ' . $prenom;
//         $insertUser = $bdd->prepare('INSERT INTO user (nom, prenom, email, mot_de_passe, cle, confirme) VALUES (?, ?, ?, ?, ?, ?)');
//         $insertUser->execute(array($nom, $prenom, $email, $motDePasse, $cle, 0));
//         $lastInsertId = $bdd->lastInsertId(); // Récupère l'id de la dernière insertion


//         function smtpmailer($to, $from, $from_name, $subject, $msg)
//         {
//             // $mail = new PHPMailer();
//             // $mail->IsSMTP();
//             // $mail->SMTPAuth = true;

//             // $mail->SMTPSecure = 'ssl';
//             // $mail->Host = 'smtp.gmail.com';
//             // $mail->Port = 465;
//             // $mail->Username = 'golivier@gmail.com';
//             // $mail->Password = '';

//             //   $path = 'reseller.pdf';
//             //   $mail->AddAttachment($path);
//             $mail = new PHPMailer();
//             $mail->isSMTP();
//             $mail->Host = 'localhost';
//             $mail->Port = 1025;

//             $mail->IsHTML(true);
//             $mail->From = "golivier@gmail.com";
//             $mail->FromName = $from_name;
//             $mail->Sender = $from;
//             $mail->AddReplyTo($from, $from_name);
//             $mail->Subject = $subject;
//             // $mail->Body = $body;
//             $mail->Body = $msg;

//             $mail->AddAddress($to);
//             if (!$mail->Send()) {
//                 $error = "Please try Later, Error Occured while Processing...";
//                 return $error;
//             } else {
//                 $error = "Thanks You !! Your email is sent.";
//                 return $error;
//             }
//         }

//         $to   = $email;
//         $from = 'golivier@gmail.com';
//         $name = 'olivier';
//         $subj = 'Email de confirmation';
//         $msg = '<a href="http://localhost:8888/site-recettes/verif.php?id=' . $_SESSION['id'] . '&cle=' . $cle . '"Cliquez ici</a>';



//         $error = smtpmailer($to, $from, $name, $subj, $msg);
//     }

//     if (!empty($lastInsertId)) {
//         $message = "L'utilisateur a été ajouté avec succès. L'id de l'utilisateur est : " . $lastInsertId;
//         header('location: connexion.php?message=' . urlencode($message));
//     } else {
//         $message = "Erreur lors de l'ajout de l'utilisateur.";
//         header('location: inscription.php?message=' . urlencode($message));
//     }

//     // requete pour recuperer l'utilisateur
//     $recupUser = $bdd->prepare('SELECT * FROM user WHERE nom = ? AND prenom = ? AND email = ? AND mot_de_passe = ?');
//     $recupUser->execute(array($nom, $prenom, $email, $motDePasse));
//     if ($recupUser->rowCount() > 0) {
//         $user = $recupUser->fetch();
//         if (isset($user['id'])) {
//             $_SESSION['id'] = $user['id'];
//             $_SESSION['nom'] = $nom;
//             $_SESSION['prenom'] = $prenom;
//             $_SESSION['email'] = $email;
//             $_SESSION['password'] = $motDePasse;
//         }
//     }
// } else {
//     $message = "Il faut remplir tous les champs du formulaire.";
//     header('location: inscription.php?message=' . urlencode($message));
// }






if(isset($_POST['submit'])){

    $errors = array();
    //nom d'utilisateur conditions et implémentation dans la base de données (utilisation d'une Regex n'autorisant que les lettres minuscules et majuscules)

    if (empty($_POST['nom']) || !preg_match('/^[a-zA-Z]+$/', $_POST['nom'])) {

        $errors['nom'] = "Votre nom n'est pas valide, il doit contenir que des majuscules et ou minuscules";
    }
   
    if (empty($_POST['prenom']) || !preg_match('/^[a-zA-Z]+$/', $_POST['prenom'])) {

        $errors['prenom'] = "Votre prenom n'est pas valide, il doit contenir que des majuscules et ou minuscules";
    }



    // email conditions et implémentation dans la base de données (utilisation de filter_var())

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $errors['email'] = "votre email n'est pas valide";

    } else { // Requête pour vérifier si le compte mail existe déja ou non dans la base de données

        $req = $pdo->prepare('SELECT iduser FROM user WHERE email=?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();

        if ($user) { // si existant

            $errors['email'] = 'Cet e-mail existe déjà';

        };
    }

    if(empty($errors)){

        // récupération des valeurs de champs de formulaire et sanitize
        $nom = htmlspecialchars($_POST['nom']) ;
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']) ;
        $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

        
        // Préparation de la requête d'insertion
        $query = "INSERT INTO user (nom, prenom, email, mot_de_passe ) VALUES (:nom, :prenom, :email, :mot_de_passe)";
        $statement = $pdo->prepare($query);

        // liaison entre les colonnes et leur valeur
        $statement->bindParam(':nom', $nom);
        $statement->bindParam(':prenom', $prenom);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':mot_de_passe', $motDePasse);
        

        // Execution pour insertion en base de donnée
        $statement->execute();
        $_SESSION['flash']['success'] = 'Votre compte a bien été créé merci de vous connecter';
        header('Location: connexion.php');
        exit();
    }
        

}