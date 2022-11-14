/**
 * @file Un menu simple, responsive bâti en amélioration progressive.
 * @version v3.1 Mise à jour le 7 février :: changement du préfixe tag pour ref !
 * @author TIMCSF
 * @todo Problème: si le menu est fermé, les liens de menu ne devrait pas être dans l'ordre de tabulation?
 */

//*******************
// Déclaration d'objet(s)
//*******************

console.log(strPhp);

let menu = {
    javascriptEnabled: document.body.classList.add('js'),
    strNavClosed: 'Menu',
    strNavOpen: 'Fermer',
    strSourceClosed: 'images/icone_menu.svg',
    strSourceOpen: 'images/icone_fermer_menu.svg',
    refButton: null,
    refSpan: null,
    refIcone: null,
    refNav: document.querySelector('.ctn_nav'),


    configurerNav: function () {
        //********** Création du bouton du menu mobile

        // On crée VIRTUELLEMENT un bouton et un span (pour le texte du bouton)
        this.refButton = document.createElement('button');
        this.refSpan = document.createElement('span');
        this.refIcone = document.createElement('img');

        // On ajoute le span dans le bouton
        this.refButton.appendChild(this.refIcone);
        this.refButton.appendChild(this.refSpan);

        // On ajoute des classes au Button et au span
        this.refButton.className = 'nav__control';
        this.refSpan.className = 'nav__span';
        this.refIcone.className = 'nav__img';

        // On place le texte du Button dans son conteneur span
        this.refIcone.src = strPhp+this.strSourceClosed;
        this.refSpan.innerHTML = this.strNavClosed;

        // On ajoute le Button dans le html:
        // plus précisément comme premier enfant dans le nav
        this.refNav.prepend(this.refButton);

        // Ajout de l'écouteur d'événement sur le bouton du menu
        this.refButton.addEventListener('click', function () {
            menu.ouvrirFermerNav();
        });

        // ajouter la classe d'état fermé au menu
        this.refNav.classList.add('nav--closed');
    },

    ouvrirFermerNav: function () {
        // On bascule (ajoute ou enlève) la classe de fermeture du menu
        this.refNav.classList.toggle('nav--closed');

        // On change le texte du bouton selon l'état du menu
        if (this.refNav.classList.contains('nav--closed')) {
            this.refSpan.innerHTML = this.strNavClosed;
            this.refIcone.src = strPhp+this.strSourceClosed;
        } else {
            this.refSpan.innerHTML = this.strNavOpen;
            this.refIcone.src = strPhp+this.strSourceOpen;
        }
        console.log(strPhp+this.strNavOpen);
        console.log(strPhp+this.strNavClosed);
    }
};


//*******************
// Écouteurs d'événements
//*******************
window.addEventListener('load', function () {
    menu.configurerNav();
});
