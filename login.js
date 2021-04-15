$(document).ready(function () {
    $('#login').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url : "formService.php?mode=2",
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
                window.location="admin.php";
            },
            error: function (xhr, textStatus, errorThrown) {
                if(xhr.status===401) {
                    $('#phpresult').html('Username and password do not match!');
                    // window.alert('Username and password do not match!');
                }
            }
        });
    });
});

