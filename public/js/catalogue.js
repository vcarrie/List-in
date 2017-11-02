function Catalogue(elemForm, elemContainer) {

	this.elemForm = $(elemForm);
	this.elemContainer = $(elemContainer);
	this.elemTagsInput = $(elemForm).find('input.tags-input');
	this.jsonTagsRoute = '/tags';
	this.suggestedTagsLimit = 6;
	this.tagsMap = {};
	this.tags = [];

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

		    this.elemForm.submit(this.submitTags);
		} else {
			this.initError();
		}
    };

    this.initError = function() {

    };

    this.ajaxJsonTagsError = function(result, status, error) {
        console.error('Error 500: tags couldn\'t be retrieved.');
    };

    this.ajaxJsonTagsSuccess = function(jsonTags, status) {
    	for (var i in jsonTags) {
    		var tag = jsonTags[i];
    		this.tagsMap[tag.tagName] = tag.idTag;
    		this.tags.push(tag.tagName);
    	}

    	this.buildTagsinput();
    	this.buildTypeahead();
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

    	// here we have a beautiful function which brilliantly uses 2 contexts --'
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
            limit: this.suggestedTagsLimit,
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

    this.submitTags = function(e) {
    	e.preventDefault();
    }

}