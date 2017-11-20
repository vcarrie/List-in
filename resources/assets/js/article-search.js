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
                    my_tr.appendChild(td_blank);///////
                    my_tr.appendChild(td_price);
                    my_tr.appendChild(td_blank2);//////
                    my_tr.appendChild(td_add);
                    my_tr.appendChild(td_blank3);//////
                    my_tr.appendChild(td_link);
                    table_container.appendChild(my_tr);

                    article.append(table_container);
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

                        var quantity = document.createElement('select');
                        quantity.setAttribute("name", "product[" + selected_article.Id + "][quantity]");
                        for (var j = 1; j < 21; j++) {
                            var option = document.createElement('option');
                            option.setAttribute("id", j);
                            option.text = j;
                            quantity.appendChild(option);
                        }

                        var selected_article_container = document.createElement('div');
                        selected_article_container.setAttribute("class", "article_container");

                        var selected_image = document.createElement('img');
                        selected_image.setAttribute("src", selected_article.MainImageUrl);

                        var selected_name = document.createElement('strong');
                        var selected_name_value = document.createTextNode(selected_article.Name);
                        selected_name.appendChild(selected_name_value);

                        var selected_desc = document.createElement('p');
                        var selected_desc_value = document.createTextNode(selected_article.Description);
                        selected_desc.appendChild(selected_desc_value);

                        var selected_price = document.createElement('p');
                        var selected_price_value = document.createTextNode(parseFloat(selected_article.BestOffer.SalePrice).toFixed(2) + " €");
                        selected_price.appendChild(selected_price_value);


                        selected_article_container.append(selected_image);
                        selected_article_container.append(selected_name);
                        selected_article_container.append(selected_desc);
                        selected_article_container.append(selected_price);
                        $('#selected-articles').append(selected_article_container);
                        $('#selected-articles').append(id_cdiscount);
                        $('#selected-articles').append(quantity);

                        article_count = 1;
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
        console.log(catalogue);
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
        return false;
    })
})();
