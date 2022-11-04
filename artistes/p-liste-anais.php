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
    <link rel="stylesheet" href="../css/style-anais.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0," />
</head>
<body>
<header class="header" role="banner">
    <img class="header__logo" src="../images/logoOff_bleu_fonce.svg" alt="accueil">
    <ul class="nav">
        <li class="nav__item nav__item--un">
            <a href="" class="nav__lien">Le OFF</a>

        </li>
        <li class="nav__item nav__item--deux">
            <a href="" class="nav__lien">Programmation</a>

        </li>
        <li class="nav__item nav__item--trois">
            <a href="" class="nav__lien">Artistes</a>

        </li>
        <li class="nav__item nav__item--quatre">
            <a href="" class="nav__lien">Partenaires</a>

        </li>
    </ul>
    <button class="header__btn main__btn" type="button">Acheter mon passeport</button>
</header>
<main class="main" role="main">
    <h1 class="titrePrincipal">Liste <br> des <br> artistes</h1>
    <section class="artistes">

        <div class="ctn-infoArtiste">
            <?php
            if($idStyle !=0){
                echo "<p> Style: " .$arrStyles[$idStyle-2]["nom_style"]. "</p>";
            }
            ?>
        <?php for($intCpt=0;$intCpt<count($arrNoms);$intCpt++){ ?>

            <figure class="infoArtiste">
                <img class="infoArtiste__img" src="../images/placeholder.png" alt="<?php echo $arrNoms[$intCpt]["nom_artiste"] ?>">
                <div class="btnImages "></div>
                <figcaption class="infoArtiste__nom"> <a class="infoArtiste__nom__lien" href="<?php echo $niveau."artistes/fiche/p-fiche-prenom.php?id_artiste=".$arrNoms[$intCpt]["id_artiste"]; ?>"><?php echo $arrNoms[$intCpt]["nom_artiste"] ?><!<--Cabaret Olibrius-->
                        <br> <span class="infoArtiste__nom__span">Style(s): <?php echo $arrNoms[$intCpt]["artiste_style"]; ?></span>
                    </a>
                </figcaption>
            </figure>
        <?php } ?>
        <!--    <figure class="infoArtiste">
                <img class="infoArtiste__img" src="../images/placeholder.png" alt="Diamond Rings">
                <div class="btnImages btnImages--orange"></div>
                <figcaption class="infoArtiste__nom nom--deux">Diamond Rings</figcaption>
            </figure>
            <figure class="infoArtiste">
                <img class="infoArtiste__img" src="../images/placeholder.png" alt="Jah & I">
                <div class="btnImages btnImages--bleu"></div>
                <figcaption class="infoArtiste__nom nom--trois">Jah & I</figcaption>
            </figure> -->
        </div>
        <div class="ctn-btn">
            <?php
            if($idStyle==0){
                if($id_page>1){
            ?>
            <a href='p-liste-anais.php?id_page=<?php echo ($id_page-1); ?>' class="arriere" >&#9664;</a>
            <?php }
            } else { ?>

            <a href='p-liste-anais.php?id_page=<?php echo ($id_page-1); ?>&id_style=<?php echo $idStyle; ?>' class="arriere" >&#9664;</a>
            <?php }
            ?>

            <?php
            if($idStyle==0){
            if($id_page<$nbPages){
            ?>
                <a href='p-liste-anais.php?id_page=<?php echo ($id_page+1); ?>' class="avant">&#9654;</a>
            <?php }
            } else { ?>
                <a href='p-liste-anais.php?id_page=<?php echo ($id_page+1); ?>&id_style=<?php echo $idStyle; ?>' class="avant">&#9654;</a>
            <?php }
            ?>
        </div>
    </section>

    <h2 class="titreSecondaire">En vedette:</h2>

        <ul class="ctn-suggestionArtiste">
            <?php for($cpt=0;$cpt<count($arrArtistesChoisis); $cpt++) { ?>
                <li class="ctn-suggestionArtiste__item">
                    <figure class="artisteSugg">
                        <img class="artisteSugg__img" src="../images/mini_placeholder.png" alt="<?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?>">
                        <figcaption class="artisteSugg__figcap">
                            <a class="artisteSugg__figcap__lien" href='<?php echo $niveau ?>artistes/fiche/p-fiche-prenom.php?id_artiste=<?php echo $arrArtistesChoisis[$cpt]["id_artiste"];?>'><?php echo $arrArtistesChoisis[$cpt]["nom_artiste"]; ?></a>
                        </figcaption>
                    </figure>
                </li>
            <?php } ?>
        </ul>

    <section class="styles">
        <div>
            <h3 class="titreSecondaireBis">Tous les styles</h3>
            <ul class="listeStyle">
                <?php
                for($intCpt1=0;$intCpt1<count($arrStyles);$intCpt1++){ ?>
                    <li class="listeStyle__item"><a class="listeStyle__lien" href='<?php echo "?id_style=".$arrStyles[$intCpt1]["id_style"]?>'><?php echo $arrStyles[$intCpt1]["nom_style"]?></a></li>
                <?php }
                ?>
            </ul>
        </div>
    </section>
</main>

<footer class="footer" role="contentinfo">
    <div class="logo-adresse">
        <img class="logo-adresse__logo" src="../images/logoOff_jaune.svg" alt="accueil">
        <p class="logo-adresse__adresse">110 boulevard René-Lévesque Ouest<br>C.P. 48036<br>QC, Québec, G1R 5R5</p>
    </div>
    <ul class="footerNav">
        <li class="footerNav__item"><a href="" class="footerNav__lien">Le OFF</a></li>
        <li class="footerNav__item"><a href="" class="footerNav__lien">Programmation</a></li>
        <li class="footerNav__item"><a href="" class="footerNav__lien">Artistes</a></li>
        <li class="footerNav__item"><a href="" class="footerNav__lien">Partenaires</a></li>
    </ul>
    <div class="informations">
        <a href="" class="informations__btn main__btn" type="button">Acheter mon passeport</a>
        <p class="informations__p">du 6 juillet au 10 juillet 2022</p>
        <a class="information__lien" href="">Formulaire d’abonnement à l’infolettre du festival</a>
        <div class="reseaux">
            <a class="reseaux__lien" href="facebook.com"><img class="reseaux__img" src="../images/reseaux/facebook.svg" alt="facebook"></a>
            <a class="reseaux__lien" href="twitter.com"><img class="reseaux__img" src="../images/reseaux/twitter.svg" alt="twitter"></a>
            <a class="reseaux__lien" href="youtube.com"><img class="reseaux__img" src="../images/reseaux/youtube.svg" alt="youtube"></a>
        </div>
    </div>
    <p class="footer__copyright">© 2009-2022 Festival OFF Tous droits réservés</p>
</footer>
<script src="../js/script_liste_artiste.js"></script>
</body>
</html>

