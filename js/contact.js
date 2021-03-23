function resubmit(y){
    sessionStorage.setItem('error', y);
    history.go(-1);
    
}
window.onload = function() {
    var error = sessionStorage.getItem("error");
    var wow = document.getElementById('error');
    if (error !== null){
        sessionStorage.removeItem('error');
        wow.innerHTML = error;
    }else{
        wow.innerHTML = '';
    }
}