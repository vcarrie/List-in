function Catalogue() {

    this.ready = false;

	this.elemForm = $('#search-region form');
	this.elemContainer = $('.mid-content .cards-container');
	this.elemTagsInput = $(this.elemForm).find('input.tags-input');
	this.elemSortSelect = $('select[name="sorting_mode"]');
    this.jsonTagsRoute = '/tags';
    this.jsonListsRoute = '/research';
	this.typeaheadSuggestedTagsLimit = 6;
	this.tagsMap = {};
	this.tags = [];

    this.setReady = function() {
        this.ready = true;
        console.log("Catalogue initialized.");
    };

    this.isReady = function() {
        return this.ready;
    };

    this.init = function() {
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

    this.initError = function() {
        console.warn('No catalogue found on this page.');
    };

    this.ajaxJsonTagsError = function(result, status, error) {
        console.error('Error 500: tags couldn\'t be retrieved.');
    };

    this.ajaxJsonTagsSuccess = function(jsonTags, status) {
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

    this.typeaheadSubstringMatcher = function(strs) {
		return function findMatches(q, cb) {
            var matches, strictMatches, lazyMatches,
                substrRegex_strictSearch, substrRegex_lazySearch;

            // an array that will be populated with substring matches
            strictMatches = [];
            lazyMatches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex_strictSearch = new RegExp('^'+q, 'i');
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
                        strictMatches.push({ value: str });
                    } else {
                        lazyMatches.push({ value: str });
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

    this.typeaheadTagNotFoundTemplate = function(q) {
      	return '<div class="tt-empty">Le tag <span>"'+q.query+'"</span> n\'existe pas.</div>'
    };

    this.buildTagsinput = function() {
    	this.elemTagsInput.tagsinput();

    	//  double context
    	var context = this;
    	$('span.popular-tag').click(function() {
            context.elemTagsInput.tagsinput('add', $(this).text());
        });
    };

    this.buildTypeahead = function() {
    	// the real input that is typed in
        var elemTagInput = this.elemTagsInput.tagsinput('input');

        elemTagInput.typeahead({
            hint: true,
            highlight: true,
            minLength: 1,
            autoselect: true
        },{
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
    this.tagsNameToId = function(tags) {
        var ids = [];
        for (var i in tags) {
            ids.push(this.tagsMap[tags[i]]);
        }
        return ids;
    };

    this.getSearchTagsName = function() {
        return this.elemTagsInput.val().split(',');
    };

    this.getSearchTagsIds = function() {
        return this.tagsNameToId(this.getSearchTagsName());
    };

    this.getSearchSort = function() {
        return this.elemSortSelect ? this.elemSortSelect.val() : 0;
    };

    this.submitTags = function(e) {
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

    this.fetchLists = function(tags, pagination, sort) {
        console.log('Fetch Lists: '+tags+' &'+pagination+' &'+sort);
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
            error: this.fetchListsError,
            success: this.updateDisplayedLists
        });
    };

    this.fetchListsError = function(result, status, error) {
        console.error('Error 500: lists couldn\'t be retrieved.');
    };

    this.updateDisplayedLists = function(listsJson) {
        console.log(listsJson);
        $(this.elemContainer).html("");

        for (var i in listsJson) {
            var cardHtml = this.templateListCard(listsJson[i]);
            $(this.elemContainer).append($(cardHtml));
        }
    };

    this.templateListCard = function(listJson) {
        var card = ''
        +'<div class="card">'
        +    '<div class="card-header">'
        +        '<div class="star-ratings-sprite"><span style="width: 55%" class="star-ratings-sprite-rating"></span>'
        +        '</div>'
        +    '</div>'
        +    '<div class="card-snapshots">'
        +        '<img src="../../public/images/content/Cocktails_Gin/indian-tonic.jpg"/>'
        +        '<img src="../../public/images/content/Cocktails_Gin/gin-37-5deg-gordon-s-london-dry-70cl.jpg"/>'
        +        '<img src="../../public/images/content/Cocktails_Gin/bjorg-pur-jus-de-citrons-de-sicile-25cl.jpg"/>'
        +        '<span>+2</span>'
        +    '</div>'
        +    '<div class="card-body">'
        +        '<h4 title="'+listJson.list.listName+'">'+listJson.list.listName+'</h4>'
        +        '<p>'+listJson.list.description+'</p>'
        +    '</div>'
        +    '<div class="card-footer">'
        +        '<table>'
        +            '<tr>'
        +                '<td class="card-item-count">3 articles</td>'
        +                '<td class="card-price" rowspan="2">'+listJson.avg+' €</td>'
        +            '</tr>'
        +            '<tr>'
        +                '<td class="card-item-count-opt">dont 1 optionnel</td>'
        +            '</tr>'
        +        '</table>'
        +    '</div>'
        +    '<button>Voir la liste</button>'
        +    '<button>Ajouter au panier</button>'
        +'</div>';

        return card;
    };

}