<?php
    ini_set('display_errors',1);

    //Définition de la variable niveau
    $niveau='../../';
    //Inclusion du fichier de configuration
    include($niveau . "inc/fragment/config.inc-michel.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiche "artistes/fiche/index.php</title>
    <link rel="stylesheet" href='../../css/style-michel.css' media="all">
</head>

<body>
<div class="website">
    <header><?php include($niveau . "inc/scripts/header.inc.php"); ?></header>

    <main id="main" role="main" class="main">
        <h1 class="titrePrincipal">Nom Artiste</h1>
        <a href="">Site Web</a>
        <img src="https://i.picsum.photos/id/386/960/490.jpg?hmac=RcIYBU3QIXDOP7NMdRKxaWlzf3izkxtM81zazZgricw" alt="">

        <h2 class="description_h2">Description</h2>
        <p>La formation 3D KIDS existe depuis 2004. Puriste de punk '77, les 3D KIDS gardent ça simple et droit au but. X (guitare/voix), Y (batterie) et Z (basse) ont deux albums à leur actif (ZYX et Retarded Love) et un troisième est prévu avant la fin de l'année.</p>

        <h2 class="provenance_h2">Provenance</h2>
        <p>Québec</p>

        <h2 class="styleMusic_h2">Style musical</h2>
        <p class="h2">Rock</p>

        <h2 class="representation_h2">Représentations</h2>
        <ul>
            <li>Salle Multi de Méduse, le jeudi 9 juillet à 22h30</li>
            <li>Salle Multi de Méduse, le vendredi 10 juillet à 23h00</li>
        </ul>
        <h2 class="h2">Découvrir d'autres artistes</h2>
        <div class="container">
            <ul class="artistes_ul">
            <?php
                for($intCptRandom=0; $intCptRandom<3; $intCptRandom++){ ?>
                    <br><img class="artistes_img" style='padding: 1em' src='https://fakeimg.pl/200/' alt='Artiste:'>
                <?php } ?>
            </ul>
        </div>
    </main>
    <footer><?php include($niveau . "inc/scripts/footer.inc.php"); ?></footer>
</div>
</body>

</html>
