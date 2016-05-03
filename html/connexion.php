<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikynov','root','');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> WIKYNOV </title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<form class="formulaire" action="" method="post">
    <input type="text" name="identifiantConnexion" placeholder="Identifiant" required="required" style="text-align: center"/>
    <input type="password" name="mdpConnexion" placeholder="Mot de passe" required="required" style="text-align: center"/>
    <button type="submit" class="button-enter" name="formConnexion">Entrer</button>
</form>
<?php

if(isset($_POST['formConnexion']))
{
    $identifiantConnexion = htmlspecialchars($_POST['identifiantConnexion']);
    $mdpConnexion = sha1($_POST['mdpConnexion']);
    if(!empty($identifiantConnexion) AND !empty($mdpConnexion))
    {
        $requser = $bdd->prepare("SELECT  * FROM membres WHERE pseudo = ? AND motdepasse = ?");
        $requser->execute(array($identifiantConnexion, $mdpConnexion)) ;
        $userexist = $requser -> rowCount();
        if ($userexist == 1)
        {
            $userinfo = $requser -> fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['identifiant'] = $userinfo['identifiant'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: load.php?id=".$_SESSION['id']);
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

</body>
</html>

