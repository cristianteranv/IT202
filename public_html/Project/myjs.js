$(document).ready(function(){
    $('form.cartForm').submit(function () {
        var formValues = $(this).serialize();
        if(formValues.includes("login=false")){
            alert(formValues);
        }
        else {
            $.post("addToCart.php", formValues,
                function (data) {
                    alert("Data: " + data);
                });
        }
    });
});