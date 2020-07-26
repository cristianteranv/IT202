$(document).ready(function(){
    $('form.subCart').onsubmit(function () {
        var formValues = $(this).serialize();
        $.post("addToCart.php", formValues,
            function (data) {
            alert("Data: " + data);
        });
    });
});