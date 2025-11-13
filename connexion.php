<?php
    include 'model.php';

    /* EDIT *********************** */
    if (isset($_GET['action'])){session_destroy(); session_start(); $logoutMsg = "Vous avez été déconnecté !";}

    $loginMsg = login();
    $msg = $loginMsg ?: $logoutMsg ?? "";
    /*_ *************************** */
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <title>Connexion</title>
    </head>

    <body>
        <!-- ADD *************************** -->
        <?php if($msg) { ?>
            <div class='log-info'>
                <embed type="image/svg+xml" src="img/log-info-icon.svg"/>
                <p> <?= $msg ?> </p>
            </div>
        <?php } ?>
        <!-- ******************************* -->

        <div id="container">
            <form action="connexion.php" method="POST">
                <h1>Connexion</h1>

                <label for="pseudo" >Pseudo : </label>
                <input type="text" name='pseudo' placeholder="Entrer un pseudonyme" required>


                <label for="pass">mot de passe :</label>
                <input type="password" name="pass" placeholder="Entrer votre mot de passe" required>

                <input type="submit" value="login">
                <div class="noaccount">Vous n'avez pas de compte ? Inscrivez-vous <a href="inscription.php">ici</a>.</div>

            </form>
        </div>
    </body>
</html>