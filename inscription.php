<?php include_once('header.php'); 

$bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','');
// $bdd = new PDO('mysql:host=localhost;dbname=recettes_patisserie;charset=utf8;', 'root','root');

$message = isset($_GET['message']) ? $_GET['message'] : '';

// Afficher le message dans le HTML
echo $message;?>
<link rel="stylesheet" href="link/inscription.css">




<div class="inscription">
    <h2>Inscription</h2>
    <form method="POST" action="inscription_form.php">

        <label for="nom">Nom :</label>
        <input type="texte" name="nom" id="nom"><br><br>

        <label for="prenom">Prenom : </label>
        <input type="texte" name="prenom" id="prenom"><br><br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password"><br><br>

        <input type="submit" value="S'inscrire" name="submit">

    </form>
</div>





<?php include_once('footer.php'); ?>