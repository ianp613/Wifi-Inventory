if(document.getElementsByClassName("sole-menu-sidebar")[0]){
    var sidebar = document.getElementsByClassName("sole-menu-sidebar")
    var links = document.getElementsByClassName("sole-menu-item-link")
    var menuBody = document.getElementsByClassName("sole-menu-body")
    var body = document.body
    responsive()
    function responsive(){
        sidebar[0].insertAdjacentHTML("beforeend","<div id=\"soleMenu\">=</div>")
        bodySize()
        sidebarEvents()
        linksLabel()
    }
    function bodySize(){
        sidebar[0].style = "height: " + body.clientHeight + "px !important"
        menuBody[0].style = "height: " + (parseInt(body.clientHeight) - 100) + "px !important"
        if(parseInt(body.clientWidth) <= 990){
            sidebar[0].classList.add("menu-sidebar-collapse")
            if(document.getElementsByClassName("sole-display")[0]){
                document.getElementsByClassName("sole-display")[0].style = "height: " + document.body.clientHeight + "px !important"
                document.getElementsByClassName("sole-display")[0].classList.add("display-collapse")
            }
        }else{
            sidebar[0].classList.remove("menu-sidebar-collapse")
            if(document.getElementsByClassName("sole-display")[0]){
                document.getElementsByClassName("sole-display")[0].style = "height: " + document.body.clientHeight + "px !important"
                document.getElementsByClassName("sole-display")[0].classList.remove("display-collapse")
            }
        }
        
    }
    function sidebarCollapse(){
        if(sidebar[0].classList.contains("menu-sidebar-collapse")){
            sidebar[0].classList.remove("menu-sidebar-collapse")
            if(document.getElementsByClassName("sole-display")[0]){
                document.getElementsByClassName("sole-display")[0].classList.remove("display-collapse")
            }
        }else{
            sidebar[0].classList.add("menu-sidebar-collapse")
            if(document.getElementsByClassName("sole-display")[0]){
                document.getElementsByClassName("sole-display")[0].classList.add("display-collapse")
            }
        }
    }
    function sidebarEvents(){
        document.body.onresize = bodySize
        document.getElementById("soleMenu").onclick = sidebarCollapse
        for (let i = 0; i < links.length; i++) {
            if(links[i].hasAttribute("data-target")){
                links[i].onclick = wrapperTarget
            }
        }    
    }
    function linksLabel(){
        for (let i = 0; i < links.length; i++) {
            if(links[i].hasAttribute("link-label")){
                for (let j = 0; j < links[i].attributes.length; j++) {
                    if(links[i].attributes[j].nodeName == "link-label"){
                        links[i].innerHTML = links[i].innerHTML + " " + "<h6>" + links[i].attributes[j].nodeValue + "</h6>"
                    }
                }
            }
        }
    }
    function wrapperTarget(evt){
        evt = (evt) ? evt : ((event) ? event : null)
        if (evt) {
            var target = "";
            for (let i = 0; i < evt.srcElement.attributes.length; i++) {
                if(evt.srcElement.attributes[i].nodeName == "data-target"){
                    target = evt.srcElement.attributes[i].nodeValue
                }
            }
            if(target){
                targetWrapper = document.getElementById(target)
                if(targetWrapper.classList.contains("menu-wrapper-collapse")){
                    targetWrapper.classList.remove("menu-wrapper-collapse")
                }else{
                    targetWrapper.classList.add("menu-wrapper-collapse")
                }
            }
        }
    }
}
