var $ = require("jquery");
$('#searchForm').submit(function () {

    var search = $('input[name=search]').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post({
        url: '',
        data: {search :search},
        dataType: 'html',
        success: function (data) {
            document.getElementById('resultSearch').innerHTML = data;
        },

        error: function (e) {
            document.getElementById('resultSearch').innerHTML = e.responseText;
        }
    });

    return false;
});