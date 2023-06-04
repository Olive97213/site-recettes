<?php
$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','root');

if (isset($_POST['submit'])){
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $motDePasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['nom']) || empty($_POST['prenom'])) {
        echo "Il faut remplir tous les champs du formulaire.";
    } else {
        $nom = $nom . ' ' . $prenom;
        $insertUser = $bdd->prepare('INSERT INTO user (nom, email, mot_de_passe) VALUES (?, ?, ?)');
        $insertUser->execute(array($nom, $email, $motDePasse));
        echo "L'utilisateur a été ajouté avec succès.";
    }
}
?>
