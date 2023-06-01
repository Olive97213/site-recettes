<?php include_once('header.php'); ?>
<link rel="stylesheet" href="link/connexion.css">


<div class="connexion">
    <h2>Connexion</h2>
    <form method="POST" action="connexion_form.php">
        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="password">Mot de passe : </label>
        <input type="password" name="password" id="password"><br><br>

        <input type="submit" value="Se connecter" name="submit">
        <a href="inscription.php">
            <p>S'inscrire</p>
        </a>
    </form>

</div>

<?php include_once('footer.php'); ?>