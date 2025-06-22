function initialize_paintball(){
    document.body.insertAdjacentHTML("beforeend","<div class=\"paintboard\"></div><div class=\"clearboard\">Clear</div><div class=\"closeboard\">Close</div>")
    start_paintball()
}
function start_paintball(){
    sole.info("PAINTBALL TIP: You can click multiple times in a single point to create beautiful patterns.","bottom-left")
    if(document.getElementsByClassName("paintboard")[0]){
        document.getElementsByClassName("clearboard")[0].onclick = clear_paintboard
        document.getElementsByClassName("closeboard")[0].onclick = close_paintboard
        document.body.onclick = create_paintball
        document.body.style = "cursor: pointer;"  
    }
}
function create_paintball(evt){
    if(document.getElementsByClassName("paintboard")[0]){
        var color = ["#008000cc","#0000ffcc","#ff4500cc","#808080cc","#ffff00cc","#00ffffcc","#4b0082cc","#ff0000cc","#ffa500cc","#a52a2acc"]
        var index = parseInt((Math.random() * 10))
        var ballindex = parseInt((Math.random() * 10))
        var ballsize = ballindex * 10
        if(ballsize < 50){
            ballsize = 50
        }
        document.getElementsByClassName("paintboard")[0].insertAdjacentHTML("beforeend","<div style=\"top: " + parseInt(evt.pageY - 50) + "px; left: " + parseInt(evt.pageX - 50) + "px;\" class=\"paintball\"><span style=\"background: " + color[index] + " !important; width: " + ballsize + "px; height: " + ballsize + "px;\"></span></div>")    
    }
}
function clear_paintboard(){
    document.getElementsByClassName("paintboard")[0].innerHTML = ""
}
function close_paintboard(){
    document.getElementsByClassName("paintboard")[0].remove()
    document.getElementsByClassName("clearboard")[0].remove()
    document.getElementsByClassName("closeboard")[0].remove()
    document.body.style = "cursor: default;"  
}