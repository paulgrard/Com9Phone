$(document).ready(function () {
    $(".tariff-title").hover(function () {
            var id = $(this).attr('id');
            $('#' + id + '-description').slideDown('medium');
        },
        function () {
            $('.tariff').slideUp('medium');
        }
    );
});