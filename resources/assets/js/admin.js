
$('#id_list_to_delete').change(function () {
    console.log('/delete/list/' + $('#id_list_to_delete').val());
    $('#suppr_list').attr('href', '/delete/list/' + $('#id_list_to_delete').val());
});

$('#id_user_to_delete').change(function () {
    $('#suppr_user').attr('href', '/delete/user/' + $('#id_user_to_delete').val());
});

