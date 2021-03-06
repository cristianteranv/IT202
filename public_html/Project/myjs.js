$(document).ready(function(){
    $('form.cartForm').submit(function (event) {
        event.preventDefault();
        var formValues = $(this).serialize();
        if(formValues.includes("login=false")){
            alert("You must be logged in!");
            window.location = "https://it202-450.herokuapp.com/public_html/Project/login.php";
            return false;
        }
        else {
            $.post(
                "addToCart.php",
                formValues,
                function (data) {
                    alert("data: " + data);
                }
            );
        }
    });
    $('form.editQuantity').submit(function (event){
        event.preventDefault();
        var formValues = $(this).serialize();
        $.post(
            "editQuantity.php",
            formValues,
            function (data) {
                alert("data: " + data);
                location.reload(true);
            }
        );
    });

    $('form.buy').submit(function (event){
        event.preventDefault();
        var formValues = $(this).serialize();
        $.post(
            "placeOrder.php",
            formValues,
            function (data) {
                alert("data: " + data);
                location.reload(true);
            }
        )
    });
});