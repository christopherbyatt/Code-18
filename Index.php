<<?php
$niveau='./';
ini_set('display_errors',1);
include($niveau . "inc/fragment/config.inc.php");
$arrJour=array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
$arrMois=array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
$strRequeteActu = 'SELECT id_actualite, titre, article, auteurs, 
               YEAR(date_actualite) AS annee, MONTH(date_actualite) AS mois, DAY(date_actualite) AS jour, DAYOFWEEK(date_actualite) AS jourSemaine, HOUR(date_actualite) AS heure, 
MINUTE(date_actualite) AS minutes
               FROM t_actualite
               ORDER BY date_actualite DESC';

$pdosResultatActu =$pdoConnexion->query($strRequeteActu);

$arrActu = array();
$ligne=$pdosResultatActu->fetch();
for($cptEnr=0;$ligneActu=$pdosResultatActu->fetch();$cptEnr++) {
    $arrActu[$cptEnr]['id_actualite'] = $ligneActu['id_actualite'];
    $arrActu[$cptEnr]['jour'] = $ligneActu['jour'];
    $arrActu[$cptEnr]['jourSemaine'] = $ligneActu['jourSemaine'];
    $arrActu[$cptEnr]['heure'] = $ligneActu['heure'];
    $arrActu[$cptEnr]['minutes'] = $ligneActu['minutes'];
    $arrActu[$cptEnr]['mois'] = $ligneActu['mois'];
    $arrActu[$cptEnr]['annee'] = $ligneActu['annee'];
    $arrActu[$cptEnr]['titre'] = $ligneActu['titre'];
    $arrActu[$cptEnr]['auteurs'] = $ligneActu['auteurs'];

    $arrArticle=explode(" ", $ligneActu["article"]);

    if(count(($arrArticle)>45)){
        array_splice($arrArticle, 45,count($arrArticle));
    }
    $arrActu[$cptEnr]["article"]=implode(" ", $arrArticle);

    if($arrActu[$cptEnr]["minutes"] == "0") {
        $arrActu[$cptEnr]["minutes"] = "00";
    }
}
$pdosResultatActu->closeCursor();
$strRequete="SELECT id_artiste, nom_artiste FROM t_artiste";
$pdosResultatArtistesSug = $pdoConnexion->query($strRequete);
$arrArtistesSug=array();
for($cptEnr=0;$ligneArtistesSug=$pdosResultatArtistesSug->fetch();$cptEnr++){
    $arrArtistesSug[$cptEnr]['id_artiste']=$ligneArtistesSug['id_artiste'];
    $arrArtistesSug[$cptEnr]['nom_artiste']=$ligneArtistesSug['nom_artiste'];
}
$pdosResultatArtistesSug->closeCursor();
$arrArtistesChoisis=array();
for($cpt=0;$cpt<=2;$cpt++){
    $artisteChoisi=rand(0,count($arrArtistes)-1);
    array_push($arrArtistesChoisis,$arrArtistesSug[$artisteChoisi]);
    array_splice($arrArtistesSug, $artisteChoisi, 1);
}
$pdosResultatArtistesSug = $pdoConnexion->query($strRequete);
$arrArtistesSug=array();
for($cptEnr=0;$ligneArtistesSug=$pdosResultatArtistesSug->fetch();$cptEnr++){
    $arrArtistesSug[$cptEnr]['id_artiste']=$ligneArtistesSug['id_artiste'];
    $arrArtistesSug[$cptEnr]['nom_artiste']=$ligneArtistesSug['nom_artiste'];
}
$pdosResultatArtistesSug->closeCursor();
$arrArtistesChoisis=array();
for($cpt=0;$cpt<=2;$cpt++){
    $intMax = count($arrArtistesSug)-1;
    $artisteChoisi=rand(0,$intMax);
    if($cpt<$intMax){
        array_push($arrArtistesChoisis,$arrArtistesSug[$artisteChoisi]);
        array_splice($arrArtistesSug, $artisteChoisi, 1);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style-christopher.css">
</head>
<body>
<?php include $niveau . 'inc/scripts/header.inc.php'; ?>
<!--<header class="header" role="banner">-->
<!--    <a href="--><?php //echo $niveau;?><!--index.php"><img class="header__logo" src="images/logoOff_noir.png" alt="accueil"></a>-->
<!--    <ul class="nav">-->
<!--        <li class="nav__item"><a class="nav__lien" href="--><?php //echo $niveau;?><!--index.php">Le OFF</a></li>-->
<!--        <li class="nav__item"><a class="nav__lien" href="#">Programmation</a></li>-->
<!--        <li class="nav__item"><a class="nav__lien" href="--><?php //echo $niveau;?><!--artistes/index.php">Artistes</a></li>-->
<!--        <li class="nav__item"><a class="nav__lien" href="#">Partenaires</a></li>-->
<!--    </ul>-->
<!--    <button class="header__btn" type="button">Acheter mon passeport</button>-->
<!--</header>-->
<main class="main" role="main">
<div class="main__actu">
    <h1 class="titrePrincipal">ACTUALITÉS</h1>
    <?php for($cpt=0;$cpt<count($arrActu);$cpt++){?>
    <section class="main__sectionArticle">
        <div class="main__article">
            <h2 class="main__h2"><?php echo $arrActu[$cpt]['titre'];?></h2>
            <p class="main__p"><?php echo $arrActu[$cpt]['article'];
                if(count(explode(" ", $arrActu[$cpt]["article"]))>=45){?>
                    <a href="#">...</a>
                <?php } ?></p>
            <h3 class="main__h3">Par <?php echo $arrActu[$cpt]["auteurs"];?>, le
                <?php echo $arrJour[$arrActu[$cpt]["jourSemaine"]-1];?>
                <?php echo $arrActu[$cpt]["jour"]." ". $arrMois[$arrActu[$cpt]["mois"]]. " ".$arrActu[$cpt]["annee"];?>
                <?php echo $arrActu[$cpt]["heure"]."h".$arrActu[$cpt]["minutes"];?></h3>
        </div>
        <?php } ?>
<!--        <div class="main__article">-->
<!--            <h2 class="main__h2">Un apéro qui promet à la Scène Caisse populaire de Québec</h2>-->
<!--            <p class="main__p">À 17 h, le sextuor Harvest Breed (Sherbrooke) vous servira un apéro musical aux influences des années 60 et 70. À 19 h, Orkestar Kriminal (Montréal), une douzaine de musiciens puisant dans le répertoire yiddish, grec, danois, punk des années 1920 et 1930 prendront place<a class="" href="#">...</a></p>-->
<!--            <h2 class="main__h2">Par Elisabeth et Karine, le mercredi 11 Aout 2023 10h00</h2>-->
<!--        </div>-->
<!--        <div class="main__article">-->
<!--            <h2 class="main__h2">Débutez votre fin de semaine sur une note familiale à la Scène de la famille Télé-Québec</h2>-->
<!--            <p class="main__p">De 13 h à 19 h, profitez de ce lieu en famille. De nombreux kiosques, maquillage pour enfants, animation de cirque, jeux gonflables et bien plus. L’Express Rock’n’Roll sera également stationné et accueillera mélomanes et néophytes à son bord pour faire découvrir ce musée ambulant<a class="" href="#">...</a></p>-->
<!--            <h2 class="main__h2">Par Elisabeth et Karine, le mercredi 11 Aout 2023 8h33</h2>-->
<!--        </div>-->
    </section>
</div>
<div class="main__artiste">
    <h2 class="h2">EN VEDETTES</h2>
    <ul><?php for($cpt=0;$cpt<count($arrArtistesChoisis);$cpt++){ ?>
            <li>
            <a href='<?php echo $niveau;?>artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>'><?php echo $arrArtistesChoisis[$cpt]["nom_artiste"];?></a>
            </li><?php } ?>
    </ul>
    </section>
<!--    <section class="main__sectionArtiste">-->
<!--        <div class="main__artisteVedette">-->
<!--            <img src="" alt="">-->
<!--            <h3 class="main__h3Vedette">CABARET OLIBRIUS</h3>-->
<!--        </div>-->
<!--        <div class="main__artisteVedette">-->
<!--            <img src="" alt="">-->
<!--            <h3 class="main__h3Vedette">DIAMOND RINGS</h3>-->
<!--        </div>-->
<!--        <div class="main__artisteVedette">-->
<!--            <img src="" alt="">-->
<!--            <h3 class="main__h3Vedette">JAH & I</h3>-->
<!--        </div>-->
<!--    </section>-->
</div>
</main>
<footer class="footer" role="contentinfo">
    <ul class="nav">
        <div class="logo-adresse">
            <a href="<?php echo $niveau;?>index.php"><img class="logo-adresse__logo" src="<?php echo $niveau;?>images/off_jaune.svg" alt="accueil"></a>
            <p class="logo-adresse__adresse">110 boulevard René-Lévesque Ouest<br>C.P. 48036<br>QC, Québec, G1R 5R5</p>
        </div>
        <ul class="footer--nav">
            <li class="menu__item"><a class="nav__lien" href="<?php echo $niveau;?>index.php"">Le OFF</a></li>
            <li class="nav__item"><a class="nav__lien" href="#">Programmation</a></li>
            <li class="nav__item"><a class="nav__lien" href="<?php echo $niveau;?>artistes/index.php">Artistes</a></li>
            <li class="nav__item"><a class="nav__lien" href="#">Partenaires</a></li>
        </ul>
        <div class="informations">
            <button class="informations__btn" type="button">Acheter mon passeport</button>
            <button class="informations__btn main__btn" type="button">Acheter mon passeport</button>
            <p class="informations__p">du 6 juillet au 10 juillet 2022</p>
            <a class="information__lien" href="">Formulaire d’abonnement à l’infolettre du festival</a>
            <div class="reseaux">
                <a class="reseaux__lien" href="#"><img class="reseaux_img" src="" alt="facebook"></a>
                <a class="reseaux__lien" href="#"><img class="reseaux_img" src="" alt="twitter"></a>
                <a class="reseaux__lien" href="#"><img class="reseaux_img" src="" alt="youtube"></a>
            </div>
        </div>
        <p class="footer__copyright">© 2009-2022 Festival OFF Tous droits réservés</p>
</footer>
</body>
</html>