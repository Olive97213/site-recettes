<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','');

if (isset($_POST['submit'])){
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

    if (!empty($_POST['email']) || empty($_POST['password']) || empty($_POST['nom']) || empty($_POST['prenom'])) {
         $nomComplet = $nom . ' ' . $prenom;
        $insertUser = $bdd->prepare('INSERT INTO user (nom, email, mot_de_passe) VALUES (?, ?, ?)');
        $insertUser->execute(array($nomComplet, $email, $motDePasse));
        echo "L'utilisateur a été ajouté avec succès.";
        
         $recupUser = $bdd->prepare('SELECT user.*
        FROM user WHERE email = ? AND nom = ? AND mot_de_passe = ?');
        $recupUser->execute(array($email, $nom, $motDePasse));
        
        if ($recupUser->rowCount() > 0){
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['password'] = $motDePasse;
            $_SESSION['id'] = $recupUser->fetch()['id'];
        }

            header('location: connexion.php');
        } else { echo "Il faut remplir tous les champs du formulaire.";
           
        }
 // echo "Erreur lors de la récupération de l'utilisateur."
       
  
       
    }

?>
