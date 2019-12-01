const $ = require('jquery');

$(document).ready(function () {
    $(':checkbox').change(function() {
        if ($(this).prop('checked')) {
            $(this).parent().parent().addClass('table-secondary');
        }
        else {
            $(this).parent().parent().removeClass('table-secondary');
        }

        var numberEntries = $('input:checkbox:checked').length;
        $('button[type=submit]').prop('disabled', numberEntries == 0);
        $('#number-entries span').html(numberEntries);
    });
});
