<?php 
    include 'model.php';

    if( !isset($_SESSION[Session::UserID])) header('Location: connexion.php');
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <link type="text/css" rel="stylesheet" href="css/disques.css">
        <title>Magasin de disques</title>
    </head>

    <body onload="ajouterOnClick()">

        <input type="button" name="button" onclick="window.location='connexion.php?action=logout'" value="Déconnexion">
        <input type="button" name="button" onclick="window.location='user'" value="Mes commandes">

        <div id="titre">
            <h1>Magasin de disques</h1>
            Tous les disques à 7€50!!!<br/>
            cliquez sur l'image pour (dé)sélectionner un album<br/>
            Montant du panier : <span id="panier"> 0 €</span>
        </div>

        <div id="deplacement">
            <div id="source">
                <h3>Albums disponibles</h3>

                <img src="img/banana.jpg" alt="banana" width="30" />
                <img src="img/law.jpg" alt="law" width="30" />
                <img src="img/party.jpg" alt="party" width="30" />
                <img src="img/superfreak.jpg" alt="superfreak" width="30" />
                <img src="img/time.jpg" alt="time" width="30"/>
                <img src="img/zeng.jpg" alt="zeng" width="30"/>
            </div>

            <div id="destination">
                <h3>Albums choisis</h3>
            </div>
        </div>

        <form id="form" name="delivery" method="POST" action="confirmation.php" onsubmit="submitForm()">
            <fieldset><legend>Validation de la commande</legend>
                <div>
                    <label>Civilité :</label>
                    Mme :<input type="radio" name="sexe" value="Mme">
                    Mlle :<input type="radio" name="sexe" value="Mlle">
                    Mr :<input type="radio" name="sexe" value="Mr">
                </div> <br>

                <div>
                    <label>Nom :</label>
                    <input type="text" name="nom"> 
                </div> <br>
                
                <div>
                    <label>Prénom :</label>
                    <input type="text" name="prenom"> 
                </div> <br>

                <div>
                    <label>Date de naissance :</label>
                    <select name="liste_numerique">
                    <?php
                        for ($i = 1900; $i <= 2021; $i++){
                            echo '<option value="'.$i.'" name="date">'.$i.'</option>';
                        }
                    ?>
                    </select>
                </div> <br />

                <input id="address-mailing" type="checkbox" name="facturation" value="Oui"/> <label> L'adresse de facturation est la même que l'adresse de livraison </label><br>
                <div class="flex-container addresses">
                    <div class="adresse">
                        <fieldset><legend>Adresse de livraison</legend>
                            <table>
                                <tr>
                                    <div>
                                        <td><label>Adresse :</label></td>
                                        <td><input type="text" name="adresseliv"></td>
                                    </div>
                                </tr>
                                <tr>
                                    <div>
                                        <td><label>Ville :</label></td>
                                        <td><input type="text" name="villeliv"></td>
                                    </div>
                                </tr>
                                <tr>
                                    <div>
                                        <td><label>Code postal :</label></td>
                                        <td><input type="text" name="codepostalliv"></td>
                                    </div>
                                </tr>
                            </table>
                        </fieldset>
                    </div>
                    <div id="mailing" class="adresse">
                        <fieldset><legend>Adresse de facturation</legend>
                            <table>
                                    <tr>
                                        <div>
                                            <td><label>Adresse :</label></td>
                                            <td><input type="text" name="adressefac"></td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div>
                                            <td><label>Ville :</label></td>
                                            <td><input type="text" name="villefac"></td>
                                        </div>
                                        
                                    </tr>
                                    <tr>
                                        <div>
                                            <td><label>Code postal :</label></td>
                                            <td><input type="text" name="codepostalfac"></td>
                                        </div>
                                    </tr>
                            </table>
                        </fieldset>
                    </div>
                </div>

                <div>
                    <input id="newsletter" type="checkbox" name="newsletter" value="Oui"/> <label> Voulez-vous vous abonner à la newsletter </label>
                    <label id="newsletter-mail">Mail : <input id="newsletter-mail" type="email" name="mail" /></label>
                </div><br>

                <input type="hidden" id="cmdisques" name="cmdisques"/>
                
            <input type="submit" value="Confirmer la commande">
            <input type="reset" value="Annuler">
            </fieldset>
        </form>

        <script type="text/javascript" src="disques.js" ></script>

    </body>
</html>
