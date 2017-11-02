$(function () {

    var catalogue = new Catalogue('#search-region form', '.mid-content .cards-container');
    catalogue.init();

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
