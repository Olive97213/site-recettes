<?php include_once('header.php'); ?>

<h2>Connexion</h2>
    <form method="POST" action="connexion.php">
        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email" required><br><br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Se connecter">
        <a href="inscription.php"><p>S'inscrire</p></a>
    </form>
    