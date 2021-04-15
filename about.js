$(document).ready(function () {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url : "formService.php?mode=1",
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
                $("#phpresult").html(data);
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
});
