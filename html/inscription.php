<?php
$bdd = new PDO ('mysql:host=localhost;dbname=wikynov','root','');

?>

    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title> WIKYNOV </title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <form action="" class="formulaire" method="post">
        <input type="text" name="identifiant" id="identifiant" placeholder="Prénom" required="required" style="text-align:center"/>
        <input type="text" name="nom" id="nom" placeholder="Nom" required="required" style="text-align:center" />
        <input type="email" name="mail" id="mail" placeholder="Email" required="required" style="text-align:center"/>
        <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required="required" style="text-align:center"/>
        <input type="password" id="mdp2" name="mdp2" placeholder="Confirmation" required="required" style="text-align:center"/>
        <button type="submit" class="button" name="formInscription">Je m'inscris</button>
    </form>
    </body>
    </html>

<?php

if(!empty($_POST['identifiant']) AND !empty($_POST['nom']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
{
    $identifiant = htmlspecialchars($_POST['identifiant']);
    $mail = htmlspecialchars($_POST['mail']);
    $nom = htmlspecialchars($_POST['nom']);
    $salt = 'phoenix2429';
    $salt2 = '411salt';
    $mdp = sha1($salt.($_POST['mdp']).$salt2);
    $mdp2 = sha1($salt.($_POST['mdp2']).$salt2);
    $identifiantlength = strlen($identifiant);
    if($identifiantlength <= 50 )
    {
        if($mdp == $mdp2)
        {
            $insertmbr = $bdd->prepare("INSERT INTO coordonnees(identifiant, nom, mail, mdp) VALUES (?,?,?,?)");
            $insertmbr -> execute(array($identifiant, $nom, $mail, $mdp));
            header("Location: index.php");

        }
        else
        {
            ?> <div class="erreur"><?php echo'Vos mots de passe ne sont pas identiques !';?> </div> <?php
        }
    }
    else
    {
        ?> <div class="erreur"><?php echo'Votre pseudo ne doit pas dépasser les 50 caractères !';?> </div> <?php
    }
}