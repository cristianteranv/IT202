$(document).ready(function(){
    $('form.cartForm').click(function () {
        $.post("addToCart.php", {
                price : this.price,
                userId: this.userId,
            },
            function (data) {
            alert("Data: " + data);
        });
    });
});