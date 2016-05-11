<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikiynov','root','');
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
<img src="images/ecole.jpg" class="img-fond" alt="">
<div class="container">
    <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <form action="" class="formulaire" method="post">
                <h1>Inscription</h1>
                <input class="formu" type="text" name="identifiant" value="<?php if(isset($_POST['identifiant'])) { echo htmlentities($_POST['identifiant']);}?>" id="identifiant" placeholder="Prénom" required="required" style="text-align:center"/><br>
                <input class="formu" type="text" name="nom" value="<?php if(isset($_POST['nom'])) { echo htmlentities($_POST['nom']);}?>" id="nom" placeholder="Nom" required="required" style="text-align:center" /><br>
                <input class="formu" type="text" name="mail" value="<?php if(isset($_POST['mail'])) { echo htmlentities($_POST['mail']);}?>" id="mail" placeholder="Email" required="required" style="text-align:center"/><br>
                <input class="formu" type="password" name="mdp" id="mdp" placeholder="Mot de passe" required="required" style="text-align:center"/><br>
                <input class="formu" type="password" id="mdp2" name="mdp2" placeholder="Confirmation" required="required" style="text-align:center"/><br>
                <label>
                    <input type="radio" name="role" id="role0" value="0"> Je suis actuellement étudiant(e) à Ynov
                </label> <br>
                <label>
                    <input type="radio" name="role" id="role1" value="1" checked> Je suis un(e) ancien(ne) étudiant(e) d'Ynov
                </label> <br>
                <button type="submit" class="button" name="formInscription">Je m'inscris</button>
            </form>
            <?php

            if(!empty($_POST['identifiant']) AND !empty($_POST['nom']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
            {
                $identifiant = htmlspecialchars($_POST['identifiant']);
                $nom = htmlspecialchars($_POST['nom']);
                $mail = htmlspecialchars($_POST['mail']);
                $role = ($_POST['role']);
                $mdp = ($_POST['mdp']);
                $mdp2 = ($_POST['mdp2']);
                $identifiantlength = strlen($identifiant);
                $nomlength = strlen($nom);
                $maillength = strlen($mail);
                $mdplength= strlen($mdp);

                if($identifiantlength <= 50)
                {
                    if($nomlength <= 50)
                    {
                        if($maillength <= 50)
                        {
                            $syntaxe="#^[a-zA-Z]+[-]?[a-zA-Z]+[.][a-zA-Z]+[-]?[a-zA-Z]+@ynov[.]com$#";
                            if(preg_match($syntaxe, $mail))
                            {
                                $reqmail = $bdd->prepare("SELECT * FROM coordonnees WHERE mail = ?");
                                $reqmail->execute(array($mail));
                                $mailexist = $reqmail->rowCount();

                                if($mailexist == 0)
                                {
                                    if($mdplength <= 25)
                                    {
                                        $salt = 'phoenix2429';
                                        $salt2 = '411salt';
                                        $mdp = sha1($salt.($_POST['mdp']).$salt2);
                                        $mdp2 = sha1($salt.($_POST['mdp2']).$salt2);

                                        if($mdp == $mdp2)
                                        {
                                            $insertmbr = $bdd->prepare("INSERT INTO coordonnees(identifiant, nom, mail, role, mdp) VALUES(?,?,?,?,?)");
                                            $insertmbr -> execute(array($identifiant, $nom, $mail,$role, $mdp));
                                            //$_SESSION['membrecree'] = "Votre inscription a bien été effectuée";
                                            header('Location: connexion.php');

                                        } else {
                                            ?> <div class="erreur"><?php echo'Vos mots de passe ne sont pas identiques !';?> </div> <?php
                                        }
                                    } else {
                                        ?> <div class="erreur"><?php echo'Votre mot de passe ne doit pas dépasser les 25 caractères !';?> </div> <?php
                                    }
                                } else {
                                    ?> <div class="erreur"><?php echo'Cette adresse mail est déja utilisée !';?> </div> <?php
                                }
                            } else {
                                ?> <div class="erreur"><?php echo'Votre adresse mail ne correspond pas !';?> </div> <?php
                            }
                        } else {
                            ?> <div class="erreur"><?php echo'Votre adresse mail ne doit pas dépasser les 50 caractères !';?> </div> <?php
                        }
                    } else {
                        ?> <div class="erreur"><?php echo'Votre nom ne doit pas dépasser les 50 caractères !';?> </div> <?php
                    }
                } else {
                    ?> <div class="erreur"><?php echo'Votre identifiant ne doit pas dépasser les 50 caractères !';?> </div> <?php
                }
            } else {
                ?> <div class="erreur"><?php echo'Tous les champs doivent être complétés';?> </div> <?php
            }

            ?>
            <a href="connexion.php"><button class="button" name=""> Se Connecter </button></a>
        </div>
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