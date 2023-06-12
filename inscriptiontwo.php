<?php  

use PHPMailer\PHPMailer\PHPMailer;
require "PHPMailer/PHPMailerAutoload.php";

// mise en place d'une clé aleatoire
$cle = rand(1000000, 9000000);
// stocker l'email de l'utilisateur
$email = $_POST['email'];
// requete d'insertion
$inserUser = $bdd->prepare('INSERT INTO user(email, cle, confirme)VALUES(?, ?, ?)');
$inserUser->execute(array($email, $cle, 0));

// requete pour recuperer l'utilisateur
$recupUser = $bdd->prepare('SELECT * FROM user WHERE email = ?');
$recupUser->execute(array($email));
if($recupUser->rowCount() > 0){
    $userInfos = $recupUser->fetch();
    $_SESSION['id'] = $userInfos['id']; 

    
// configuration envois email
function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;  
        $mail->Username = 'golivier@gmail.com';
        $mail->Password = '';   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
        $mail->IsHTML(true);
        $mail->From="golivier@gmail.com";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error ="Please try Later, Error Occured while Processing...";
            return $error; 
        }
        else 
        {
            $error = "Thanks You !! Your email is sent.";  
            return $error;
        }
    }
    
    $to   = 'email';
    $from = 'golivier@gmail.com';
    $name = 'olivier';
    $subj = 'Email de confirmation';
    $msg = 'http://localhost:8888/site-recettes/verif.php?id='.$_SESSION['id'].'&cle='.$cle;
    
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
}

?>

