$(document).ready(function (){
    if(screen.width ===425 || screen.width <425){
        let mobile = document.getElementById('mobile-header');
        let desktop =document.getElementById('desktop-header');
        mobile.style.display = "block";
        desktop.style.display = "none";
    }
})