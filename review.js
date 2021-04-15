$(document).ready(function () {
    $('#review-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url : "formService.php",
            type: "GET",
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