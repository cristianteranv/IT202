$(document).ready(function(){
    $('form.cartForm').submit(function () {
        var formValues = $(this).serialize();
        alert(formValues);
        $.post("addToCart.php", formValues,
            function (data) {
            alert("Data: " + data);
        });
    });
});