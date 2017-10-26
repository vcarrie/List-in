$(function () {

    /* Tags Manager
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    // function from typeahead.js example
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, strictMatches, lazyMatches,
                substrRegex_strictSearch, substrRegex_lazySearch;

            // an array that will be populated with substring matches
            strictMatches = [];
            lazyMatches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex_strictSearch = new RegExp('^'+q, 'i');
            substrRegex_lazySearch = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex_lazySearch.test(str)) {
                    if (substrRegex_strictSearch.test(str)) {
                        // the typeahead jQuery plugin expects suggestions to a
                        // JavaScript object, refer to typeahead docs for more info
                        strictMatches.push({ value: str });
                    } else {
                        lazyMatches.push({ value: str });
                    }
                }
            });

            // if there are no strings starting with the query,
            // this at least returns ones that contains the query
            matches = strictMatches.concat(lazyMatches);

            cb(matches);
        };
    };

    var availableTags = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
      'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
      'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky',
      'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan',
      'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska',
      'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York',
      'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon',
      'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota',
      'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington',
      'West Virginia', 'Wisconsin', 'Wyoming'
    ];
    availableTags = $.merge(['Jardinage','Sport','Bricolage','Cuisine','Escalade'], availableTags);
    availableTags.sort();

    var tagsMaster = $('input.tags-filter');

    tagsMaster.tagsinput();

    // grab the input inside of tagsinput
    var tagInput = tagsMaster.tagsinput('input');

    // ensure that a valid state is being entered
    tagsMaster.on('itemAdded', function (event) {
        if (availableTags.indexOf(event.item) < 0) {
            tagsMaster.tagsinput('remove', event.item);
            //alert(event.item + " is not a valid state");
            $(tagInput).effect("highlight", {}, 3000);
        }
    });

    // initialize typeahead for the tag input
    tagInput.typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
        autoselect: true
    },{
        limit: 6,
        name: 'availableTags',
        displayKey: 'value',
        source: substringMatcher(availableTags)
    }).bind('typeahead:selected', $.proxy(function (obj, datum) {
        // if the state is clicked, add it to tagsinput and clear input
        tagsMaster.tagsinput('add', datum.value);
        tagInput.typeahead('val', '');
    }));

    // erase any entered text on blur
    $(tagInput).blur(function () {
        tagInput.typeahead('val', '');
    });

    // if a popular tag is clicked, add it to the input
    $('span.popular-tag').click(function() {
        tagsMaster.tagsinput('add', $(this).text());
    });

    /* PREVIEW CARD BODY & SLIDESHOW SCROLL
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $("#lists-preview").mCustomScrollbar({
        axis: "x",
        theme: "dark-3",
        scrollButtons: {
            enable: true,
            scrollType: "stepless"
        },
        mouseWheel: {
            enable: true,
            scrollAmount: 260,
            preventDefault: false
        },
        advanced: {
            updateOnSelectorChange: true
        },
        callbacks: {
            onTotalScrollOffset: 260,
            onTotalScroll: function() {
                // load and queue 2 more cards when the end is reached
                $(".preview-card:first-child").clone().appendTo("#lists-preview>div>div.mCSB_container");
                $(".preview-card:first-child").clone().appendTo("#lists-preview>div>div.mCSB_container");
            }
        }
    });

    // simulation
    for (var i = 1; i < 9; i++) {
      $(".preview-card:first-child").clone().appendTo("#lists-preview>div>div.mCSB_container");
    }

    $(".card-body").mCustomScrollbar({
        axis: "y",
        theme: "rounded-dark",
        scrollButtons: {
            enable: false,
            scrollType: "stepless"
        },
        mouseWheel: {
            enable: false
        }
    });

    /* Lists Manager: Load enough cards so that the scroll thing appears
    –––––––––––––––––––––––––––––––––––––––––––––––––– */
/*
    var listsData = [
        {
            "id": 0,
            "title": "Sportif casu",
            "rating_ratio": 0.75,
            "item_count": 3, // calculated
            "estimated_price": 60, // calculated
            "description": "Liste casu pour casu.",
            "creator": {
                "id": "0",
                "name": "Sportif33"
            },
            "items": [
                {
                    "cdiscount_id": "0",
                    "name": "Item 1",
                    "amount": 1,
                    "unit_price": 10
                },
                {
                    "cdiscount_id": "1",
                    "name": "Item 2",
                    "amount": 2,
                    "unit_price": 10
                },
                {
                    "cdiscount_id": "2",
                    "name": "Item 3",
                    "amount": 3,
                    "unit_price": 10
                }
            ]
        }
    ];

    function createListRow(list) {
        var rating = "<td><div class=\"star-ratings-sprite\"><span style=\"width:" + (list.rating_ratio*100) + "%\" class=\"star-ratings-sprite-rating\"></span></div></td>";
        var title = "<td>" + list.title + "</td>";
        var item_count = "<td>" + list.item_count + "</td>";
        var estimated_price = "<td>" + list.estimated_price + "</td>";
        return $("<tr>" + rating + title + item_count + estimated_price + "</tr>");
    }

    $.each(listsData, function(index, list) {
        var newRow = createListRow(list);
        $(newRow).click(function() {

        });
        $("#lists-preview > tbody").append(newRow);
    });
*/

    /* ACCESSIBILITY CORRECTIONS
    –––––––––––––––––––––––––––––––––––––––––––––––––– */

    $('.tt-input').attr('tabindex', 1);
});
