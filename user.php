<?php
    include 'model.php';
    if(!isset($_SESSION[Session::UserID])) header('Location: connexion.php'); #forbidden page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/user.css">
    <title> Magasin des Disques | User info</title>
</head>
<body>
    <div id="commands-container">
        <h1> Vos commandes </h1>
        <ul>
            <?php foreach(getCommands($_SESSION[Session::UserID]) as $id => $command): ?>
                <li> 
                    <div class="commands">
                        <p> Numéro de commande : <?= $id ?>
                        <table>
                        <?php foreach($command as $subcommand): ?>
                            <tr>
                                <td>
                                    <p class="title"> Titre : <span><?= $subcommand['title'] ?></span> </p>
                                </td>
                                <td>
                                    <p class="price"> prix : <span><?= $subcommand['price'] ?>€</span> </p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <input type="button" onclick="window.location='disques.php'" value="Accueil">

</body>
</html>



    