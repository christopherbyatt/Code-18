<?php
;
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
            <figure class="infoArtiste">
                <img class="infoArtiste__img" src="../images/placeholder.png" alt="Cabaret Olibrius">
                <div class="btnImages btnImages--jaune"></div>
                <figcaption class="infoArtiste__nom nom--un"> <a href="">Cabaret Olibrius</a> </figcaption>
            </figure>
            <figure class="infoArtiste">
                <img class="infoArtiste__img" src="../images/placeholder.png" alt="Diamond Rings">
                <div class="btnImages btnImages--orange"></div>
                <figcaption class="infoArtiste__nom nom--deux">Diamond Rings</figcaption>
            </figure>
            <figure class="infoArtiste">
                <img class="infoArtiste__img" src="../images/placeholder.png" alt="Jah & I">
                <div class="btnImages btnImages--bleu"></div>
                <figcaption class="infoArtiste__nom nom--trois">Jah & I</figcaption>
            </figure>
        </div>
        <div class="ctn-btn">
            <button class="arriere" type="button">&#9664;</button>
            <button class="avant" type="button">&#9654;</button>
        </div>
    </section>
</main>

<footer class="footer" role="contentinfo">
    <div class="logo-adresse">
        <img class="logo-adresse__logo" src="../images/logoOff_jaune.svg" alt="accueil">
        <p class="logo-adresse__adresse">110 boulevard René-Lévesque Ouest<br>C.P. 48036<br>QC, Québec, G1R 5R5</p>
    </div>
    <ul class="footerNav">
        <li class="footerNav__item"><a class="footerNav__lien">Le OFF</a></li>
        <li class="footerNav__item"><a class="footerNav__lien">Programmation</a></li>
        <li class="footerNav__item"><a class="footerNav__lien">Artistes</a></li>
        <li class="footerNav__item"><a class="footerNav__lien">Partenaires</a></li>
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

