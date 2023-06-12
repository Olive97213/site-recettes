<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root', '');

use PHPMailer\PHPMailer\PHPMailer;



require "vendor/autoload.php";

if (isset($_POST['submit'])) {

    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
        // stocker information de l'utilisateur
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

        // mise en place d'une clé aleatoire
        $cle = rand(1000000, 9000000);
        // requete d'insertion
        $nom = $nom . ' ' . $prenom;
        $insertUser = $bdd->prepare('INSERT INTO user (nom, email, mot_de_passe, cle, confirme) VALUES (?, ?, ?, ?, ?)');
        $insertUser->execute(array($nom, $email, $motDePasse, $cle, 0));
        $lastInsertId = $bdd->lastInsertId(); // Récupère l'id de la dernière insertion


        function smtpmailer($to, $from, $from_name, $subject, $msg)
        {
            // $mail = new PHPMailer();
            // $mail->IsSMTP();
            // $mail->SMTPAuth = true;

            // $mail->SMTPSecure = 'ssl';
            // $mail->Host = 'smtp.gmail.com';
            // $mail->Port = 465;
            // $mail->Username = 'golivier@gmail.com';
            // $mail->Password = '';

            //   $path = 'reseller.pdf';
            //   $mail->AddAttachment($path);
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->Port = 1025;

            $mail->IsHTML(true);
            $mail->From = "golivier@gmail.com";
            $mail->FromName = $from_name;
            $mail->Sender = $from;
            $mail->AddReplyTo($from, $from_name);
            $mail->Subject = $subject;
            // $mail->Body = $body;
            $mail->Body = $msg;

            $mail->AddAddress($to);
            if (!$mail->Send()) {
                $error = "Please try Later, Error Occured while Processing...";
                return $error;
            } else {
                $error = "Thanks You !! Your email is sent.";
                return $error;
            }
        }

        $to   = $email;
        $from = 'golivier@gmail.com';
        $name = 'olivier';
        $subj = 'Email de confirmation';
        $msg = '<a href="http://localhost:8888/site-recettes/verif.php?id=' . $_SESSION['id'] . '&cle=' . $cle . '"Cliquez ici</a>';



        $error = smtpmailer($to, $from, $name, $subj, $msg);
    }

    if (!empty($lastInsertId)) {
        $message = "L'utilisateur a été ajouté avec succès. L'id de l'utilisateur est : " . $lastInsertId;
        header('location: connexion.php?message=' . urlencode($message));
    } else {
        $message = "Erreur lors de l'ajout de l'utilisateur.";
        header('location: inscription.php?message=' . urlencode($message));
    }

    // requete pour recuperer l'utilisateur
    $recupUser = $bdd->prepare('SELECT * FROM user WHERE nom = ? AND email = ? AND mot_de_passe = ?');
    $recupUser->execute(array($nom, $email, $motDePasse));
    if ($recupUser->rowCount() > 0) {
        $user = $recupUser->fetch();
        if (isset($user['id'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['nom'] = $nom;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $motDePasse;
        }
    }
} else {
    $message = "Il faut remplir tous les champs du formulaire.";
    header('location: inscription.php?message=' . urlencode($message));
}
