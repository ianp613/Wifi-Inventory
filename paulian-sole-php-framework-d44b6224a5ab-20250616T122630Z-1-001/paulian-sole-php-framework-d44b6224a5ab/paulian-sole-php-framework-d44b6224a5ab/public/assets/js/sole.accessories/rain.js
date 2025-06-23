var removetime = 0;
function initialize_rain(){
    var span = "";
    for (let index = 1; index <= 00; index++) {
        span = span + "<span></span>"
    }
    document.body.insertAdjacentHTML("beforeend",
    "<div class=\"rain\">"+
            "<div class=\"droplets\">"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
            "</div>"+
            "<div class=\"cloud-left\">"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
            "</div>"+
            "<div class=\"cloud-right\">"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
                "<span></span>"+
            "</div>"+
            "<span class=\"removerain\">Close</span>"+
        "</div>"
    )
    document.getElementsByClassName("removerain")[0].onclick = remove_rain
}
function remove_rain(){
    document.getElementsByClassName("removerain")[0].remove()
    document.getElementsByClassName("droplets")[0].remove()
    document.getElementsByClassName("cloud-left")[0].style = "animation: cloudleftexit 4.1s linear;";
    document.getElementsByClassName("cloud-right")[0].style = "animation: cloudrightexit 4.1s linear;";
    document.getElementsByClassName("rain")[0].style = "animation: rain 4.2s linear; animation-delay: 0s !important;";
    remove_rain_start()
}
function remove_rain_start(){
    setTimeout(remove_rain_support, 1000)
}
function remove_rain_support(){
    if(removetime == 3000){
        document.getElementsByClassName("rain")[0].remove()
    }else{
        removetime = removetime + 1000
        remove_rain_start()   
    }
}