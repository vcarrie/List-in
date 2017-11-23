var catalogue = undefined;

$(function () {

    catalogue = new Catalogue();
    catalogue.init();

    $('.list-images img').click(function() {
    	var item_id = $(this).attr('data-bind');
    	$('.list-detail .card').addClass('hidden');
    	$('#'+item_id).removeClass('hidden');
    });

    $('.list-rating .rateyo').rateYo({
        starWidth: '30px',
        normalFill: '#DDDDDD',
        ratedFill: '#E03913',
        fullStar: true,
        maxValue: 5,
        onSet: function (rating, rateYoInstance) {
            $('.list-rating > span').text('Vous avez noté cette liste le : fonctionnalité non implémentée.');
            /*$.ajax({
                url: this.jsonTagsRoute,
                type: 'GET',
                dataType: 'json',
                context: this,
                error: this.ajaxJsonTagsError,
                success: this.ajaxJsonTagsSuccess
            });*/
        }
    });

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
