<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikiynov','root','');
include_once 'function/addPost.class.php';
if(!isset($_SESSION['session']))
{
    header("Location: index.php");
} else {
    if(isset($_POST['name']) AND isset($_POST['sujet'])){

        $addPost = new addPost($_POST['name'],$_POST['sujet']);
        $verif = $addPost->verif();
        if($verif == "ok"){
            if($addPost->insert()){
            }
        }
        else {/*Si on a une erreur*/
            $erreur = $verif;
        }

    }

    ?>

    <!DOCTYPE html>
    <head>
        <meta charset='utf-8' />
        <title>Mon super forum !</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
        <head>
    <body>
    <?php include './include/navbar.php'; ?>
    <h1><?php echo 'Bienvenue sur le forum '.$_SESSION['Pseudo'].' ! :)'?></h1>

    <div id="Cforum">
        <?php

        echo 'Bienvenue '.$_SESSION['Pseudo'].' ! :) - <a href="deconnexion.php">Deconnexion</a> ';
        if(isset($_GET['categories'])){ /*SI on est dans une categorie*/
            $_GET['categories'] = htmlspecialchars($_GET['categories']);
            ?>
            <div class="categories">
                <h1><?php echo $_GET['categories']; ?></h1>
            </div>
            <a href="addSujet.php?categories=<?php echo $_GET['categories']; ?>">Ajouter un sujet</a>
            <?php
            $requete = $bdd->prepare('SELECT * FROM sujet WHERE categories = :categories ');
            $requete->execute(array('categories'=>$_GET['categories']));
            while($reponse = $requete->fetch()){
                ?>
                <div class="categories">
                    <a href="index.php?sujet=<?php echo $reponse['name'] ?>"><h1><?php echo $reponse['name'] ?></h1></a>
                </div>
                <?php
            }
        }

        else if(isset($_GET['sujet'])){ /*SI on est dans une categorie*/
            $_GET['sujet'] = htmlspecialchars($_GET['sujet']);
            ?>
            <div class="categories">
                <h1><?php echo $_GET['sujet']; ?></h1>
            </div>

            <?php
            $requete = $bdd->prepare('SELECT * FROM postsujet WHERE sujet = :sujet ');
            $requete->execute(array('sujet'=>$_GET['sujet']));
            while($reponse = $requete->fetch()){
                ?>
                <div class="post">
                    <?php
                    $requete2 = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
                    $requete2->execute(array('id'=>$reponse['propri']));
                    $membres = $requete2->fetch();
                    echo $membres['Pseudo']; echo ': <br>';

                    echo $reponse['contenu'];
                    ?>
                </div>
                <?php

            }
            ?>

            <form method="post" action="index.php?sujet=<?php echo $_GET['sujet']; ?>">
                <textarea name="sujet" placeholder="Votre message..." ></textarea><br>
                <input type="hidden" name="name" value="<?php echo $_GET['sujet']; ?>" />
                <input type="submit" value="Ajouter à la conversation" />
                <a href="index.php">Retour</a>
                <?php
                if(isset($erreur)){
                    echo $erreur;
                }
                ?>
            </form>
            <?php
        }
        else { /*Si on est sur la page normal*/

            $requete = $bdd->query('SELECT * FROM categories');
            while($reponse = $requete->fetch()){
                ?>
                <div class="categories">
                    <a href="index.php?categories=<?php echo $reponse['name']; ?>"><?php echo $reponse['name']; ?></a>
                </div>

                <?php
            }

        }
        ?>

    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>  <!-- deux biblio-->
    <script src="js/jquery.easing.min.js"></script>
    </body>
    </html>
    <?php
}
?>
