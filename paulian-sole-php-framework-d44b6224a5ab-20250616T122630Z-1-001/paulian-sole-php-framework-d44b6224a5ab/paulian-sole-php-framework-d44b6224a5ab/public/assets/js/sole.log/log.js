var height = "50%";
function showhide(){
    if(sole.element("systemlog").style["height"] != "10%"){
        height = sole.element("systemlog").style["height"];
        sole.element("systemlog").style = "height: 10%";
    }else{
        sole.element("systemlog").style = "height: "+height;
    }
}
function minimize(){
    sole.element("systemlog").style = "height: 50%";
}
function maximize(){
    sole.element("systemlog").style = "height: 100%";
}