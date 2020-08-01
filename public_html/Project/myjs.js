$(document).ready(function(){
    $('form.cartForm').submit(function () {
        var formValues = $(this).serialize();
        $.post(
            "addToCart.php",
            formValues,
            function (data) {
                alert("Data: " + data.toString());
            }
        );

    });
});