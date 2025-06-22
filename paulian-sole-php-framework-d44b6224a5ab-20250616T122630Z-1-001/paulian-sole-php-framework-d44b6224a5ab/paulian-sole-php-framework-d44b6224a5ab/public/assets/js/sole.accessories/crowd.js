function initialize_crowd(){
    document.body.insertAdjacentHTML("beforeend","<div class=\"crowd\"><span class=\"closecrowd\">Close</span></div>")
    document.getElementsByClassName("closecrowd")[0].onclick = remove_crowd
    start_crowd()
}
function start_crowd(){
    var human = ["human-male","human-female"];
    var clothes = ["red","orangered","orange","yellow","black","green","blue","indigo","brown","violet"];
    var speed = [16,17,18,19,20,21,22,23,24,25];
    var armandlegspeed = [1,1.1,1.2,1.3,1.4,1.5,1.6,1.7,1.9];
    var temp = 1;
    if(document.getElementsByClassName("crowd")[0]){
        for (let index = 0; index < 15; index++) {
            if(parseInt(Math.random() * 10)%2){
                temp = armandlegspeed[parseInt(Math.random() * 10)];
                document.getElementsByClassName("crowd")[0].insertAdjacentHTML("beforeend",
                    "<div class=\"human-male\" style=\" animation: movemanright "+speed[parseInt(Math.random() * 10)]+"s linear infinite; animation-delay: "+parseInt(Math.random() * 10)+"s;\">"+
                        "<div class=\"arm\">"+
                            "<div class=\"left-arm\" style=\"animation: moveright "+temp+"s linear infinite\"><span></span></div>"+    
                        "</div>"+
                        "<div class=\"leg\">"+
                            "<div class=\"left-leg\" style=\"animation: moveleft "+temp+"s linear infinite\"><span></span></div>"+
                        "</div>"+
                        "<div class=\"head\"><span></span></div>"+
                        "<div class=\"body\" style=\"background: "+clothes[parseInt(Math.random() * 10)]+"\"></div>"+
                        "<div class=\"leg\">"+
                            "<div class=\"right-leg\" style=\"animation: moveright "+temp+"s linear infinite\"><span></span></div> "+   
                        "</div>"+
                        "<div class=\"arm\">"+
                            "<div class=\"right-arm\" style=\"animation: moveleft "+temp+"s linear infinite\"><span></span></div>"+
                        "</div>"+
                    "</div>"
                )
            }else{
                temp = armandlegspeed[parseInt(Math.random() * 10)];
                document.getElementsByClassName("crowd")[0].insertAdjacentHTML("beforeend",
                    "<div class=\"human-female\" style=\" animation: movemanleft "+speed[parseInt(Math.random() * 10)]+"s linear infinite; animation-delay: "+parseInt(Math.random() * 10)+"s;\">"+
                        "<div class=\"arm\">"+
                            "<div class=\"left-arm\" style=\"animation: moveright "+temp+"s linear infinite\"><span></span></div>"+    
                        "</div>"+
                        "<div class=\"leg\">"+
                            "<div class=\"left-leg\" style=\"animation: moveleft "+temp+"s linear infinite\"><span></span></div>"+
                        "</div>"+
                        "<div class=\"head\"><span></span></div>"+
                        "<div class=\"body\" style=\"background: "+clothes[parseInt(Math.random() * 10)]+"\"></div>"+
                        "<div class=\"leg\">"+
                            "<div class=\"right-leg\" style=\"animation: moveright "+temp+"s linear infinite\"><span></span></div> "+   
                        "</div>"+
                        "<div class=\"arm\">"+
                            "<div class=\"right-arm\" style=\"animation: moveleft "+temp+"s linear infinite\"><span></span></div>"+
                        "</div>"+
                    "</div>"
                )
            }
        }
    }
}
function remove_crowd(){
    document.getElementsByClassName("crowd")[0].remove()
}