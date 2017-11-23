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
            $.ajax({
                url: "/registerrate",
                type: 'GET',
                data: {
                    idList: $(this).data('list-id'),
                    rating: rating
                },
                dataType: 'json',
                context: this,
                error: function(result, status, error) {
                    console.log('Error 500: couldn\'t rate list!');
                },
                success: function(data) {
                    $('.list-rating > span').hide().text('Vous avez noté cette liste le : '+ new Date().toISOString().slice(0, 10)).fadeIn(200);
                }
            });
        }
    });

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
