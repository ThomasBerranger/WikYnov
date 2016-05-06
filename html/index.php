<?php
session_start();
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
<img class="image" src="images/logo.png" alt="">

<div class="row">
    <div class="col-md-6">
        <form action="" class="formulaire" method="post">
            <h2>Inscription</h2>
            <br><input class="formu" type="text" name="identifiant" id="identifiant" placeholder="Prénom" required="required" style="text-align:center"/><br>
            <input class="formu" type="text" name="nom" id="nom" placeholder="Nom" required="required" style="text-align:center" /><br>
            <input class="formu" type="email" name="mail" id="mail" placeholder="Email" required="required" style="text-align:center"/><br>
            <input class="formu" type="password" name="mdp" id="mdp" placeholder="Mot de passe" required="required" style="text-align:center"/><br>
            <input class="formu" type="password" id="mdp2" name="mdp2" placeholder="Confirmation" required="required" style="text-align:center"/><br><br>
            <label>
                <input type="radio" name="choice" value="1" checked> Je suis actuellement étudiant à Ynov
            </label> <br>
            <label>
                <input type="radio" name="choice" value="2"> Je suis un ancien étudiant d'Ynov
            </label> <br>
            <button type="submit" class="button" name="formInscription">Je m'inscris</button>
        </form>
        <br><br>
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
                header("Location: connexion.php?id=".$_SESSION['id']);
                ?> <div class="erreur"><?php echo'Votre inscription a bien été enregistrée';?> </div> <?php

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
    ?>
    </div>

    <div class="col-md-6">
        <form class="formulaire" action="" method="post">
            <h2>Connexion</h2>
            <br><input class="formu" type="text" name="identifiantConnexion" placeholder="Adresse mail" required="required" style="text-align: center"/><br>
            <input class="formu" type="password" name="mdpConnexion" placeholder="Mot de passe" required="required" style="text-align: center"/><br>
            <button type="submit" class="button" name="formConnexion">Entrer</button>
        </form>
        <?php
        if(isset($_POST['formConnexion']))
        {
            $identifiantConnexion = htmlspecialchars($_POST['identifiantConnexion']);
            $salt = 'phoenix2429';
            $salt2 = '411salt';
            $mdpConnexion = sha1($salt.($_POST['mdpConnexion']).$salt2);
            if(!empty($identifiantConnexion) AND !empty($mdpConnexion))
            {
                $requser = $bdd->prepare("SELECT * FROM coordonnees WHERE identifiant = ? AND mdp = ?");
                $requser->execute(array($identifiantConnexion, $mdpConnexion)) ;
                $userexist = $requser -> rowCount();
                if ($userexist == 1)
                {
                    $userinfo = $requser -> fetch();
                    $_SESSION['id'] = $userinfo['id'];
                    $_SESSION['identifiant'] = $userinfo['identifiant'];
                    $_SESSION['mail'] = $userinfo['mail'];
                    header("Location: connexion.php?id=".$_SESSION['id']);
                }
                else
                {
                    ?> <div class="erreur"><?php echo'Mauvais identifiant ou mot de passe !';?> </div> <?php
                }
            }
            else
            {
                $erreur = "Tous les champs doivent être complétés !";
            }
        }
        ?>
    </div>
</div>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</body>
</html>

