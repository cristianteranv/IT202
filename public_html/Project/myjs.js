$(document).ready(function(){
    $('form.cartForm').submit(function () {
        var formValues = $(this).serialize();
        if(formValues.includes("login=false")){
            alert("You must be logged in!");
            window.location.href = "https://it202-450.herokuapp.com/public_html/Project/login.php"
        }
        else {
            $.post("addToCart.php", formValues,
                function (data) {
                    alert("Data: " + data);
                });
        }
    });
});