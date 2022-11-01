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

//        $strAffichageEvent.= "<ul><li>" . $arrEventArtiste['nom_lieu'] . "</li>";
//        $strAffichageEvent.= "<li>" . $arrJours[$arrEventArtiste['JOURNÉE']-1] . " le " . $arrEventArtiste['MOIS'] . " " . $arrMois[$arrEventArtiste['MOIS']] . "</li>";
//        $strAffichageEvent.= "<li>" . $arrEventArtiste['HEURE'] . ":" . $arrEventArtiste['MINUTES'] . "</li>" . "</li></ul>";

        $strAffichageEvent.= "<li>" . $arrEventArtiste['nom_lieu'] . ", " . $arrJours[$arrEventArtiste['JOURNÉE']-1] . " le " . $arrEventArtiste['MOIS'] . " " . $arrMois[$arrEventArtiste['MOIS']] . " à " . $arrEventArtiste['HEURE'] . ":" . $arrEventArtiste['MINUTES'] . "</li>";
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiche "artistes/fiche/index.php</title>
    <link rel="stylesheet" href='../../css/style-michel.css' media="all">
</head>

<body>
<div class="website">
    <header><?php include($niveau . "inc/scripts/header.inc.php"); ?></header>

    <main id="main" role="main" class="main">
        <h1 class="titrePrincipal"><?php echo $arrArtistes['nom_artiste'] ?></h1>
        <ul>
            <?php
            for($intCptImg=0; $intCptImg<3;$intCptImg++){
                echo "<img style='padding: 1em' src='https://fakeimg.pl/250/' alt='Artiste:'>";
            };
            ?>
        </ul>

        <a href="<?php echo $arrArtistes['site_web_artiste']?>">Site Web</a><br>
<!--        <img src="https://i.picsum.photos/id/386/960/490.jpg?hmac=RcIYBU3QIXDOP7NMdRKxaWlzf3izkxtM81zazZgricw" alt="">-->

        <h2 class="description_h2">Description</h2>
        <p><?php echo $arrArtistes['description']?></p>

        <h2 class="provenance_h2">Provenance</h2>
        <p><?php echo $arrArtistes['provenance']?></p>

        <h2 class="styleMusic_h2">Style musical</h2>
        <p class="h2"><?php echo $arrArtistes['id_style']?>Rock</p>

        <h2 class="representation_h2">Représentations</h2>
        <ul>
            <?php echo $strAffichageEvent;?>
        </ul>

        <h2 class="h2">Découvrir d'autres artistes</h2>
        <div class="container">
            <ul class="artistes_ul">
            <?php
                for($intCptRandom=0; $intCptRandom<3; $intCptRandom++){ ?>
                    <img class="artistes_img" style='padding: 1em' src='https://fakeimg.pl/250/' alt='Artiste:'>
                <?php } ?>
            </ul>
        </div>
    </main>
    <footer><?php include($niveau . "inc/scripts/footer.inc.php"); ?></footer>
</div>
</body>

</html>
