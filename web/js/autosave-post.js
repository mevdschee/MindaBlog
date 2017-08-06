$(function() {
    var frm = $('#autosave');

    var timeoutId;

    var saveForm = function () {
        $('#status').attr('class', 'pending').text('changes pending');

        // If a timer was already started, clear it.
        if (timeoutId) clearTimeout(timeoutId);

        // Set timer that will save comment when it fires.
        timeoutId = setTimeout(function () {
            // Make ajax call to save data.
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    $('#status').attr('class', 'saved').text('changes saved');
                },
                error: function (data) {
                    $('#status').attr('class', 'error').text('ERROR');
                },
            });            
        }, 750);
    };

    $('input, textarea').bind("keypress", saveForm);
    setInterval(saveForm, 5000);
});
