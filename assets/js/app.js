// MajiAlert Garissa County Alerts Auto Hide

document.addEventListener("DOMContentLoaded", function () {

    const alerts = document.querySelectorAll(".alert-success, .alert-error, .alert-info");

    alerts.forEach(function(alertBox){

        setTimeout(function(){

            alertBox.style.transition = "all 0.5s ease";
            alertBox.style.opacity = "0";
            alertBox.style.transform = "translateY(-10px)";

            setTimeout(function(){
                alertBox.remove();
            }, 500);

        }, 3000);

    });

});