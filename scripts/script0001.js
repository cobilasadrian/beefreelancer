/**
 * Created by Adrian on 5/9/2016.
 * Scriptul afiseaza detalii despre categoriile de srvicii de pe pagina pricipala
 */

$(document).ready(function() {
    $(".service-box").hover(function(){
        $(this).children(".service-box-caption").fadeTo(500, 0.8);
    }, function(){
        $(this).children(".service-box-caption").fadeOut(500);
    });
});


