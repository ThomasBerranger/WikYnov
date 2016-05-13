<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikiynov','root','');
if(!isset($_SESSION['session']))
{
    header("Location: index.php");
}

?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>WikYnov</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img class="image-nav" src="images/logo.png" alt=""></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="actualites.php"> Actualités </a></li>
                    <li><a href="multimedia.php"> Multimédia </a></li>
                    <li><a href="devoirs.php"> Forum/Devoirs </a></li>
                    <li><a href="thematique.php"> Thématiques </a></li>
                    <li class="active"><a href="profil.php"> Profil <span class="sr-only">(current)</span></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" target="_blank" data-toggle="modal" data-target="#myModal">Déconnexion</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!--Apparition du bouton pour se déconnecter -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">  <!-- Contenue dans l'entete -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h1 class="modal-title" id="myModalLabel">Êtes-vous sûre de vouloir vous déconnecter ?</h1>
                    <!-- Contenue dans le corps -->
                </div>
                <div class="modal-footer">
                    <a href="index.php"><button type="button" class="btngreen">Oui</button></a>
                    <button type="button" class="btnred" data-dismiss="modal">Non</button>
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <?php
    if(isset($_SESSION['session']['id']))
    {
        if (isset($_POST['newAdmin']) AND !empty($_POST['newAdmin'])) {
            $reqmail = $bdd->prepare("SELECT * FROM coordonnees WHERE mail = ?");
            $reqmail->execute(array($_POST['newAdmin']));
            $newAdminexist = $reqmail->rowCount();
            if ($newAdminexist == 1) {
                $newRole = 2;
                $newAdmin = htmlspecialchars($_POST['newAdmin']);
                $insertrole = $bdd->prepare("UPDATE coordonnees SET role = ? WHERE mail = ?");
                $insertrole->execute(array($newRole, $newAdmin));

            } else {
                ?>
                <div class="erreur"><?php echo 'Cette adresse mail n\'existe pas !'; ?> </div> <?php
            }
        }

        $requser = $bdd->prepare("SELECT * FROM coordonnees WHERE id = ?");
        $requser->execute(array($_SESSION['session']['id']));
        $user = $requser->fetch();

        if(isset($_POST['newIdentifiant']) AND !empty($_POST['newIdentifiant']) AND $_POST['newIdentifiant'] != $user['identifiant'])
        {
            $newIdentifiant = htmlspecialchars($_POST['newIdentifiant']);
            $newIdentifiantlength = strlen($newIdentifiant);
            if($newIdentifiantlength <= 50) {
                $insertidentifiant = $bdd->prepare("UPDATE coordonnees SET identifiant = ? WHERE id = ?");
                $insertidentifiant->execute(array($newIdentifiant, $_SESSION['session']['id']));
            } else {
                ?> <div class="erreur"><?php echo'Votre nouveau prénom ne doit pas dépasser les 50 caractères !';?> </div> <?php
            }
        }

        if(isset($_POST['newNom']) AND !empty($_POST['newNom']) AND $_POST['newNom'] != $user['nom'])
        {
            $newNom = htmlspecialchars($_POST['newNom']);
            $newNomlength = strlen($newNom);
            if($newNomlength <= 50) {
                $insertnom = $bdd->prepare("UPDATE coordonnees SET nom = ? WHERE id = ?");
                $insertnom->execute(array($newNom, $_SESSION['session']['id']));
            } else {
                ?> <div class="erreur"><?php echo'Votre nouveau nom ne doit pas dépasser les 50 caractères !';?> </div> <?php
            }
        }

        if(isset($_POST['ancienMdp']) AND !empty($_POST['ancienMdp']))
        {
            $ancienMdp = ($_POST['ancienMdp']);
            $newMdp = ($_POST['newMdp']);
            $mdp = $user['mdp'];
            $salt = 'phoenix2429';
            $salt2 = '411salt';
            $ancienMdp = sha1($salt.($_POST['ancienMdp']).$salt2);
            $newMdplength = strlen($newMdp);
            if($ancienMdp == $mdp)
            {
                if(isset($_POST['newMdp']) AND isset($_POST['newMdp2']) AND !empty($_POST['newMdp']) AND !empty($_POST['newMdp2']))
                {
                    if($newMdplength <= 25)
                    {
                        $newMdp = sha1($salt.($_POST['newMdp']).$salt2);
                        $newMdp2 = sha1($salt.($_POST['newMdp2']).$salt2);

                        if($newMdp == $newMdp2)
                        {
                            $insertmdp = $bdd->prepare("UPDATE coordonnees SET mdp = ? WHERE id = ?");
                            $insertmdp->execute(array($newMdp, $_SESSION['session']['id']));

                        } else {
                            ?> <div class="erreur"><?php echo'Vos mots de passe ne sont pas identiques !';?> </div> <?php
                        }
                    } else {
                        ?> <div class="erreur"><?php echo'Votre nouveau mot de passe ne doit pas dépasser les 25 caractères !';?> </div> <?php
                    }
                } else {
                    ?> <div class="erreur"><?php echo'Tous les champs doivent être complétés !';?> </div> <?php
                }
            } else {
                ?> <div class="erreur"><?php echo'Mauvais Mot de Passe !';?> </div> <?php
            }

        }

        ?>
        <div class="row">
            <div align="center">
                <div class="col-md-6">
                    <h1> Votre Profil :</h1>
                    <div class="profil" align="left">
                        <div class="pro"> Votre prénom : <?php echo $_SESSION['session']['identifiant'];?> </div>
                        <div class="pro"> Votre nom : <?php echo $_SESSION['session']['nom'];?> </div>
                        <div class="pro"> Votre adresse mail : <?php echo $_SESSION['session']['mail'];?> </div>
                        <div class="pro"> (Vous ne pouvez pas modifier votre adresse mail !) </div>
                    </div>
                    <br>
        <?php
            if($_SESSION['session']['role'] == 2) {
                ?>
                <form action="" class="formulaire" method="post">
                    <h1>Ajouter un Administrateur :</h1>
                    <input type="text" class="formu" id="newAdmin" name="newAdmin" placeholder="Adresse Mail du Nouvel Administrateur" style="text-align:center">
                    <input class="button" type="submit" value="Ajouter">
                </form>
        <?php
            }
        ?>

                </div>

                <div class="col-md-6">
                    <h1>Editer mon profil : </h1> <br><br>
                    <form action="" class="formulaire" method="post">
                        <label>Nouveau Prénom</label>
                        <input type="text" class="formu" id="newIdentifiant" name="newIdentifiant" value="<?php echo $user['identifiant']; ?>" placeholder="Nouveau Prénom" style="text-align:center"><br>
                        <label>Nouveau Nom</label>
                        <input type="text" class="formu" id="newNom" name="newNom" value="<?php echo $user['nom']; ?>" placeholder="Nouveau Nom" style="text-align:center"><br>
                        <input type="password" class="formu" id="ancienMdp" name="ancienMdp" placeholder="Ancien Mot de Passe" style="text-align:center"><br>
                        <input type="password" class="formu" id="newMdp" name="newMdp" placeholder="Nouveau Mot de Passe" style="text-align:center"><br>
                        <input type="password" class="formu" id="newMdp2" name="newMdp2" placeholder="Confirmation" style="text-align:center"><br>
                        <input class="button" type="submit" value="Modifier mon Profil">
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        header("Location: connexion.php");
    }

    ?>

    </body>
    </html>