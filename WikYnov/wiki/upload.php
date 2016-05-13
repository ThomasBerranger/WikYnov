<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikiynov','root','');

$dossier = 'upload/';
$fichier = basename($_FILES['avatar']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['avatar']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg','.txt','.doc','.docx','.rtf','.mp3','.pdf');
$extension = strrchr($_FILES['avatar']['name'], '.');

/*$_mime = array ("application/x-gzip-compressed",
    "application/x-zip-compressed" ,
    "image/bmp",
    "image/gif",
    "image/pjpeg",
    "image/jpeg",
    "text/plain",s
    "application/pdf",
    "audio/mpeg3",
    "audio/x-mpeg3",
    "audio/mp3",);
if(!in_array())
{
    echo 'Upload effectué avec succès !';
}
else
{
    $_erreur = "type mime incorrect";
}*/

/*$type_file = $_FILES['avatar']['type'];
$allowed_types_files = array(
    "application/x-gzip-compressed",
    "application/x-zip-compressed" ,
    "image/bmp",
    "image/gif",
    "image/pjpeg",
    "image/jpeg",
    "text/plain",
    "application/pdf",
    "audio/mpeg3",
    "audio/x-mpeg3",
    "audio/mp3",
);*/
/*$file = array("application/x-gzip-compressed",
    "application/x-zip-compressed" ,
    "image/bmp",
    "image/gif",
    "image/pjpeg",
    "image/jpeg",
    "text/plain",
    "application/pdf",
    "audio/mpeg3",
    "audio/x-mpeg3",
    "audio/mp3",);
$finfo = finfo_open();
$fileinfo = finfo_file($finfo, $file, FILEINFO_MIME);
finfo_close($finfo);
if (in_array($extension,$file))
     {
    //Format invalide.
    die ('type mime incorrect');
}

$finfo = finfo_open();


$fileinfo = finfo_file($finfo, $file, FILEINFO_MIME);

finfo_close($finfo);*/

/*$finfo = finfo_open(FILEINFO_MIME_TYPE);
$finfo = finfo_file($finfo, $_FILES['avatar']['tmp_name']);
finfo_close($finfo);


if (!in_array($finfo, array(
    "application/x-gzip-compressed",
    "application/x-zip-compressed" ,
    "image/bmp",
    "image/gif",
    "image/pjpeg",
    "image/jpeg",
    "text/plain",
    "application/pdf",
    "audio/mpeg3",
    "audio/x-mpeg3",
    "audio/mp3",))) {
    //Format invalide.
    die ('type mime incorrect');
}*/

//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}

/*if (!in_array($_FILES['avatar']['type'], $allowed_types_files)){
    die ('type mime incorrect');
}*/
if($taille>$taille_maxi)
{
    $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
    //On formate le nom du fichier ici...
    $fichier = strtr($fichier,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {
        echo 'Upload effectué avec succès !';
        $sql = "INSERT INTO upload (avatar) VALUES (:avatar)";
        $stmt = $bdd->prepare($sql);
        //Bind value.
        $stmt->bindValue(':avatar', $fichier);
        //Execute.
        $stmt->execute();
        //Fetch row.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        //If $row is FALSE.

    }
    else //Sinon (la fonction renvoie FALSE).
    {
        echo 'Echec de l\'upload !';
    }
}
else
{
    echo $erreur;
}