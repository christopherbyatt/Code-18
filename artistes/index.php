<?php
ini_set("display_errors", 1);
$niveau="../";
include ("../inc/fragment/config.inc.php");

//**********
//Récupérer la page dans la querystring
//**********
if(isset($_GET["id_page"])==true){
    $id_page= $_GET["id_page"];
}else{
    $id_page=1;
}
$nbArtisteParPage = 3;
$enregistrementDepart = 3 * $id_page;
$enregistrementDepartBis=(3 * $id_page)-2;

//************
//Récupérer le style dans la querystring + requête SQL principale
//************
$idStyle="";
if(isset($_GET["id_style"])==true) {
    $idStyle = $_GET["id_style"];
    $strRequete="SELECT t_artiste.id_artiste, nom_artiste 
                FROM t_artiste 
                INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste 
                INNER JOIN t_style ON t_style.id_style=ti_style_artiste.id_style 
                WHERE ti_style_artiste.id_style=".$idStyle." 
                ORDER BY nom_artiste LIMIT ".$enregistrementDepartBis.", ".$nbArtisteParPage;
}else{
    $idStyle = 0;
    $strRequete="SELECT t_artiste.id_artiste, nom_artiste
    FROM t_artiste
    ORDER BY nom_artiste
    LIMIT ".$enregistrementDepartBis.", ".$nbArtisteParPage;
}

//**********
//Récupérer le nombre d'artiste
//**********
if($idStyle!=0){
    $strRequeteCount="SELECT COUNT(*) AS nbEnregistrement
        FROM t_artiste
        INNER JOIN ti_style_artiste ON t_artiste.id_artiste=ti_style_artiste.id_artiste
        WHERE ti_style_artiste.id_artiste=". $idStyle;
}else{
    $strRequeteCount= "SELECT COUNT(*) AS nbEnregistrement 
                        FROM t_artiste";
}
$pdoResultatCpt=$pdoConnexion->query($strRequeteCount);
$totalArtistes=$pdoResultatCpt->fetch();
$nbArtistes=$totalArtistes["nbEnregistrement"];
$pdoResultatCpt->closeCursor();
$nbPages=ceil($nbArtistes/$nbArtisteParPage);
//*************

$pdosResultat=$pdoConnexion->prepare($strRequete);
$pdosResultat->execute();
$arrNoms=array();
$ligne=$pdosResultat->fetch();
for($intCptLigne=0;$intCptLigne<$pdosResultat->rowCount();$intCptLigne++){
    $arrNoms[$intCptLigne]["id_artiste"]=$ligne["id_artiste"];
    $arrNoms[$intCptLigne]["nom_artiste"]=$ligne["nom_artiste"];

    //**********************
    //Sous-requête
    //**********************
    $strSousRequete= "SELECT nom_style FROM t_style 
                    INNER JOIN ti_style_artiste ON t_style.id_style = ti_style_artiste.id_style 
                    WHERE ti_style_artiste.id_artiste=" .$arrNoms[$intCptLigne]["id_artiste"];

    $pdosSousResultat=$pdoConnexion->prepare($strSousRequete);
    $pdosSousResultat->execute();

    $ligneStyles=$pdosSousResultat->fetch();
    $strStyles="";
    for($intCptStyles=0;$intCptStyles<$pdosSousResultat->rowCount();$intCptStyles++){
        if($strStyles != ""){
            $strStyles = $strStyles . ", ";
        }
        $strStyles = $strStyles. $ligneStyles["nom_style"];
        $ligneStyles=$pdosSousResultat->fetch();
    }
    $pdosSousResultat->closeCursor();
    //*****************************

    $arrNoms[$intCptLigne]["artiste_style"] = $strStyles;
    $ligne =$pdosResultat->fetch();
}
$pdosResultat->closeCursor();

//***************
//Récupérer les noms de styles de musique
//***************
$strRequete="SELECT id_style, nom_style 
                    FROM t_style";
$pdosResultat=$pdoConnexion->query($strRequete);
$arrStyles=array();
$ligne=$pdosResultat->fetch();
for($intCptArrStyle=0;$ligne=$pdosResultat->fetch();$intCptArrStyle++){
    $arrStyles[$intCptArrStyle]["id_style"]=$ligne["id_style"];
    $arrStyles[$intCptArrStyle]["nom_style"]=$ligne["nom_style"];
}
$pdosResultat->closeCursor();
//***************

$strRequete="SELECT nom_artiste, id_artiste
                FROM t_artiste";
$pdosResultatArtSug=$pdoConnexion->query($strRequete);
$arrArtistesSug=array();
for($intCptLigne=0; $ligne=$pdosResultatArtSug->fetch()/*$intCptLigne<$pdosResultat->rowCount()*/;$intCptLigne++){
    $arrArtistesSug[$intCptLigne]["nom_artiste"]=$ligne["nom_artiste"];
    $arrArtistesSug[$intCptLigne]["id_artiste"]=$ligne["id_artiste"];
}
$pdosResultatArtSug->closeCursor();

$arrArtistesChoisis=array();
for($cpt2=0; $cpt2<=2; $cpt2++) {
    $artisteChoisi=rand(0, count($arrArtistesSug)-1);
    array_push($arrArtistesChoisis, $arrArtistesSug[$artisteChoisi]);
    array_splice($arrArtistesSug, $artisteChoisi, 1);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style-anais.css">
    <title>Festival OFF - Liste des artistes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0," />
</head>
<body>
    <a href="#main" class="screen-reader-only focusable">Allez au contenu</a>
    <?php include("../inc/scripts/header.inc.php")?>
    <main class="main" role="main">
    <h1 class="titrePrincipal">Liste <br> des <br> artistes</h1>

    <section class="styles">
        <div class="ctnStyle">
            <button class="titreSecondaireBis">Tous les styles</button>
            <ul class="listeStyle style--closed">
                <?php
                for($intCpt1=0;$intCpt1<count($arrStyles);$intCpt1++){ ?>
                    <li class="listeStyle__item"><a class="listeStyle__lien" href='<?php echo "?id_style=".$arrStyles[$intCpt1]["id_style"]?>'><?php echo $arrStyles[$intCpt1]["nom_style"]?></a></li>
                <?php }
                ?>
            </ul>
        </div>
    </section>

    <section class="artistes">
        <div class="ctn-btn">
            <?php
            if($idStyle==0){
                if($id_page>1){
                    ?>
                    <a href='index.php?id_page=<?php echo ($id_page-1); ?>' class="arriere" >&#9664; Précédent</a>
                <?php }
            } else { ?>

                <a href='index.php?id_page=<?php echo ($id_page-1); ?>&id_style=<?php echo $idStyle; ?>' class="arriere" >&#9664; Précédent</a>
            <?php }
            ?>

            <?php
            if($idStyle==0){
                if($id_page<$nbPages){
                    ?>
                    <a href='index.php?id_page=<?php echo ($id_page+1); ?>' class="avant">Suivant &#9654;</a>
                <?php }
            } else { ?>
                <a href='index.php?id_page=<?php echo ($id_page+1); ?>&id_style=<?php echo $idStyle; ?>' class="avant">Suivant &#9654;</a>
            <?php }
            ?>
        </div>
        <div class="ctn-infoArtiste">
            <?php
            if($idStyle !=0){
                echo "<p> Style: " .$arrStyles[$idStyle-2]["nom_style"]. "</p>";
            }
            ?>
            <?php for($intCpt=0;$intCpt<count($arrNoms);$intCpt++){ ?>
                <div class="ctn-images">
                    <figure class="infoArtiste">
                        <source src="../images/images_artistes/<?php echo $arrNoms[$intCpt]["id_artiste"] ?>_2__w880.jpg" media="(min-width:501px)">
                        <source src="../images/images_artistes/<?php echo $arrNoms[$intCpt]["id_artiste"] ?>_2__w440.jpg" media="(max-width:500px)">
                        <img class="infoArtiste__img" src="../images/images_artistes/<?php echo $arrNoms[$intCpt]["id_artiste"] ?>_2__w440.jpg" alt="<?php echo $arrNoms[$intCpt]["nom_artiste"] ?>">
                        <figcaption class="infoArtiste__nom">
                            <a class="infoArtiste__nom__lien" href="<?php echo $niveau."artistes/fiche/index.php?id_artiste=".$arrNoms[$intCpt]["id_artiste"]; ?>" aria-label="lien vers la fiche de <?php echo $arrNoms[$intCpt]["nom_artiste"] ?>"><?php echo $arrNoms[$intCpt]["nom_artiste"] ?></a>
                        </figcaption>
                    </figure>
                    <p class="infoArtiste__nom__p">Style(s): <?php echo $arrNoms[$intCpt]["artiste_style"]; ?></p>
                </div>
            <?php } ?>
        </div>

    </section>

    <h2 class="titreSecondaire">En vedette</h2>

    <ul class="ctn-suggestionArtiste">
        <?php for($cpt=0;$cpt<count($arrArtistesChoisis); $cpt++) { ?>
            <li class="ctn-suggestionArtiste__item">
                <a href="<?php echo $niveau ?>artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>">
                    <figure class="artisteSugg">
                        <source src="../images/images_artistes/<?php echo $arrNoms[$intCpt]["id_artiste"] ?>_3__w600.jpg" media="(min-width:501px)">
                        <source src="../images/images_artistes/<?php echo $arrNoms[$intCpt]["id_artiste"] ?>_3__w280.jpg" media="(max-width:500px)">
                        <img class="artisteSugg__img" src="../images/images_artistes/<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>_3__w280.jpg" alt="<?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?>">
                        <figcaption class="artisteSugg__figcap">
                            <a class="artisteSugg__figcap__lien" href='<?php echo $niveau ?>artistes/fiche/index.php?id_artiste=<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>' aria-label="Lien vers la fiche de <?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?>"><?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?></a>
                        </figcaption>
                    </figure>
                </a>
            </li>
        <?php } ?>
    </ul>

</main>
<?php include("../inc/scripts/footer.inc.php")?>

<script type="text/javascript">
    let strPhp= "<?php echo $niveau; ?>";
    console.log(strPhp)
</script>
<script type="text/javascript" src="../js/menu.js"></script>
<script src="../js/script_liste_artiste.js"></script>

</body>
</html>

