function Catalogue() {

    this.ready = false;

    this.elemForm = $('#search-region form');
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
            var flagsAlreadyUsed = $('#search-region .tags-input').tagsinput('items');

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
            success: this.updateDisplayedLists
        });
    };

    this.fetchListsError = function (result, status, error) {
        console.error('Error 500: lists couldn\'t be retrieved.');
    };

    this.updateDisplayedLists = function (listsJson) {
        $(this.elemContainer).html("").hide();
        $(this.elemContainerHeaderTitle).text('Il y a ' + listsJson.nb_list_total + ' listes associées aux tags "' + this.getSearchTagsChained().replace(',', ', ') + '"');

        for (var i in listsJson.lists) {
            var $cardHtml = this.templateListCard(listsJson.lists[i]);
            $(this.elemContainer).append($cardHtml);
        }

        $(this.elemContainer).fadeIn(500);
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
        var $action_see_more = $('<button>Voir la liste</button>');
        var $action_add_to_cart = $('<button>Ajouter au panier</button>');
        $action_add_to_cart.click(function (e) {
            this.addToCart(listJson.id);
            return false;
        });

        $card.append($card_header).append($card_snapshots).append($card_body).append($card_footer).append($action_see_more).append($action_add_to_cart);
        return $card;
    };

    this.updatePagination = function (currentPage, totalPage) {
        /*
        var $pageFirst = $('<li class="disabled"><a title="Première page" href="#">&laquo;</a></li>');
        var $pagePrevious = $('<li class="disabled"><a title="Page précédente" href="#">&lsaquo;</a></li>');
        var $pageCurrent = $('<li class="active"><a title="Page 1" href="#">1</a></li>');
        var $pageNext = $('<li class="disabled"><a title="Page suivante" href="#">&rsaquo;</a></li>');
        var $pageLast = $('<li class="disabled"><a title="Dernière page" href="#">&raquo;</a></li>');
        */
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

}
