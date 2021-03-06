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
        <script src="ckeditor_4.5.8_standard/ckeditor/ckeditor.js"></script>
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
                    <li class="active"><a href="thematique.php"> Thematiques <span class="sr-only">(current)</span></a></li>
                    <li><a href="profil.php"> Profil </a></li>
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

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="" class="formulaire" method="post">
                <h1>Ajouter une Thématique :</h1>
                <input type="text" class="formu" id="them" name="them" placeholder="Nom de Votre Thématique" style="text-align:center"><br>

                <textarea class="formul" name="contenu" id="contenu" placeholder="Contenu de Votre Thématique" style="text-align:center" rows="10" cols="80"></textarea> <br>

                <input class="button" type="submit" value="Ajouter">
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>


    </body>
    </html>
    <?php
    if($_SESSION['session']['role'] == 0) {
        echo 'Seuls les administrateurs peuvent ajouter des thématiques';

    } elseif($_SESSION['session']['role'] == 2) {

            if (!empty($_POST['them']) AND !empty($_POST['contenu']) ) {
                $them = htmlspecialchars($_POST['them']);
                $contenu = htmlspecialchars($_POST['contenu']);
                $insertthem = $bdd->prepare("INSERT INTO thematiques (them, contenu) VALUES(?,?)");
                $insertthem -> execute(array($them, $contenu));
                echo 'Votre nouvelle thématique a bien été ajoutée !';
            } else {
                ?> <div class="erreur"><?php echo 'Veuillez remplir tous les champs !'; ?> </div> <?php
            }

        } else {
        echo 'Vous n\êtes pas autorisé à lire ce contenu';
    }

?>