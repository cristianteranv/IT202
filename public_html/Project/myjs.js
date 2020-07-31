$(document).ready(function(){
    $('form.cartForm').submit(function () {
        var formValues = $(this).serialize();
        if(formValues.includes("login=false")){
            window.location = "https://it202-450.herokuapp.com/public_html/Project/login.php", true;
            return false;
        }
        else {
            $.post("addToCart.php", formValues,
                function (data) {
                    alert("Data: " + data);
                });
        }
    });
});