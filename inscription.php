<?php include_once('header.php'); ?>

<h2>Inscription</h2>
    <form method="POST" action="inscription.php">
        <label for="new_email">Nouvelle adresse e-mail :</label>
        <input type="email" name="new_email" id="new_email" required><br><br>
        
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" name="new_password" id="new_password" required><br><br>
        
        <input type="submit" value="S'inscrire">
        
    </form>