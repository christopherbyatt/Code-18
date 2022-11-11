<?php
    ini_set('display_errors',1);

    //Définition de la variable niveau
    $niveau='../../';
    //Inclusion du fichier de configuration
    include($niveau . "inc/fragment/config.inc-michel.php");

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
                            DAYOFWEEK(date_et_heure) AS JOURNÉE ,
                            DAYOFMONTH(date_et_heure) AS JOUR,
                            HOUR(date_et_heure) AS HEURE, 
                            MINUTE(date_et_heure) AS MINUTES,  
                            MONTH(date_et_heure) AS MOIS, 
                            YEAR(date_et_heure)
                            FROM ti_evenement
                            INNER JOIN t_lieu ON ti_evenement.id_lieu = t_lieu.id_lieu
                            WHERE id_artiste='. $strIdArtiste.'
                            ORDER BY `id_lieu` DESC';

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

        $strAffichageEvent.=    "<li>" . $arrEventArtiste['nom_lieu'] .
                                ", " . $arrJours[$arrEventArtiste['JOURNÉE']-1] .
                                " le " . $arrEventArtiste['JOUR'] . " " . $arrMois[$arrEventArtiste['MOIS']-1] .
                                " à " . $arrEventArtiste['HEURE'] . ":" . $arrEventArtiste['MINUTES'] . "</li>";
        $arrEventArtiste=$pdosResultatEvent->fetch();
    }

    $strRequeteNomStyle = 'SELECT DISTINCT t_style.id_style, nom_style, t_artiste.id_artiste
                           FROM t_style
                           INNER JOIN ti_style_artiste ON t_style.id_style=ti_style_artiste.id_style
                           INNER JOIN t_artiste ON ti_style_artiste.id_artiste = t_artiste.id_artiste
                           WHERE t_artiste.id_artiste=' . $strIdArtiste;

    //Extraction de l'enregistrements de la BD
    $strRequeteNomStyle = $pdoConnexion->query($strRequeteNomStyle);
    $arrNomStyle = array();
    //Extraction des enregistrements à afficher de la BD
    for($intCptEnrStyle=0;$ligne = $strRequeteNomStyle->fetch();$intCptEnrStyle++){
        $arrNomStyle[$intCptEnrStyle]['id_style']=$ligne['id_style'];
        $arrNomStyle[$intCptEnrStyle]['nom_style']=$ligne['nom_style'];
}

    ///////////////////REQUÊTE ARTISTE SIMILAIRE///////////////////////////////////////

    $strRequeteArtisteSimilaire =  'SELECT DISTINCT t_artiste.id_artiste, nom_artiste
                                    FROM t_artiste
                                    INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste
                                    WHERE id_style IN
                                          ( SELECT id_style FROM ti_style_artiste
                                            WHERE id_artiste=' . $strIdArtiste . ') 
                                            AND ti_style_artiste.id_artiste<>' . $strIdArtiste;

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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiche "artistes/fiche/index.php</title>
    <link rel="stylesheet" href='../../css/style-michel.css' media="all">
    <link rel="stylesheet" href='../../css/style.css' media="all">
</head>
<a href="#main" class="screen-reader-only focusable">Allez au contenu</a>
<body class="">
    <header><?php include($niveau . "inc/scripts/header.inc.php"); ?></header>
    <main id="main" role="main" class="main">
        <h1 class="focusable titrePrincipal titrePrincipalh1"><?php echo $arrArtistes['nom_artiste']?></h1>
        <ul class="ctn-artistePrincip">
            <a class="artistePrincip__a" href="<?php echo $arrArtistes['site_web_artiste']?>">Site Web</a><br>
            <?php
            for($intCptImg=0; $intCptImg<rand(3,5);$intCptImg++){ ?>
<!--                <source src="--><?php //echo $niveau;?><!--images/images_artistes/--><?php //echo $arrArtistes[$intCptImg]["id_artiste"];?><!--_2__w440.jpg" media="(max-width:500px)">-->
                <source src="<?php echo $niveau;?>images/images_artistes/<?php echo $strIdArtiste . "_" . $intCptImg;?>__w960.jpg" media="(min-width:501px)">
                <source src="<?php echo $niveau;?>images/images_artistes/<?php echo $strIdArtiste . "_" . $intCptImg;?>__w300.jpg" media="(max-width:500px)">
                <img class="artistePrincip__img" src="<?php echo $niveau;?>images/images_artistes/<?php echo $strIdArtiste . "_" . $intCptImg;?>__w960.jpg" alt="<?php echo "image de ". $arrArtistes['nom_artiste'];?>">
            <?php } ?>
        </ul>

        <h2 class="focusable titreSecondaire">Description</h2>
        <p class="titreSecondaire__p"><?php echo $arrArtistes['description']?></p>

        <h2 class="focusable titreSecondaire">Provenance</h2>
        <p class="titreSecondaire__p"><?php echo $arrArtistes['provenance']?></p>

        <h2 class="focusable titreSecondaire">Style musical</h2>
        <p class="titreSecondaire__p"><?php
            for ($cptStyle = 0;$cptStyle < count($arrNomStyle);$cptStyle++){
                echo $arrNomStyle[$cptStyle]['nom_style'] . '  |  '  ;?><?php } ?></p>
        <!--        <p class="textes">--><?php //echo $arrArtisteStyle[0]['nom_style']?><!--</p>-->

        <h2 class="focusable titreSecondaire">Représentations</h2>
        <ul class="titreSecondaire__p">
            <?php echo $strAffichageEvent;?>
        </ul>

        <h2 class="focusable titreSecondaire">Découvrir d'autres artistes</h2>
        <ul class="ctn-suggestionArtiste">
            <?php
            if(count($arrArtisteChoisi)>0) {
                for($intCptRandom=0; $intCptRandom<count($arrArtisteChoisi); $intCptRandom++) { ?>
                <a class="" href='<?php echo $niveau ?>artistes/fiche/index.php?id_artiste=<?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"];?>' aria-label="Accéder à la fiche de l'artiste: <?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"]?>">
                    <li class="ctn-suggestionArtiste__item">
                        <figure class="artisteSugg">
                            <source src="<?php echo $niveau;?>images/images_artistes/<?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"] . "_" . $intCptRandom;?>__w440.jpg" media="(min-width:501px)">
                            <source src="<?php echo $niveau;?>images/images_artistes/<?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"] . "_" . $intCptRandom;?>__w280.jpg" media="(max-width:500px)">
                            <img class="artisteSugg__img" src="<?php echo $niveau;?>images/images_artistes/<?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"] . "_" . $intCptRandom;?>__w280.jpg" alt="<?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"]. "_" . $arrArtisteChoisi[$intCptRandom]["nom_artiste"]; ?>">
                            <figcaption class="artisteSugg__figcap">
                                <a class="artisteSugg__figcap__lien" href='<?php echo $niveau ?>artistes/fiche/index.php?id_artiste=<?php echo $arrArtisteChoisi[$intCptRandom]["id_artiste"];?>'><?php echo $arrArtisteChoisi[$intCptRandom]["nom_artiste"]; ?></a>
                            </figcaption>
                        </figure>
                    </li>
                </a> <?php }
            } else {
                echo $arrArtisteSug[0];
            } ?>
        </ul>
    </main>
    <footer role="contentinfo"><?php include($niveau . "inc/scripts/footer.inc.php"); ?></footer>
</body>

</html>
