<?php
session_start();
$bdd = new PDO ('mysql:host=localhost;dbname=wikynov','root','');
if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM coordonnees WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    ?>

    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title> WIKYNOV </title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque eos fugit iste laudantium,
                mollitia nihil numquam, odit officia perferendis perspiciatis reiciendis sapiente temporibus voluptatem.
                Error illo ipsum numquam quisquam! Quam.</span>
            <span>Aliquam architecto at beatae consectetur dignissimos dolorem ducimus ea eligendi enim eveniet facere facilis in ipsum iusto,
                laborum maiores nemo omnis perspiciatis quaerat quibusdam ratione repellat rerum, saepe vitae voluptate.</span>
            <span>Aliquam dignissimos error inventore modi nisi placeat sunt veritatis. Accusantium dolorum excepturi iste,
                saepe sequi sunt suscipit vero. Aliquam ea eaque, eos impedit maiores non perspiciatis quam quia quibusdam voluptas!</span>
            <span>Autem consectetur deleniti dolorem est excepturi maiores, placeat quia reprehenderit velit voluptatum! Cum debitis est,
                expedita harum ipsa minima molestias mollitia nobis placeat quam quibusdam, rerum unde voluptate? Alias, numquam.</span>
            <span>Ab ad asperiores aspernatur eveniet, exercitationem illum in iusto modi necessitatibus optio porro repellat
                suscipit unde vitae, voluptas. Architecto blanditiis consectetur eaque fuga labore libero minima nemo sed suscipit vero?</span>
            <span>Accusantium corporis debitis deleniti ducimus eveniet incidunt, labore laudantium nostrum numquam omnis perspiciatis quam,
                quis quos soluta tenetur velit vero voluptatibus. Ab accusantium consequuntur cumque, delectus et explicabo neque similique?</span>
            <span>A consequuntur culpa dolorem error est exercitationem fuga fugiat illum inventore labore laborum modi nam nesciunt,
                nostrum nulla obcaecati odit pariatur perferendis possimus provident quas quis quod repellat velit vero?</span>
            <span>Adipisci, alias cum dolores exercitationem fugiat libero voluptatum. Expedita facere hic, molestias nemo officiis ullam.
                Architecto blanditiis commodi debitis, hic itaque, iusto labore maxime molestias nobis omnis qui reiciendis suscipit.</span>
            <span>Aliquam consequuntur debitis deserunt doloremque eaque esse incidunt iste libero natus necessitatibus numquam obcaecati
                odit quas rem reprehenderit, saepe temporibus, totam vitae. Aspernatur consequuntur, ipsam? Cupiditate dolor in laboriosam
                laudantium!</span>
            <button><a href="admin.php">admin</a></button>
        </p>
    </body>
    </html>

    <?php
    }
    ?>