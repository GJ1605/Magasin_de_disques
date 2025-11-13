<?php
    include "model.php";

    if ($_SERVER['REQUEST_METHOD'] != "POST")  {
        # TODO:
        if (!isset($_SESSION[Session::UserID])) {
            #TODO: not logged
            if( !isset($_POST['cmdisques'])) {
                #TODO: no disc to buy
            }
        }
    }

    registerCommand( explode('|', $_POST['cmdisques']));
?>


<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <link type="text/css" rel="stylesheet" href="css/disques.css">
        <title>Magasin de disques</title>
    </head>
    
    <body>
        <input type="button" name="button" onclick="window.location='user'" value="Mes Commandes">

        <center><h1>Confirmation de votre commande</h1></center>
        <center><img src="img/suivi.png" alt="Problème" id="suivi"/></center><br><br>
        <div id="presentation">
            <?php 
                $civilite=trim($_POST['sexe']);
                $nom=trim($_POST['nom']);
                $prenom=trim($_POST['prenom']);
                echo "<div id='bonjour'>Bonjour ".$civilite." ".$nom." ".$prenom." !</div><br>";
                echo "Votre commande passée le ".date('j/m/Y')." à ".date('G:i')." a bien été enregistrée. "; 
                echo "Elle est en cours de préparation dans nos entrepôts, votre colis sera livré <strong>dans 5 à 7 jours ouvrés</strong>. ";
                echo "Nous vous adressons ci-dessous le récapitulatif de votre commande ainsi que le numéro de suivi de votre colis.<br>";
                echo "<br>Merci pour votre fidélité !<br><br>";

                if (isset($_POST['newsletter'])){
                    $mail=trim($_POST['mail']);
                    echo "<div id='textenewsletter'>Nous vous remercions de vous être inscrit à notre newsletter, vous recevrez toutes nos nouveautés à l'adresse suivante : ".$mail.".</div><br><br>";
                }

                if (isset($_POST['facturation'])) {
                    $adresse=trim($_POST['adresseliv']); 
                    $ville=trim($_POST['villeliv']); 
                    $code=trim($_POST['codepostalliv']);
                    echo "<strong>Adresse de livraison et de facturation :</strong> <br>".$adresse.",<br>".$code.", ".$ville.".<br><br>";
                }
                else {
                    $adresseliv=trim($_POST['adresseliv']); 
                    $villeliv=trim($_POST['villeliv']); 
                    $codeliv=trim($_POST['codepostalliv']);
                    $adressefac=trim($_POST['adressefac']); 
                    $villefac=trim($_POST['villefac']); 
                    $codefac=trim($_POST['codepostalfac']);
                
                    echo "<table><tr><td class='tdadresse'><strong>Adresse de livraison</strong></td><td class='tdadresse'><strong>Adresse de facturation</strong></td></tr><tr><td class='tdadresse'>".$adresseliv.",</td><td class='tdadresse'>".$adressefac.",</td></tr><tr><td class='tdadresse'>".$codeliv.", ".$villeliv."</td><td class='tdadresse'>".$codefac.", ".$villefac."</td></tr></table>";
                }
            ?>
        </div>

        <?php
            if (!empty($_POST['cmdisques'])) {
        ?>
            <div id="cmd">
                <h3 id="albumscmd">Albums commandés</h3>
                <table id="confirmcmd">
                    <thead>
                        <th class="categorie">Article</th>
                        <th class="categorie">Prix</th>
                    <thead>
                    <tbody>
                    <?php
                        $disques = explode("|", $_POST['cmdisques']);
                        foreach ($disques as $disq) {
                            echo '<tr><td class="article">'.$disq.'<br><img src="img/'.$disq.'.jpg" alt="'.$disq.'" width="30" /></td><td class="articleprix"> 7.50€ </td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            $total = (sizeof($disques)*7.5);
            echo "<center>Montant total du panier : ".$total." €</center>";
            }
            ?>
    </body>
</html>