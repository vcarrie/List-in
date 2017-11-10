$(function () {

    var catalogue = new Catalogue('#search-region form', '.mid-content .cards-container');
    catalogue.init();

    var contact = new Contact();
    contact.init();

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
