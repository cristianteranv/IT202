$(document).ready(function(){
    $('form.cartForm').click(function () {
        $.post("addToCart.php", function (data) {
            alert("Data: " + data);
        });
    });
});