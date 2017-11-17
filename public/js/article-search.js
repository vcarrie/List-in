(function () {
  $('#go-search').click(function(e){
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
      success: function(data){

        // Affichage des resultats de la recherche
        $('#result-region').empty();
        var results = data.Products;
        for (var i = 0; i < data.Products.length; i++) {
          var article = document.createElement('div');
          article.setAttribute("id", "article" + i);

          var image = document.createElement('img');
          image.setAttribute("src", results[i].MainImageUrl);

          var name = document.createElement('strong');
          var name_value = document.createTextNode(results[i].Name);
          name.appendChild(name_value);

          var desc = document.createElement('p');
          var desc_value = document.createTextNode(results[i].Description);
          desc.appendChild(desc_value);

          var price = document.createElement('p');
          var price_value = document.createTextNode(parseFloat(results[i].BestOffer.SalePrice).toFixed(2) + " €");
          price.appendChild(price_value);

          var add_button = document.createElement('button');
          var add_button_value = document.createTextNode("+");
          add_button.setAttribute("id", i);
          add_button.setAttribute("class", "resultToSelection");
          add_button.appendChild(add_button_value);

          var link = document.createElement('a');
          var link_value = document.createTextNode("Lien CDiscount");
          link.setAttribute("href", results[i].BestOffer.ProductURL);
          link.setAttribute("target", "blank");
          link.appendChild(link_value);

          article.append(image);
          article.append(name);
          article.append(desc);
          article.append(price);
          article.append(add_button);
          article.append(link);
          $('#result-region').append(article);
        }

        // Ajout produit sélectionné dans div selection
        $('.resultToSelection').click(function(){
          var article_count = 0;
          var button_index = $(this).attr('id');
          var selected_article = results[button_index];

          if(article_count == 0){
            $('.no-article').css("display", "none");
          }

          var already_exists = false;
          var double_article = document.getElementsByClassName('id_cdiscount');
          for (var i = 0; i < double_article.length; i++) {
            if(double_article[i].value == selected_article.Id){
              already_exists = true;
            }
          }

          if(!already_exists){
            var id_cdiscount = document.createElement('input');
            id_cdiscount.setAttribute("class", "id_cdiscount");
            id_cdiscount.setAttribute("type", "hidden");
            id_cdiscount.setAttribute("name", "product[" + selected_article.Id + "][id]");
            id_cdiscount.value = selected_article.Id;

            var quantity = document.createElement('select');
            quantity.setAttribute("name", "product[" + selected_article.Id + "][quantity]");
            for (var i = 1; i < 21; i++) {
              var option= document.createElement('option');
              option.setAttribute("id", i);
              option.text = i;
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
      error: function(a, b, errorThrown){
        console.log(a, b, errorThrown);
      },
      method: "POST"
    });
    return false;
  });

  $('#next-step').click(function(){
    $('#step-one').css("display", "none");
    $('#step-two').css("display", "block");
  })

  $('#previous-step').click(function(){
    $('#step-one').css("display", "block");
    $('#step-two').css("display", "none");
  })

  $('#add_tag').click(function(){
    console.log($('.tags-input').val());
    return false;
  })
})();
