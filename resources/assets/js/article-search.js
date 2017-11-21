(function () {
    $('#go-search').click(function (e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/getproductbykeyword",
            data: {
                search: $('#search-bar').val()
            },
            dataType: "json",
            success: function (data) {

                // Affichage des resultats de la recherche
                $('#result-region').empty();
                var results = data.Products;
                for (var i = 0; i < data.Products.length; i++) {
                    var article = document.createElement('div');
                    article.setAttribute("id", "article" + i);

                    var table_container = document.createElement('table');
                    var my_tr = document.createElement('tr');
                    var td_img = document.createElement('td');
                    var td_name = document.createElement('td');
                    var td_price = document.createElement('td');
                    var td_add = document.createElement('td');
                    var td_link = document.createElement('td');

                    var td_blank = document.createElement('td');
                    td_blank.setAttribute("width", "20px");
                    var td_blank2 = document.createElement('td');
                    td_blank2.setAttribute("width", "20px");
                    var td_blank3 = document.createElement('td');
                    td_blank3.setAttribute("width", "20px");

                    var image = document.createElement('img');
                    image.setAttribute("src", results[i].MainImageUrl);
                    image.setAttribute("alt", "imageProduit");
                    image.setAttribute('width', "75px");
                    td_img.appendChild(image);
                    td_img.setAttribute('width', "100px");

                    var name = document.createElement('p');
                    var name_value = document.createTextNode(results[i].Name);
                    name.setAttribute("class", "article_name");
                    name.appendChild(name_value);
                    td_name.appendChild(name);
                    td_name.setAttribute('width', "530px");

                    var price = document.createElement('p');
                    var price_value = document.createTextNode(parseFloat(results[i].BestOffer.SalePrice).toFixed(2) + " €");
                    price.appendChild(price_value);
                    td_price.appendChild(price);
                    td_price.setAttribute('width', "80px");

                    var add_button = document.createElement('button');
                    var add_button_value = document.createTextNode("+");
                    add_button.setAttribute("id", i);
                    add_button.setAttribute("class", "resultToSelection");
                    add_button.appendChild(add_button_value);
                    td_add.appendChild(add_button);

                    var link = document.createElement('a');
                    var link_value = document.createTextNode("Lien CDiscount");
                    link.setAttribute("href", results[i].BestOffer.ProductURL);
                    link.setAttribute("target", "blank");
                    link.appendChild(link_value);
                    td_link.appendChild(link);


                    my_tr.appendChild(td_img);
                    my_tr.appendChild(td_name);
                    my_tr.appendChild(td_blank);
                    my_tr.appendChild(td_price);
                    my_tr.appendChild(td_blank2);
                    my_tr.appendChild(td_add);
                    my_tr.appendChild(td_blank3);
                    my_tr.appendChild(td_link);
                    table_container.appendChild(my_tr);
                    article.append(table_container);


                    // Append partie recherche
                    $('#result-region').append(article);
                    $('#result-region div').css({"border-style": "solid", "border-width": "1px 1px 1px 1px"});
                    if(i%2==0)
                      $('#result-region #article'+i).css({"background-color": "#D5D5D5"});
                    else
                      $('#result-region #article'+i).css({"background-color": "#F8F8F8"});

                }

                // Ajout produit sÃ©lectionnÃ© dans div selection
                $('.resultToSelection').click(function () {
                    var article_count = 0;
                    var button_index = $(this).attr('id');
                    var selected_article = results[button_index];

                    if (article_count === 0) {
                        $('.no-article').css("display", "none");
                    }

                    var already_exists = false;
                    var double_article = document.getElementsByClassName('id_cdiscount');
                    for (var i = 0; i < double_article.length; i++) {
                        if (double_article[i].value === selected_article.Id) {
                            already_exists = true;
                        }
                    }

                    if (!already_exists) {
                        var id_cdiscount = document.createElement('input');
                        id_cdiscount.setAttribute("class", "id_cdiscount");
                        id_cdiscount.setAttribute("type", "hidden");
                        id_cdiscount.setAttribute("name", "product[" + selected_article.Id + "][id]");
                        id_cdiscount.value = selected_article.Id;

                        var quantity = $('<select></select>');
                        quantity.attr("name", "product[" + selected_article.Id + "][quantity]");
                        for (var j = 1; j < 21; j++) {
                            var option = $('<option></option>');
                            option.attr("id", j);
                            option.html(j);
                            quantity.append(option);
                        }

                        /*quantity.change(function(){
                          $("#")
                        })*/

                        var $article_cardHtml = templateProductCard(selected_article);
                        $('#selected-articles').append($article_cardHtml);
                        $('#quantity_select'+selected_article.Id).append(quantity);
                        $('#quantity_select'+selected_article.Id).append(id_cdiscount);

                        article_count = 1;


                        var recap_article = document.createElement('div');
                        recap_article.setAttribute("id", selected_article.Id);

                        var table_recap_container = document.createElement('table');
                        var recap_tr = document.createElement('tr');
                        var recap_td_img = document.createElement('td');
                        var recap_td_name = document.createElement('td');
                        var recap_td_price = document.createElement('td');
                        var recap_td_quantity = document.createElement('td');

                        var recap_td_blank = document.createElement('td');
                        recap_td_blank.setAttribute("width", "20px");
                        var recap_td_blank2 = document.createElement('td');
                        recap_td_blank2.setAttribute("width", "20px");

                        var recap_image = document.createElement('img');
                        recap_image.setAttribute("src", selected_article.MainImageUrl);
                        recap_image.setAttribute("alt", "imageRecapProduit");
                        recap_image.setAttribute('width', "75px");
                        recap_td_img.appendChild(recap_image);
                        recap_td_img.setAttribute('width', "100px");

                        var recap_name = document.createElement('p');
                        var recap_name_value = document.createTextNode(selected_article.Name);
                        recap_name.setAttribute("class", "article_name");
                        recap_name.appendChild(recap_name_value);
                        recap_td_name.appendChild(recap_name);
                        recap_td_name.setAttribute('width', "530px");

                        var la_valeur = 1;
                        var recap_quantity = document.createElement('p');
                        var recap_quantity_value = document.createTextNode(la_valeur);
                        recap_quantity.setAttribute("class", "article_quantity");
                        recap_quantity.appendChild(recap_quantity_value);
                        recap_td_quantity.appendChild(recap_quantity);
                        recap_td_quantity.setAttribute('width', "150px");

                        var total_node = document.createElement('p');
                        var total_node_value = document.createTextNode("Total :");
                        var recap_price = document.createElement('strong');
                        var recap_price_value = document.createTextNode(parseFloat(selected_article.BestOffer.SalePrice).toFixed(2) + " €");
                        total_node.appendChild(total_node_value);
                        recap_price.appendChild(recap_price_value);
                        recap_td_price.appendChild(total_node);
                        recap_td_price.appendChild(recap_price);
                        recap_td_price.setAttribute('width', "150px");
                        recap_td_price.style.textAlign = "center";


                        recap_tr.appendChild(recap_td_img);
                        recap_tr.appendChild(recap_td_name);
                        recap_tr.appendChild(recap_td_blank);
                        recap_tr.appendChild(recap_td_price);
                        recap_tr.appendChild(recap_td_blank2);
                        table_recap_container.appendChild(recap_tr);
                        recap_article.append(table_recap_container);

                        // Append partie recap
                        $('#recap-articles').append(recap_article);
                        $('#recap-articles div').css({"border-style": "solid", "border-width": "1px 1px 1px 1px"});
                    }

                    return false;
                });
            },
            error: function (a, b, errorThrown) {
                console.log(a, b, errorThrown);
            },
            method: "POST"
        });
        return false;
    });

    $('#next-step').click(function () {
        $('#step-one').css("display", "none");
        $('#step-two').css("display", "block");
    });

    $('#previous-step').click(function () {
        $('#step-one').css("display", "block");
        $('#step-two').css("display", "none");
    });

    $('#list_validate').click(function(){
        var selected_tags = catalogue.getSearchTagsIds();
        var content = document.getElementById('hidden-container');
        for(var i = 0; i < selected_tags.length; i++){
          var hidden = document.createElement('input');
          hidden.setAttribute("id", "tag" + selected_tags[i]);
          hidden.setAttribute("type", "hidden");
          hidden.setAttribute("name", "selected_tags[]");
          hidden.value = selected_tags[i];
          content.appendChild(hidden);
        }
        $('#list-creation').submit();
    })


    this.templateProductCard = function (productJson) {
        var $card = $('<div id="container-' + productJson.Id + '" class="card"></div>');

        var $card_snapshots = $('<div class="card-snapshots"></div>');
        if (productJson.MainImageUrl != null) {
            $card_snapshots.append($('<img alt="" src="' + productJson.MainImageUrl + '"/>'));
            $card_snapshots.css('text-align', 'center');
        }

        var $card_body = $('<div class="card-body"><h4 title="' + productJson.Name + '">' + productJson.Name + '</h4><p>' + productJson.Description + '</p></div>');
        var $card_footer = $('<div class="card-footer"><table><tr><td id="quantity_select'+ productJson.Id+'"></td><td class="card-price" rowspan="2">' + parseFloat(productJson.BestOffer.SalePrice).toFixed(2) + ' €</td></tr></table></div>');
        var $action_delete_from_cart = $('<button id="button-'+ productJson.Id +'">Supprimer</button>');
        $action_delete_from_cart.click(function (e) {
            $('#container-'+ productJson.Id).remove();
            return false;
        })

        $card.append($card_snapshots).append($card_body).append($card_footer).append($action_delete_from_cart);

        return $card;
    };
})();
