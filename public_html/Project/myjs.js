$(document).ready(function(){
    $('form.cartForm').click(function () {
        $.post("addToCart.php", function (data, status) {
            alert("Data: " + data + "\nStatus: " + status);
        })
    })
});