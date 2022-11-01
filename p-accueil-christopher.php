<?php
$niveau='./';
ini_set('display_errors',1);
include($niveau . "inc/scripts/config.inc.php");
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
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Test Accueil</title>

</head>
<body>
<section>
    <h2>Actualités:</h2>
    <?php for($cpt=0;$cpt<count($arrActu);$cpt++){?>
        <article>
            <header>
                <h3><?php echo $arrActu[$cpt]['titre'];?></h3>
            </header>
            <?php echo $arrActu[$cpt]['article'];
            if(count(explode(" ", $arrActu[$cpt]["article"]))>=45){?>
                <a href="#">... Lire la suite</a>
            <?php } ?>
            <footer>
                <h4>Par <?php echo $arrActu[$cpt]["auteurs"];?>, le
                    <?php echo $arrJour[$arrActu[$cpt]["jourSemaine"]-1];?>
                    <?php echo $arrActu[$cpt]["jour"]." ". $arrMois[$arrActu[$cpt]["mois"]]. " ".$arrActu[$cpt]["annee"];?>
                    <?php echo $arrActu[$cpt]["heure"]."h".$arrActu[$cpt]["minutes"];?>
                </h4>
            </footer>
        </article>
    <?php } ?>
</section>
<section>
    <h2>En vedette:</h2>
    <ul><?php for($cpt=0;$cpt<count($arrArtistesChoisis);$cpt++){ ?>
            <li>
            <a href='artistes/fiche/p-fiche-christopher.php?id_artiste=<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>'><?php echo $arrArtistesChoisis[$cpt]["nom_artiste"];?></a>
            </li><?php } ?>
    </ul>
</section>

</body>
