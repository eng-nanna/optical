$("ul.sideSubMenu > li > ul").parent().addClass("has-sub");

$("a[data-open=editForm]").click(function () {
    $("#id-value").val($(this).attr('data-id'));
});