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
<form class="formulaire" action="" method="post">
    <input type="text" name="identifiantConnexion" placeholder="Identifiant" required="required" style="text-align: center"/>
    <input type="password" name="mdpConnexion" placeholder="Mot de passe" required="required" style="text-align: center"/>
    <button type="submit" class="button-enter" name="formConnexion">Entrer</button>
    <button><a href="inscription.php">inscrip</a></button>
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
            header("Location: conexion.php?id=".$_SESSION['id']);
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


<?php
/*
require 'models/User.php';
$user = new User();
$user->setName('Ducerf')
    ->setFirstName('Alexis')
    ->setPassword('toto')
    ->setEmail('alexis.ducerf@deercoders.com');
echo '<pre>';
var_dump($user);
echo '</pre>';
$user2 = new User(null, 'Ducerf', 'Alexis', 'toto','alexis.ducerf@deercoders.com');
echo '<pre>';
var_dump($user2);
echo '</pre>';
*/

//$u = new Users();
//$u->view(2);
