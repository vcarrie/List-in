function Catalogue() {

    this.ready = false;
    this.busy = true;

    this.jsonTagsRoute = '/tagsnotempty';
    this.jsonListsRoute = '/research';
    this.addToCartRoute = '/addtocart';
    this.removeFromCartRoute = '/removefromcart';
    this.jsonCartRoute = '/getcart';
    this.catalogueStructRoute = '/catalogue-struct';
    this.typeaheadSuggestedTagsLimit = 6;
    this.tagsMap = {};
    this.tags = [];

    this.cardWidth = 280; // gathered from css
    this.lists = [];
    this.currentPage = 0; // 0 for page number 1
    this.amountOfListsDisplayableAtOnce = undefined; // calculated once so resizing the window doesn't disturb the pagination
    this.cart = []; // contains the id of the lists in cart
    this.queryTags = []; // contient les tags envoyés à fetchLists
    this.isPageCatalogue = true;

    // initialized
    this.setReady = function () {
        this.ready = true;
        console.log("Catalogue initialized.");
    };

    this.isReady = function () {
        return this.ready;
    };

    // request pending
    this.setBusy = function (status) {
        this.busy = status;
    };

    this.isBusy = function () {
        return this.busy;
    };

    this.queryDOM = function() {
        this.elemForm = $('#search-region form');
        this.elemMaster = $('.mid-content');
        this.elemContainer = $(this.elemMaster).find('.cards-container');
        this.elemTagsInput = $(this.elemForm).find('.tags-input');
        this.elemContainerHeader = $('.mid-content-header');
        this.elemSortSelect = $(this.elemContainerHeader).find('select[name="sorting_mode"]');
        this.elemContainerHeaderTitle = $(this.elemContainerHeader).find('#mid-content-header-title');
        this.elemPagination = $('.pagination');
    };

    this.init = function () {
        this.queryDOM();
        this.setContainerHeaderTitle('Initialisation...');

        // if the page is /list/{id}
        if ($('.list-detail').length > 0) {
            var $addToCartBtn = $('.list-options button');
            $addToCartBtn.click(function() {
                var listId = $addToCartBtn.attr('data-listId');
                if (this.isListInCart(listId)) {
                    this.removeFromCart(listId, $addToCartBtn);
                } else {
                    this.addToCart(listId, $addToCartBtn);
                }
                return false;
            }.bind(this));
            this.isPageCatalogue = false;
        }

        // if the page is /create/list
        if ($('#list-creation').length > 0) {
            console.log('<< list creation >>');
            this.elemTagsInput = $('#list-creation').find('.tags-input');
            this.jsonTagsRoute = '/tags';
            this.isPageCatalogue = false;
        }

        if (this.elemTagsInput) {

            if (this.elemForm.length > 0) {
                this.elemForm.submit(this.submitTags.bind(this));
            }

            $.ajax({
                url: this.jsonTagsRoute,
                type: 'GET',
                dataType: 'json',
                context: this,
                error: this.ajaxJsonTagsError,
                success: this.ajaxJsonTagsSuccess
            });

            $.ajax({
                url: this.jsonCartRoute,
                type: 'GET',
                dataType: 'json',
                context: this,
                error: this.ajaxGetCartError,
                success: function(data) {
                    this.cart = data || [];
                    console.log(this.cart.length + " items in cart.")
                }
            });

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

    this.ajaxGetCartError = function (result, status, error) {
        console.error('Error 500: cart items couldn\'t be retrieved.');
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
            this.listenToSortSelect();

            this.setReady();
            this.setBusy(false);
            if (this.isPageCatalogue) {
                this.populateDefault();
            }
        } catch (e) {
            console.log(e);
        }
    };

    this.populateDefault = function() {
        var randomTag = this.tags[~~(this.tags.length * Math.random())];
        console.log('Populating catalogue with tag: ' + randomTag + ' ' + this.tagsMap[randomTag]);
        this.setContainerHeaderTitle('Recherche de listes aléatoires en cours...');
        this.fetchLists([randomTag], 0, 0);
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
            var flagsAlreadyUsed = $('#search-region .tags-input').tagsinput('items') || $('.tags-input').tagsinput('items');

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
        return this.elemSortSelect ? this.elemSortSelect.val() || 0 : 0;
    };

    this.submitTags = function (e) {
        e.preventDefault();
        if (this.isReady()) {

            var tagsName = this.getSearchTagsName();
            var sort = this.getSearchSort();
            if (tagsName.length > 0) {
                this.fetchLists(tagsName, 0, sort);
            }

        }
        return false;
    };

    this.displayLoadingScreen = function () {
        $(this.elemContainer).html('<div class="loading_box"><img src="/public/images/loading_icon.gif"/></div>')
    };

    this.listenToSortSelect = function() {
        if ($('.mid-content .dropdown-menu li').length > 0) {
            console.log('Listening to changes on sort select.');
            var context = this;
            $('.mid-content .dropdown-menu li').mouseup(function() {
                if (!context.isBusy()) {
                    context.sortDisplayedLists($(this).attr('data-original-index'));
                } else {
                    console.warn('[Catalogue not ready to be sorted]');
                }
            });
        }
    };

    this.fetchLists = function (tagsName, pagination, sort) {
        var tagsId = this.tagsNameToId(tagsName);
        if (tagsId[0] !== undefined && !this.isBusy()) {
            this.setBusy(true);
            this.displayLoadingScreen();

            this.queryTags = tagsName;

            if (this.elemPagination.length === 0) {
                this.fetchListsAndStructure(tagsId, pagination, sort);
            } else {
                this.elemPagination.hide();
                this.fetchListsOnly(tagsId, pagination, sort);
            }
        }
    };

    this.fetchListsAndStructure = function(tagsId, pagination, sort) {
        console.log('Loading catalogue structure...');

        $.ajax({
            url: this.catalogueStructRoute,
            type: 'GET',
            dataType: 'html',
            context: this,
            error: function(result, status, error) {
                console.log('[Failed]');
            },
            success: function(data) {
                console.log('[Loaded]');
                this.elemMaster.html(data);
                this.queryDOM();
                this.setContainerHeaderTitle('Recherche en cours...');
                this.elemSortSelect.selectpicker();
                this.displayLoadingScreen();
                this.listenToSortSelect();

                this.fetchListsOnly(tagsId, pagination, sort);
            }
        });
    };

    this.fetchListsOnly = function (tagsId, pagination, sort) {
        console.log('Fetch Lists: ' + tagsId + ' &' + pagination + ' &' + sort);

        $.ajax({
            url: this.jsonListsRoute,
            type: 'GET',
            dataType: 'json',
            data: {
                tags: tagsId,
                pagination: pagination,
                sort: sort
            },
            context: this,
            error: this.fetchListsError,
            success: this.fetchListsSuccess
        });
    };

    this.fetchListsError = function (result, status, error) {
        console.error('Error 500: lists couldn\'t be retrieved.');

        this.clearListsContainer();
        this.setContainerHeaderTitle('Erreur interne (requête insoluble).');

        this.setBusy(false);
    };

    this.fetchListsSuccess = function(listsJson) {
        if (listsJson.lists && listsJson.lists.length > 0) {
            console.log('Fetch success!');
            this.lists = this.filterCorruptedLists(listsJson.lists);
            this.amountOfListsDisplayableAtOnce = this.getAmountOfListsDisplayableAtOnce()
            this.createPagination();
            this.displayPage(0);
        } else {
            this.clearListsContainer();
            this.setContainerHeaderTitle('Aucune liste ne correspond à ces tags.');
        }

        this.setBusy(false);
    };

    // cdiscount sometimes returns corrupted lists
    this.filterCorruptedLists = function(lists) {
        var corruptedListsId = [];
        var filteredLists = lists.filter(function(list) {
            for (var i in list.products) {
                if (!list.products[i][0].Products) {
                    corruptedListsId.push(list.list.id);
                    return false;
                }
            }
            return true;
        });
        if (corruptedListsId.length > 0) {
            console.log('Filtered out '+corruptedListsId.length+' corrupted lists: '+corruptedListsId.join(', '));
        }
        return filteredLists;
    };

    this.getContainerWidth = function() {
        return $(this.elemContainer).width();
    };

    this.getAmountOfListsDisplayableAtOnce = function() {
        return Math.floor(this.getContainerWidth() / this.cardWidth) || 1;
    };

    this.getAmoutOfPages = function() {
        return Math.ceil(this.lists.length / this.amountOfListsDisplayableAtOnce);
    };

    this.getDisplayableLists = function(page) {
        var x = this.amountOfListsDisplayableAtOnce;
        return this.lists.slice(page*x, page*x+x);
    };

    this.clearListsContainer = function() {
        $(this.elemContainer).html("");
    };

    this.setContainerHeaderTitle = function(t) {
        if (this.elemContainerHeader !== undefined && this.elemContainerHeader.length > 0) {
            $(this.elemContainerHeaderTitle).text(t);
        }
    };

    this.isListInCart = function(listId) {
        return this.cart.indexOf(''+listId) !== -1;
    };

    this.updateDisplayedLists = function (listsToDisplay, listsTotalAmount) {
        this.clearListsContainer();
        $(this.elemContainer).hide();
        var tagsAssociated = this.queryTags.join(', ');
        this.setContainerHeaderTitle('Il y a ' + listsTotalAmount + ' liste'+(listsTotalAmount>1?'s':'')+' associée'+(listsTotalAmount>1?'s':'')+' au'+(tagsAssociated.indexOf(',')!==-1?'x':'')+' tag'+(tagsAssociated.indexOf(',')!==-1?'s':'')+' "' + tagsAssociated + '"');

        for (var i in listsToDisplay) {
            var $cardHtml = this.templateListCard(listsToDisplay[i], this.isListInCart(listsToDisplay[i].list.id));
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
        $paginationBox.show();
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
        $pageCurrent.find('a').attr('title', 'Page '+(this.currentPage+1)).text(this.currentPage+1);

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
        if (this.lists.length !== 0) {
            this.currentPage = page;
            this.updateDisplayedLists(this.getDisplayableLists(this.currentPage), this.lists.length);
            this.updatePagination();
        }
    };

    this.sortDisplayedLists = function(sortMode) {
        console.log('Sorting lists: mode '+sortMode);

        sortMode = parseInt(sortMode, 10);

        switch(sortMode) {
            // by rating asc
            case 0:
                this.lists.sort(function(a, b) {
                    return b.rating - a.rating;
                });
                break;

            // by price asc
            case 1:
                this.lists.sort(function(a, b) {
                    return a.total_price - b.total_price;
                });
                break;

            // by price desc
            case 2:
                this.lists.sort(function(a, b) {
                    return b.total_price - a.total_price;
                });
                break;
        }

        this.displayPage(0);
    };

    this.templateListCard = function (listJson, isListInCart) {
        var $card = $('<div class="card"></div>');

        var $card_header = $('<div class="card-header"></div>');
        var $card_rating = $('<div title="'+listJson.rating*5+'" class="rateyo"></div>');
        $card_rating.rateYo({
            rating: listJson.rating,
            maxValue: "1",
            starWidth: "20px",
            normalFill: "#DDDDDD",
            ratedFill: "#E03913",
            readOnly: true
        });
        $card_header.append($card_rating);

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
        var $action_add_to_cart;
        if (!isListInCart) {
            $action_add_to_cart = $('<button>Ajouter au panier</button>');
        } else {
            $action_add_to_cart = $('<button class="btn-activated">Liste ajoutée</button>');
        }
        $action_add_to_cart.click(function (e) {
            if (this.isListInCart(listJson.list.id)) {
                this.removeFromCart(listJson.list.id, $action_add_to_cart);
            } else {
                this.addToCart(listJson.list.id, $action_add_to_cart);
            }
            return false;
        }.bind(this));

        $card.append($card_header).append($card_snapshots).append($card_body).append($card_footer).append($action_see_more).append($action_add_to_cart);
        return $card;
    };

    this.addToCart = function (listId, btnClicked) {
        console.log('"AddToCart" action for list ' + listId);
        $.ajax({
            url: this.addToCartRoute + '/' + listId,
            type: 'GET',
            dataType: 'json',
            context: { btnClicked: btnClicked, catalogue: this },
            error: this.addToCartError,
            success: this.addToCartSuccess
        });
    };

    this.addToCartError = function (result, status, error) {
        console.error('Error 500: list couldn\'t be added to cart.');
    };

    this.addToCartSuccess = function (response) {
        console.log('Cart contains lists '+response.join(", "));
        $(this.btnClicked).text('Liste ajoutée').addClass('btn-activated');
        this.catalogue.cart = response;
    };

    this.removeFromCart = function (listId, btnClicked) {
        console.log('"RemoveFromCart" action for list ' + listId);
        $.ajax({
            url: this.removeFromCartRoute + '/' + listId,
            type: 'GET',
            dataType: 'json',
            context: { btnClicked: btnClicked, catalogue: this },
            error: this.removeFromCartError,
            success: this.removeFromCartSuccess
        });
    };

    this.removeFromCartError = function (result, status, error) {
        console.error('Error 500: list couldn\'t be removed from cart.');
    };

    this.removeFromCartSuccess = function (response) {
        console.log('Cart contains lists '+response.join(", "));
        $(this.btnClicked).text('Ajouter au panier').removeClass('btn-activated');
        this.catalogue.cart = response;
    };

}
