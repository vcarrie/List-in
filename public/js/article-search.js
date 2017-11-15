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
        $('#result-region').empty();
        var results = data.Products;
        for (var i = 0; i < data.Products.length; i++) {
          var article = document.createElement('div');
          article.setAttribute("class", "");

          var image = document.createElement('img');
          image.setAttribute("src", results[i].MainImageUrl);

          var name = document.createElement('strong');
          var name_value = document.createTextNode(results[i].Name);
          name.appendChild(name_value);

          var desc = document.createElement('p');
          var desc_value = document.createTextNode(results[i].Description);
          desc.appendChild(desc_value);

          var price = document.createElement('p');
          var price_value = document.createTextNode(results[i].BestOffer.SalePrice + "€");
          price.appendChild(price_value);

          var add_button = document.createElement('button');
          var add_button_value = document.createTextNode("+");
          add_button.setAttribute("id", "add_article" + i);
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
      },
      error: function(a, b, errorThrown){
        console.log(a, b, errorThrown);
      },
      method: "POST"
    });
    return false;
  });
})();
