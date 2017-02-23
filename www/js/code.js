$(document).ready(function () {

    $(document).on('click', 'a.ajax', function (event) {
        event.preventDefault();
        $.get(this.href);
    });

    $(document).on('click', 'a[data-confirm], button[data-confirm], input[data-confirm]', function () {
        return confirm($(this).data().confirm);
    });

    /*$(document).on('click', 'form.ajax', function () {
        return false;
    });

    $(document).on('click', 'form.ajax :submit', function () {
        $(this).ajaxSubmit();
        return false;
    });*/
});
