<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','root');

if (isset($_POST['submit'])){ 
    
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
         
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
        
        $nom = $nom . ' ' . $prenom;
        $insertUser = $bdd->prepare('INSERT INTO user (nom, email, mot_de_passe) VALUES (?, ?, ?)');
        $insertUser->execute(array($nom, $email, $motDePasse));
        $lastInsertId = $bdd->lastInsertId(); // Récupère l'id de la dernière insertion

        if (!empty($lastInsertId)) {
            $message = "L'utilisateur a été ajouté avec succès. L'id de l'utilisateur est : " . $lastInsertId;
            header('location: connexion.php?message=' . urlencode($message));
        } else {
            $message = "Erreur lors de l'ajout de l'utilisateur.";
            header('location: inscription.php?message=' . urlencode($message));
        }
        

        $recupUser = $bdd->prepare('SELECT * FROM user WHERE nom = ? AND email = ? AND mot_de_passe = ?');
        $recupUser->execute(array($nom, $email, $motDePasse));
        if($recupUser->rowCount() > 0){
            $user = $recupUser->fetch();
            if (isset($user['id'])){
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
    
}


?>
 
 