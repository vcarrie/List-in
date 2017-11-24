
$('#id_list_to_delete').change(function () {
    console.log('/delete/list/' + $('#id_list_to_delete').val());
    $('#suppr_list').attr('OnClick', "window.location.href='/delete/list/" + $('#id_list_to_delete').val() + "'");
});

$('#id_user_to_delete').change(function () {
    console.log('/delete/user/' + $('#id_user_to_delete').val());
    $('#suppr_user').attr('OnClick', "window.location.href='/delete/user/" + $('#id_user_to_delete').val() + "'");
});
