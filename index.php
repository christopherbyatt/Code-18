<?php
$niveau='./';
//ini_set('display_errors',1);
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
    $artisteChoisi=rand(0,count($arrArtistesSug)-1);
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
    <link rel="stylesheet" href="<?php $niveau;?>css/style-christopher.css">
    <link rel="stylesheet" href="<?php $niveau;?>css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0," />

</head>
<body>
<a href="#main" class="screen-reader-only focusable">Allez au contenu</a>
<header>
<?php include $niveau . 'inc/scripts/header.inc.php'; ?>
</header>

<main class="main" role="main" id="main">

    <div class="main__tarif">
        <h1 class="titrePrincipal">TARIFS</h1>
        <div class="main__article">
        <h2 class="main__h2">Passeport:</h2>
        <p class="main__p">10$ pour toute la durée du festival</p>
        <p class="main__p">5$ à la porte / soir (spectacles à Méduse)</p>
        <p class="main__p">Spectacles extérieurs gratuits</p>
        <p class="main__p">Spectacles gratuits au Parvis de l’église Saint-Jean-Baptiste, au bar le Sacrilège et au Fou-Bar.</p>

        <h4 class="main__h4">Procurez-vous un passeport en ligne ici dès maintenant !</h4>

        <p class="main__p">Les passeports sont aussi disponibles en prévente chez nos partenaires:</p>
        <p class="main__p">LA NINKASI HONORÉ-MERCIER : 840 Avenue Honoré-Mercier, Québec</p>
        <p class="main__p">ÉRICO: 634 Rue Saint-Jean, Québec</p>
        <p class="main__p">LE SACRILÈGE: 447 Rue Saint-Jean, Québec</p>
        <p class="main__p">LE BONET D'ÂNE: 298 Rue Saint-Jean, Québec</p>
        <p class="main__p">DISQUAIRE CD MÉLOMANE: 248 rue Saint-Jean, Québec</p>
        <p class="main__p">LE KNOCK-OUT: 832 St-Joseph Est, Québec</p>
    </div>
    </div>
    <div class="main__spectacle">
        <h2 class="h2">LIEUX DE SPECTACLE</h2>
        <div class="main__article">

            <p class="main__p">MÉDUSE : 591, rue de Saint-Vallier Est, Québec</p>
            <p class="main__p">LE SACRILÈGE : 447, rue Saint-Jean, Québec</p>
            <p class="main__p">SCÈNE DESJARDIN ( LE PARVIS SAINT-JEAN-BAPTISTE ) ÉGLISE SAINT-JEAN-BAPTISTE : <br> 480 rue Saint-Jean, Québec</p>
            <p class="main__p">LE FOU-BAR : 525 Rue St-Jean, Québec</p>
            <p class="main__p">LA NINKASI DU FAUBOURG : 811 Rue Saint-Jean , Québec</p>
        </div>
    </div>
<div class="main__actu">
    <h2 class="h2">ACTUALITÉS</h2>
    <?php for($cpt=0;$cpt<count($arrActu);$cpt++){?>

        <div class="main__article">
            <h2 class="main__h2"><?php echo $arrActu[$cpt]['titre'];?></h2>
            <p class="main__p"><?php echo $arrActu[$cpt]['article'];
                if(count(explode(" ", $arrActu[$cpt]["article"]))>=45){?>
                    <a class="main__lien" aria-label="Lire la suite : <?php echo $arrActu[$cpt]['titre'];?>" href="#">... Lire la suite</a>
                <?php } ?></p>
            <h3 class="main__h3">Par <?php echo $arrActu[$cpt]["auteurs"];?>,<br>le
                <?php echo $arrJour[$arrActu[$cpt]["jourSemaine"]-1];?>
                <?php echo $arrActu[$cpt]["jour"]." ". $arrMois[$arrActu[$cpt]["mois"]]. " ".$arrActu[$cpt]["annee"];?>
                <?php echo $arrActu[$cpt]["heure"]."h".$arrActu[$cpt]["minutes"];?></h3>
        </div>
        <?php } ?>

</div>
<div class="main__artiste">
    <h2 class="h2">EN VEDETTES</h2>
    <ul class="ctn-suggestionArtiste">
        <?php for($cpt=0;$cpt<count($arrArtistesChoisis); $cpt++) { ?>
            <li class="ctn-suggestionArtiste__item">
                <figure class="artisteSugg">
                    <source src="<?php echo $niveau;?>images/images_artistes/<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>_2__w880.jpg" media="(min-width:501px)">
                    <source src="<?php echo $niveau;?>images/images_artistes/<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>_2__w440.jpg" media="(max-width:500px)">
                    <img class="artisteSugg__img" src="<?php echo $niveau;?>images/images_artistes/<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>_2__w880.jpg" alt="<?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?>">
                    <figcaption class="artisteSugg__figcap">
                        <a class="artisteSugg__figcap__lien" href='<?php echo $niveau ?>artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>'><?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?></a>
                    </figcaption>
                </figure>
            </li>
        <?php } ?>
    </ul>


</div>
</main>
<footer class="footer" role="contentinfo">
    <?php include $niveau . 'inc/scripts/footer.inc.php'; ?>
</footer>
<script type="text/javascript">    let strPhp= "<?php echo $niveau; ?>";</script>
<script type="text/javascript" src="<?php echo $niveau?>js/menu.js"></script>
</body>
</html>