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
                    <li class="active"><a href="#"> Multimédia <span class="sr-only">(current)</span></a></li>
                    <li><a href="devoirs.php"> Forum/Devoirs </a></li>
                    <li><a href="thematique.php"> Thématiques </a></li>
                    <li><a href="profil.php"> Profil </a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" target="_blank" data-toggle="modal" data-target="#myModal">Déconnexion</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <h1 class="h1">Espace Abonnés</h1>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> Vidéo</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> glouglouglou</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> glouglouglou</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> vidéééééo</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> glouglouglou</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> glouglouglou</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> Vidéo X</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> Mon chat</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> Film</div>
            <div class="col-sm-3 col-xs-4"><h1><i class="fa fa-play-circle" aria-hidden="true"></i></h1> <p class="nomauteur">Jean Jaque</p> Vidéo de mon petit frère qui fait un saut et tombe par terre</div>
        </div>
    </div>
    <br><br>

    <?php
    if($_SESSION['session']['role'] == 0) {
        echo 'multi auteur';
        ?>
        <h1 class="h1">Espace Auteur</h1>
        <br><br><br>
        <p class="upload"><br>Là on met le upload <br><br></p>
        <div class="footer"><br><br><br><br><br></div>
        <?php
        } elseif($_SESSION['session']['role'] == 2) {
        echo 'multi admin';
    ?>
        <h1 class="h1">Espace Auteur</h1>
        <br><br><br>
        <p class="upload"><br>Là on met le upload <br><br></p>
        <div class="footer"><br><br><br><br><br></div>
    <?php
    } else {
        echo 'multi abo';
    }
    ?>

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
                    <button type="button" class="btngreen"><a href="index.php">Oui</a></></button>
                    <button type="button" class="btnred" data-dismiss="modal">Non</button>
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>
    <div class="footer"><br><br><br><br><br></div>


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

    </body>
    </html>