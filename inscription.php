<?php
    include 'model.php';
    /* EDIT ************************** */
    $msg = register() ?? "";
    /*_ ****************************** */
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <title>Inscription</title>
    </head>

    <body>
        <!-- ADD *************************** -->
        <?php if($msg) { ?>
            <div class='log-info'>
                <embed type="image/svg+xml" src="img/log-info-icon.svg"/>
                <p> <?= $msg ?> </p>
            </div>
        <?php } ?>
        <!-- ****************************** -->

        <div id="container">
            <form action="" method="POST">
                <h1>Inscription</h1>

                <label for="mail" >Mail : </label>
                <input type="text" name='mail' placeholder="Entrer un email" required>

                <label for="pseudo" >Pseudo : </label>
                <input type="text" name='pseudo' placeholder="Entrer un pseudonyme" required>


                <label for="pass">Mot de passe :</label>
                <input type="password" name="pass" placeholder="Entrer votre mot de passe" required>

                <input type="submit" value="login">

            </form>
        </div>
    </body>
</html>