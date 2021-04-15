$(function () {
    $(".headpage").load("headpage.html");
    $(".footpage").load("footpage.html");
});

function hamburger() {
    var x = document.getElementById("navbar");
    if (x.className === "header") {
        x.className += " responsive";
    } else {
        x.className = "header";
    }
}



function logout(){
    document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    document.cookie = "usertoken=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    window.location="login.html";
}