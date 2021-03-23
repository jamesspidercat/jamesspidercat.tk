function date(){//change styles during june
    var date = new Date();
    if (date.getMonth() == 5){
        document.getElementById("head").innerHTML += '<link rel="stylesheet" type="text/css" href="css/pride.css">';
    }
}
//Go to top button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {//show back to top button after scroll down
    var topButton = document.getElementById("topButton");
    if (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) {
        topButton.style.display = "block";
    } else {
        topButton.style.display = "none";
    }
}
function topFunction() {//take you back to the top of the page when you click the back to top button
    window.scrollTo({top: 0, behavior: 'smooth'});
  }
date();