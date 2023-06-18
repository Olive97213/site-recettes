<?php 
use PHPMailer\PHPMailer\PHPMailer;
function smtpmailer($to, $from, $from_name, $subject, $msg)
        {
           
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
        $msg = '<a href="http://localhost:8888/site-recettes/verif.php?id=' . $user_id . '&token=' . $token . '">Cliquez ici pour confirmer votre compte</a>';


        $error = smtpmailer($to, $from, $name, $subj, $msg);