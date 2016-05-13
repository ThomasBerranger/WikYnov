<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikiynov','root','');
if(!isset($_SESSION['session']))
{
    header("Location: index.php");
}

include_once 'function/addSujet.class.php';

if(isset($_POST['name']) AND isset($_POST['sujet'])){

    $addSujet = new addSujet($_POST['name'],$_POST['sujet'],$_POST['categories']);
    $verif = $addSujet->verif();
    if($verif == "ok"){
        if($addSujet->insert()){
            header('Location: index.php?sujet='.$_POST['name']);
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
<h1>Ajouter un sujet</h1>

<div id="Cforum">

    <form method="post" action="addSujet.php?categories=<?php echo $_GET['categories']; ?>">
        <p>
            <br><input type="text" name="name" placeholder="Nom du sujet..." required/><br>
            <textarea name="sujet" placeholder="Contenu du sujet..."></textarea><br>
            <input type="hidden" value="<?php echo $_GET['categories']; ?>" name="categories" />
            <input type="submit" value="Ajouter le sujet" />
            <?php
            if(isset($erreur)){
                echo $erreur;
            }
            ?>
        </p>
    </form>
</div>
</body>
</html>
