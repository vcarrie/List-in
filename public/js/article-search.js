(function () {

  this.ready = false;

  this.elemForm = $('#selected_tag');
  this.elemContainer = $('.mid-content .cards-container');
  this.elemTagsInput = $(this.elemForm).find('.tags-input');
  this.elemContainerHeader = $('.mid-content-header');
  this.elemSortSelect = $(this.elemContainerHeader).find('select[name="sorting_mode"]');
  this.elemContainerHeaderTitle = $(this.elemContainerHeader).find('h3');
  this.elemPagination = $('.pagination');
  this.jsonTagsRoute = '/tags';
  this.jsonListsRoute = '/research';
  this.addToCartRoute = '/addtocart';
  this.typeaheadSuggestedTagsLimit = 6;
  this.tagsMap = {};
  this.tags = [];

  this.cardWidth = 280; // gathered from css
  this.lists = [];
  this.currentPage = 0; // 0 for page number 1
  this.amountOfListsDisplayableAtOnce = undefined; // calculated once so resizing the window doesn't disturb the pagination


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

    $('#add_tag').click(function () {
        console.log($('.tags-input').val());
        return false;
    });


///////////////////////////////////////////////////



this.setReady = function () {
    this.ready = true;
    console.log("Catalogue initialized.");
};

this.isReady = function () {
    return this.ready;
};

this.init = function () {
    if (this.elemForm && this.elemContainer && this.elemTagsInput) {
        $.ajax({
            url: this.jsonTagsRoute,
            type: 'GET',
            dataType: 'json',
            context: this,
            error: this.ajaxJsonTagsError,
            success: this.ajaxJsonTagsSuccess
        });

        this.elemForm.submit(this.submitTags.bind(this));
    } else {
        this.initError();
    }
};

this.initError = function () {
    console.warn('No catalogue found on this page.');
};

this.ajaxJsonTagsError = function (result, status, error) {
    console.error('Error 500: tags couldn\'t be retrieved.');
};

this.ajaxJsonTagsSuccess = function (jsonTags, status) {
    for (var i in jsonTags) {
        var tag = jsonTags[i];
        this.tagsMap[tag.tagName] = tag.id;
        this.tags.push(tag.tagName);
    }

    try {
        this.buildTagsinput();
        this.buildTypeahead();

        this.setReady();
    } catch (e) {
        console.log(e);
    }
};

this.typeaheadSubstringMatcher = function (strs) {
    return function findMatches(q, cb) {
        var matches, strictMatches, lazyMatches,
            substrRegex_strictSearch, substrRegex_lazySearch;

        // an array that will be populated with substring matches
        strictMatches = [];
        lazyMatches = [];

        // regex used to determine if a string contains the substring `q`
        substrRegex_strictSearch = new RegExp('^' + q, 'i');
        substrRegex_lazySearch = new RegExp(q, 'i');

        // we don't want to suggest tags already in the input
        var flagsAlreadyUsed = $('#selected_tag').tagsinput('items');

        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        $.each(strs, function (i, str) {
            if (!flagsAlreadyUsed.includes(str)) {
                if (substrRegex_lazySearch.test(str)) {
                    if (substrRegex_strictSearch.test(str)) {
                        // the typeahead jQuery plugin expects suggestions to a
                        // JavaScript object, refer to typeahead docs for more info
                        strictMatches.push({value: str});
                    } else {
                        lazyMatches.push({value: str});
                    }
                }
            }
        });

        // if there are no strings starting with the query,
        // this at least returns ones that contains the query
        matches = strictMatches.concat(lazyMatches);

        cb(matches);
    };
};

this.typeaheadTagNotFoundTemplate = function (q) {
    return '<div class="tt-empty">Le tag <span>"' + q.query + '"</span> n\'existe pas.</div>'
};

this.buildTagsinput = function () {
    this.elemTagsInput.tagsinput();

    //  double context
    var context = this;
    $('span.popular-tag').click(function () {
        context.elemTagsInput.tagsinput('add', $(this).text());
    });
};

this.buildTypeahead = function () {
    // the real input that is typed in
    var elemTagInput = this.elemTagsInput.tagsinput('input');

    elemTagInput.typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
        autoselect: true
    }, {
        limit: this.typeaheadSuggestedTagsLimit,
        name: 'availableTags',
        displayKey: 'value',
        source: this.typeaheadSubstringMatcher(this.tags),
        templates: {
            notFound: this.typeaheadTagNotFoundTemplate
        }
    }).bind('typeahead:selected', $.proxy(function (obj, datum) {
        // if the tag is clicked, add it to tagsinput and clear input
        this.elemTagsInput.tagsinput('add', datum.value);
        elemTagInput.typeahead('val', '');
    }.bind(this)));

    // ensure that a valid tag is being entered
    this.elemTagsInput.on('itemAdded', function (event) {
        if (this.tags.indexOf(event.item) < 0) {
            this.elemTagsInput.tagsinput('remove', event.item);
        }
    }.bind(this));

    // erase any entered text on blur
    $(elemTagInput).blur(function () {
        elemTagInput.typeahead('val', '');
    });
};

// bootstrap tagsinput 'obj as tags' is too messy so I use a map
this.tagsNameToId = function (tags) {
    var ids = [];
    for (var i in tags) {
        ids.push(this.tagsMap[tags[i]]);
    }
    return ids;
};

this.getSearchTagsChained = function () {
    return this.elemTagsInput.val();
};

this.getSearchTagsName = function () {
    return this.getSearchTagsChained().split(',');
};

this.getSearchTagsIds = function () {
    return this.tagsNameToId(this.getSearchTagsName());
};

this.getSearchSort = function () {
    return this.elemSortSelect ? this.elemSortSelect.val() : 0;
};

this.submitTags = function (e) {
    e.preventDefault();
    if (this.isReady()) {

        var tags = this.getSearchTagsIds();
        var sort = this.getSearchSort();
        if (tags.length > 0) {
            this.fetchLists(tags, 0, sort);
        }

    }
    return false;
};

this.displayLoadingScreen = function () {
    $(this.elemContainer).html('<div class="loading_box"><img src="/public/images/loading_icon.gif"/></div>')
};

this.fetchLists = function (tags, pagination, sort) {
    console.log('Fetch Lists: ' + tags + ' &' + pagination + ' &' + sort);
    $.ajax({
        url: this.jsonListsRoute,
        type: 'GET',
        dataType: 'json',
        data: {
            tags: tags,
            pagination: pagination,
            sort: sort
        },
        context: this,
        beforeSend: this.displayLoadingScreen,
        error: this.fetchListsError,
        success: this.fetchListsSuccess
    });
};

this.fetchListsError = function (result, status, error) {
    console.error('Error 500: lists couldn\'t be retrieved.');
};

this.fetchListsSuccess = function(listsJson) {
    this.lists = listsJson.lists;
    this.amountOfListsDisplayableAtOnce = this.getAmountOfListsDisplayableAtOnce()
    this.createPagination();
    this.displayPage(0);
};

this.getContainerWidth = function() {
    return $(this.elemContainer).width();
};

this.getAmountOfListsDisplayableAtOnce = function() {
    return Math.floor(this.getContainerWidth() / this.cardWidth);
};

this.getAmoutOfPages = function() {
    return Math.ceil(this.lists.length / this.amountOfListsDisplayableAtOnce);
};

this.getDisplayableLists = function(page) {
    var x = this.amountOfListsDisplayableAtOnce;
    return this.lists.slice(page*x, page*x+x);
};

this.updateDisplayedLists = function (listsToDisplay, listsTotalAmount) {
    $(this.elemContainer).html("").hide();
    $(this.elemContainerHeaderTitle).text('Il y a ' + listsTotalAmount + ' listes associées aux tags "' + this.getSearchTagsChained().replace(',', ', ') + '"');

    for (var i in listsToDisplay) {
        var $cardHtml = this.templateListCard(listsToDisplay[i]);
        $(this.elemContainer).append($cardHtml);
    }

    $(this.elemContainer).fadeIn(500);
};

this.createPagination = function() {
    var $paginationBox = $(this.elemPagination);
    if (!$paginationBox.attr('data-ready')) {
        var $pageFirst = $('<li class="disabled"><a title="Première page" href="#">&laquo;</a></li>');
        $pageFirst.click(this.goToFirstPage.bind(this));
        var $pagePrevious = $('<li class="disabled"><a title="Page précédente" href="#">&lsaquo;</a></li>');
        $pagePrevious.click(this.goToPreviousPage.bind(this));
        var $pageCurrent = $('<li class="active"><a title="Page 1" href="#">1</a></li>');
        var $pageNext = $('<li class="disabled"><a title="Page suivante" href="#">&rsaquo;</a></li>');
        $pageNext.click(this.goToNextPage.bind(this));
        var $pageLast = $('<li class="disabled"><a title="Dernière page" href="#">&raquo;</a></li>');
        $pageLast.click(this.goToLastPage.bind(this));

        $paginationBox.append($pageFirst).append($pagePrevious).append($pageCurrent).append($pageNext).append($pageLast);
        $paginationBox.attr('data-ready', true);
    }
};

this.goToFirstPage = function() {
    if (this.currentPage > 0) {
        this.displayPage(0);
    }
    return false;
};

this.goToPreviousPage = function() {
    if (this.currentPage > 0) {
        this.displayPage(this.currentPage-1);
    }
    return false;
};

this.goToNextPage = function() {
    if (this.currentPage < this.getAmoutOfPages()-1) {
        this.displayPage(this.currentPage+1);
    }
    return false;
};

this.goToLastPage = function() {
    if (this.currentPage < this.getAmoutOfPages()-1) {
        this.displayPage(this.getAmoutOfPages()-1);
    }
    return false;
};

this.updatePagination = function() {
    var $paginationBox = $(this.elemPagination);

    var $pageCurrent = $paginationBox.find('li:nth-child(3)');
    $pageCurrent.find('a').attr('title', 'Page '+this.currentPage+1).text(this.currentPage+1);

    var $pageFirst = $paginationBox.find('li:nth-child(1)');
    var $pagePrevious = $paginationBox.find('li:nth-child(2)');
    if (this.currentPage === 0) {
        $pageFirst.addClass('disabled');
        $pagePrevious.addClass('disabled');
    } else {
        $pageFirst.removeClass('disabled');
        $pagePrevious.removeClass('disabled');
    }

    var $pageLast = $paginationBox.find('li:nth-child(4)');
    var $pageNext = $paginationBox.find('li:nth-child(5)');
    if (this.currentPage === this.getAmoutOfPages()-1) {
        $pageLast.addClass('disabled');
        $pageNext.addClass('disabled');
    } else {
        $pageLast.removeClass('disabled');
        $pageNext.removeClass('disabled');
    }
};

this.displayPage = function(page) {
    this.currentPage = page;
    this.updateDisplayedLists(this.getDisplayableLists(this.currentPage), this.lists.length);
    this.updatePagination();
};

this.templateListCard = function (listJson) {
    var $card = $('<div class="card"></div>');
    var $card_header = $('<div class="card-header"><div class="star-ratings-sprite"><span style="width: ' + (listJson.rating * 100) + '%" class="star-ratings-sprite-rating"></span></div></div>');

    var $card_snapshots = $('<div class="card-snapshots"></div>');
    if (listJson.nb_products > 0) {
        $card_snapshots.append($('<img alt="" src="' + listJson.products[0][0].Products[0].MainImageUrl + '"/>'));
        if (listJson.nb_products > 1) {
            $card_snapshots.append($('<img alt="" src="' + listJson.products[1][0].Products[0].MainImageUrl + '"/>'));
            if (listJson.nb_products > 2) {
                $card_snapshots.append($('<img alt="" src="' + listJson.products[2][0].Products[0].MainImageUrl + '"/>'));
                if (listJson.nb_products > 3) {
                    $card_snapshots.append($('<span>+' + (listJson.nb_products - 3) + '</span>'));
                    $card_snapshots.css('text-align', 'left');
                }
            }
        }
    }

    var $card_body = $('<div class="card-body"><h4 title="' + listJson.list.listName + '">' + listJson.list.listName + '</h4><p>' + listJson.list.description + '</p></div>');
    var $card_footer = $('<div class="card-footer"><table><tr><td></td><td class="card-price" rowspan="2">' + listJson.total_price + ' €</td></tr><tr><td class="card-item-count">' + listJson.nb_products + ' articles</td></tr></table></div>');
    var $action_see_more = $('<a href="/list/'+listJson.list.id+'">Voir la liste</a>');
    var $action_add_to_cart = $('<button>Ajouter au panier</button>');
    $action_add_to_cart.click(function (e) {
        this.addToCart(listJson.list.id);
        return false;
    });

    $card.append($card_header).append($card_snapshots).append($card_body).append($card_footer).append($action_see_more).append($action_add_to_cart);
    return $card;
};

this.addToCart = function (listId) {
    console.log('"AddToCart" action for list ' + listId);
    $.ajax({
        url: this.addToCartRoute,
        type: 'POST',
        dataType: 'json',
        data: {
            listId: listId
        },
        context: this,
        error: this.addToCartError,
        success: this.addToCartSuccess
    });
};

this.addToCartError = function (result, status, error) {
    console.error('Error 500: list couldn\'t be added to cart.');
};

this.addToCartSuccess = function (response) {
    console.log('List added to cart!')
};

///////////////////////////////////////////////////////////
})();
