$(document).ready(function(){
    $('form.cartForm').click(function () {
        var formValues = $(this).serialize();
        $.post("addToCart.php", formValues,
            function (data) {
            alert("Data: " + data);
        });
    });
});