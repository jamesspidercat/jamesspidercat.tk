function date(){//change styles during june
    var date = new Date();
    if (date.getMonth() == 5){
        document.getElementById("head").innerHTML += '<link rel="stylesheet" type="text/css" href="pride.css">';
    }
}
date();