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
        if (numberEntries == 0) {
            $('button[type=submit]').prop('disabled', true);
        }
        else {
            $('button[type=submit]').prop('disabled', false);
            $('#number-entries span').html(numberEntries);
        }
    });
});
