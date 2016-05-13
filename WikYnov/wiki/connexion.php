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
        <form class="formulaire" action="" method="post">
            <h1>Connexion</h1>
            <br><input class="formu" type="text" name="mailConnexion" value="<?php if(isset($_POST['mailConnexion'])) { echo htmlentities($_POST['mailConnexion']);}?>" placeholder="Adresse Mail" required="required" style="text-align: center"/><br>
            <input class="formu" type="password" name="mdpConnexion" placeholder="Mot de passe" required="required" style="text-align: center"/><br>
            <label>
                <input type="radio" name="robot" id="robot" value="2"> Je ne suis pas un robot
            </label><br>
            <button type="submit" class="button" name="formConnexion">Entrer</button>
        </form>
        <?php
        if(isset($_POST['formConnexion']))
        {
            $mailConnexion = htmlspecialchars($_POST['mailConnexion']);
            $salt = 'phoenix2429';
            $salt2 = '411salt';
            $mdpConnexion = sha1($salt.($_POST['mdpConnexion']).$salt2);
            if(!empty($mailConnexion) AND !empty($mdpConnexion) AND !empty($_POST['robot']))
            {
                $requser = $bdd->prepare("SELECT * FROM coordonnees WHERE mail = ? AND mdp = ?");
                $requser->execute(array($mailConnexion, $mdpConnexion)) ;
                $userexist = $requser->rowCount();
                if ($userexist == 1)
                {
                        $userinfo = $requser->fetch();
                        $_SESSION['session']['id'] = $userinfo['id'];
                        $_SESSION['session']['identifiant'] = $userinfo['identifiant'];
                        $_SESSION['session']['nom'] = $userinfo['nom'];
                        $_SESSION['session']['mail'] = $userinfo['mail'];
                        $_SESSION['session']['role'] = $userinfo['role'];
                        $_SESSION['session']['ip'] = $_SESSION['REMOTE_ADDR'];
                        header("Location: actualites.php");

                }
                else
                {
                    ?> <div class="erreur"><?php echo'Mauvais adresse mail ou mot de passe !';?> </div> <?php
                }
            }
            else
            {
                ?> <div class="erreur"><?php echo'Tous les champs doivent être complétés !';?> </div> <?php
            }
        }
        ?>
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


