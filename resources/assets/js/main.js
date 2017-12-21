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

    $('form.comments-form').submit(function() {
        var comment = $(this).find('[name="remark"]').val();
        var username = $(this).find('[name="username"]').val();
        var listid = $(this).find('[name="listid"]').val();

        $.ajax({
            url: "/registercomment",
            type: 'GET',
            data: {
                idList: listid,
                comment: comment
            },
            dataType: 'json',
            context: this,
            error: function(result, status, error) {
                console.log('Error 500: couldn\'t comment!');
            },
            success: function(data) {
                var $comment = $('<div class="comment col-md-10 col-md-offset-1"><h5>Par <span>'+username+'</span> le '+new Date().toISOString().slice(0, 10)+' à '+new Date().toTimeString().split(' ')[0]+'</h5><p>'+comment+'</p></div>');
                $comment.hide();
                $(this).find('[name="remark"]').val('');
                $(this).remove();
                $('.comments').prepend($comment);
                $comment.fadeIn(500);
            }
        });

        return false;
    });

    $('.cart-master .delete-list').click(function() {
        var listid = $(this).data('listid');
        $.ajax({
            url: "/removefromcart/"+listid,
            type: 'GET',
            dataType: 'json',
            context: this,
            error: function(result, status, error) {
                console.log('Error 500: couldn\'t remove from cart!');
            },
            success: function(data) {
              $('#cart-list-'+listid).hide().html('<h1 style="font-size:2rem;"><i>Liste supprimée du panier.</i></h1>').fadeIn(250);
            }
        });
        return false;
    });

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
