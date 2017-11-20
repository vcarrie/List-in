var catalogue = undefined;

$(function () {

    catalogue = new Catalogue();
    catalogue.init();

    $('.list-images img').click(function() {
    	var item_id = $(this).attr('data-bind');
    	$('.list-detail .card').addClass('hidden');
    	$('#'+item_id).removeClass('hidden');
    });

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
