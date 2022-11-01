<?php
ini_set('display_errors',1);

//Définition de la variable niveau
$niveau='../../';
//Inclusion du fichier de configuration
include($niveau . "inc/scripts/config.inc.php");

$arrMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
$arrJours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');

//Ici on récupère la "querystring"
$strIdArtiste=$_GET['id_artiste'];

///////////////////REQUÊTE DE L'ARTISTE ////////////////////////////////////////////////////////
//	//Établissement de la chaine de requête
$strRequete =  'SELECT id_artiste, nom_artiste, description, site_web_artiste , provenance 
                    FROM t_artiste 
                    WHERE id_artiste='. $strIdArtiste.' 
                    ORDER BY nom_artiste ASC';
//
//	//Exécution de la requête
$pdosResultat = $pdoConnexion->query($strRequete);

//	//Extraction de l'enregistrements de la BD
$arrArtistes=$pdosResultat->fetch();

// Requête pour afficher la liste des événements
$strReqEventArtiste = ' SELECT DISTINCT id_evenement, t_lieu.id_lieu, nom_lieu, date_et_heure, 
                        HOUR(date_et_heure) AS HEURE, 
                        MINUTE(date_et_heure) AS MINUTES, 
                        DAYOFWEEK(date_et_heure) AS JOURNÉE , 
                        DAYOFMONTH(date_et_heure) AS JOUR, 
                        MONTH(date_et_heure) AS MOIS, 
                        YEAR(date_et_heure)
                        FROM ti_evenement
                        INNER JOIN t_lieu ON ti_evenement.id_lieu = t_lieu.id_lieu
                        WHERE id_artiste='. $strIdArtiste.'
                        ORDER BY `id_lieu` ASC';

//	//Exécution de la requête
$pdosResultatEvent = $pdoConnexion->query($strReqEventArtiste);

//	//Extraction de l'enregistrements de la BD
$arrEventArtiste=$pdosResultatEvent->fetch();
$arrEventArtisteFinal = $arrEventArtiste;
$strAffichageEvent = " ";

//	Exécution de la requête
for($cptEnr=0;$cptEnr<$pdosResultatEvent->rowCount();$cptEnr++){
    //Pour mettre 00 minutes au lieu de 0
    if($arrEventArtiste['MINUTES'] == "0") {
        $arrEventArtiste['MINUTES'] = "00";
    }

    $strAffichageEvent.= "<ul><li>" . $arrEventArtiste['nom_lieu'] . "</li>";
    $strAffichageEvent.= "<li>" . $arrJours[$arrEventArtiste['JOURNÉE']-1] . " le " . $arrEventArtiste['MOIS'] . " " . $arrMois[$arrEventArtiste['MOIS']] . "</li>";
    $strAffichageEvent.= "<li>" . $arrEventArtiste['HEURE'] . ":" . $arrEventArtiste['MINUTES'] . "</li>" . "</li></ul>";
    $arrEventArtiste=$pdosResultatEvent->fetch();
}

///////////////////REQUÊTE ARTISTE SIMILAIRE///////////////////////////////////////

$strRequeteArtisteSimilaire =  'SELECT DISTINCT t_artiste.id_artiste, nom_artiste
                                FROM t_artiste
                                INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste
                                WHERE id_style IN( SELECT id_style FROM ti_style_artiste
                                WHERE id_artiste=' . $strIdArtiste . ') AND ti_style_artiste.id_artiste<>' . $strIdArtiste;

// Exécution de la requête
$pdosResultatArtistesSim = $pdoConnexion->query($strRequeteArtisteSimilaire);

$arrArtisteSug = array();
for($intCptRandom=0; $ligneRandom=$pdosResultatArtistesSim->fetch(); $intCptRandom++){
    $arrArtisteSug[$intCptRandom]['id_artiste']=$ligneRandom['id_artiste'];
    $arrArtisteSug[$intCptRandom]['nom_artiste']=$ligneRandom['nom_artiste'];
}

//On libère la requête
$pdosResultatArtistesSim->closeCursor();

//Établie une liste de choix
$arrArtisteChoisi = array();
//Tant que le nombre de suggestions n'est pas atteint
if(count($arrArtisteSug)>=3) {
    for($intCptPart=0;$intCptPart<=2;$intCptPart++){
        //Trouve un index au hazard selon le nombre de sugestions
        $intIndexHazard=rand(0,count($arrArtisteSug)-1);
        //Prendre la suggestion et la mettre dans les artistes choisis
        array_push($arrArtisteChoisi,$arrArtisteSug[$intIndexHazard]);
        //Enlever la suggestion des suggestions disponibles (évite les suggestions en doublons)
        array_splice($arrArtisteSug,$intIndexHazard,1);
    };
}   else if (count($arrArtisteSug) === 0) {
    $arrArtisteSug = array("Aucun");
} else {
    for($intCptPart=0;$intCptPart<=count($arrArtisteSug);$intCptPart++){
        //Trouve un index au hazard selon le nombre de sugestions
        $intIndexHazard=rand(0,count($arrArtisteSug)-1);
        //Prendre la suggestion et la mettre dans les artistes choisis
        array_push($arrArtisteChoisi,$arrArtisteSug[$intIndexHazard]);
        //Enlever la suggestion des suggestions disponibles (évite les suggestions en doublons)
        array_splice($arrArtisteSug,$intIndexHazard,1);
    };
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text-html; charset=UTF-8">
    <title>Cadriciel TIM - Fiche de l'Artiste</title>
    <!-- Inclure les scripts d'entête-->
    <?php include($niveau . "inc/fragments/header.inc.php") ?>
</head>
<body class="demo">
<?php include($niveau . "inc/fragments/navigation.html") ?>
<main>
    <h1>Fiche de l'artiste</h1>
    <ul>
        <?php echo
            //Affichage de l'Artiste et de son identifiant
            "<li>Nom: " .$arrArtistes['nom_artiste'] . "</li>" .
            "<li>Provenance: " .$arrArtistes['provenance'] . "</li>" .
            "<li>Site Web: . <a href='" . $arrArtistes['site_web_artiste'] . "'>" . $arrArtistes['site_web_artiste'] . "</a></li>" .
            "<li>Description de l'artiste: " .$arrArtistes['description'] . "</li>";
        "</li>";
        for($intCptImg=0; $intCptImg<3;$intCptImg++){
            echo "<img style='padding: 1em' src='https://fakeimg.pl/200/' alt='Artiste:'>";
        };
        ?>
    </ul>

    <h2>Prochains spectacles</h2>
    <?php echo $strAffichageEvent;?>

    <h2>Artistes similaires</h2>
    <ul>
        <?php
        if(count($arrArtisteChoisi)>0) {
            for($intCptRandom=0; $intCptRandom<count($arrArtisteChoisi); $intCptRandom++) { ?>
                <li>
                    <a href="index.php?id_artiste=<?php echo $arrArtisteChoisi[$intCptRandom]['id_artiste'];?>">
                        <?php echo $arrArtisteChoisi[$intCptRandom]['nom_artiste'];?>
                    </a>
                    <?php echo "<br><img style='padding: 1em' src='https://fakeimg.pl/200/' alt='Artiste:'>"?>
                </li> <?php }
        } else {
            echo $arrArtisteSug[0];
        } ?>
    </ul>

</main>
<?php include($niveau . "inc/fragments/footer.inc.php") ?>
</body>
</html>
