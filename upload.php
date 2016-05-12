<?php
session_start();
/*var_dump($_POST);*/



$bdd = new PDO ('mysql:host=localhost;dbname=upload', 'root', '');



$dossier = 'upload' . DIRECTORY_SEPARATOR;
$fichier = basename($_FILES['avatar']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['avatar']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.txt', '.doc', '.mp3', '.pdf');
$extension = strrchr($_FILES['avatar']['name'], '.');

/*var_dump($_FILES);*/




$mime = ["application/x-gzip-compressed",
    "application/x-zip-compressed",
    "image/bmp",
    "image/gif",
    "image/pjpeg",
    "image/jpeg",
    "text/plain",
    "application/pdf",
    "audio/mpeg3",
    "audio/x-mpeg3",
    "audio/mp3"];


$completePath = __DIR__ . DIRECTORY_SEPARATOR . $dossier . $fichier;


if (file_exists($completePath)) {

    $finfo = new finfo(FILEINFO_MIME);
    $fileinfo = $finfo->file($completePath, FILEINFO_MIME_TYPE);

    if (!in_array($fileinfo, $mime)) {
        //Format invalide.
        echo 'type mime incorrect';
    } else {
        echo 'good';
    }

}




//Début des vérifications de sécurité...
if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}


if ($taille > $taille_maxi) {
    $erreur = 'Le fichier est trop gros...';
}
if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
    //On formate le nom du fichier ici...
    $fichier = strtr($fichier,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {


        echo 'Upload effectué avec succès !';


        $sql = "INSERT INTO upload (avatar) VALUES (:avatar)";
        $stmt = $bdd->prepare($sql);
        //Bind value.
        $stmt->bindValue(':avatar', $fichier);
        //Execute.
        $stmt->execute();
        //Fetch row.
        /*$user = $stmt->fetch(PDO::FETCH_ASSOC);*/
        //If $row is FALSE.


    } else //Sinon (la fonction renvoie FALSE).
    {
        echo 'Echec de l\'upload !';
    }
} else {
    echo $erreur;
}


/*if (isset($_POST['envoyer']) && !empty($_POST['editor1'])) {


    $editor1 = $_POST['editor1'];
    $sql = "INSERT INTO upload (editor1) VALUES (:editor1)";
    $stmt = $bdd->prepare($sql);
    //Bind value.
    $stmt->bindValue(':avatar', $fichier);
    //Execute.
    $stmt->execute();
    //Fetch row.
    /*$user = $stmt->fetch(PDO::FETCH_ASSOC);
    //If $row is FALSE.


}*/

?>
