if(window.location.href.indexOf("account") > -1) {

    var hash = window.location.hash;

    $('#tabAccount').find('a[href="' + hash + '"]').tab('show');

}