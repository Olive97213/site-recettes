<?php include_once('header.php'); 

require_once "db.php";



$message = isset($_GET['message']) ? $_GET['message'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : false;

// Afficher le message dans le HTML
?>
<link rel="stylesheet" href="link/inscription.css">


<div class="inscription">
    <h2>Inscription</h2>
     
    <?php if (!empty($message)): ?>
    <div class="alert alert-danger">
        <p>Vous n'avez pas rempli le formulaire correctement:</p>

        <ul>
            <?php foreach(explode(',', $message) as $error): ?>
            <li>
                <?= $error; ?>
            </li>
            
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if ($success): ?>
    <div class="alert alert-success">
        <p>Votre compte a bien été créé merci de confirmer votre inscription avec le lien reçu sur votre boite mail.</p>
    </div>
    <?php endif; ?>
    
    
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