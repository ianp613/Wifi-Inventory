// HTML TAG FOR COLOPICKER

// <div class="col-md-6 colorpicker">
//    <label for="bg-color">Color Picker</label>
//    <input name="bg-color" type="color" value="#FFFFFF">
// </div>

if(document.getElementsByClassName("colorpicker").length){
    var colorpicker = document.getElementsByClassName("colorpicker")
    var cpscolor = "#ffffff"
    
    for (let i = 0; i < colorpicker.length; i++) {
        colorpicker[i].setAttribute("type","text")
        colorpicker[i].setAttribute

        if(!colorpicker[i].classList.contains("colorpicker-light") && !colorpicker[i].classList.contains("colorpicker-dark")){
            colorpicker[i].value = "#ffffff"
        }else if(colorpicker[i].classList.contains("colorpicker-light")){
            colorpicker[i].value = "#ffffff"
        }else if(colorpicker[i].classList.contains("colorpicker-dark")){
            colorpicker[i].value = "#000000"
            cpscolor = "#000000"
        }
        
        var cp = document.createElement("input")
        cp.setAttribute("type","color")
        cp.setAttribute("class","colorpicker-selector ")
        cp.setAttribute("id","cps" + [i])
        cp.value = cpscolor
        colorpicker[i].insertAdjacentElement("beforebegin",cp)

        var cps = document.getElementById("cps" + [i])
        colorpicker[i].addEventListener("click",function(){
            cps.click()
        })

        // AUTO ADJUST COLOR OF FONT AND BACKGROUND
        cps.addEventListener("input",function(){
            colorpicker[i].value = this.value
            colorpicker[i].style.backgroundColor = this.value
            colorpicker[i].style.color = getContrastYIQ(this.value)
        })
        
        // SET INNITIAL COLOR
        colorpicker[i].style.backgroundColor = cpscolor
        colorpicker[i].style.color = getContrastYIQ(cpscolor)

        function getContrastYIQ(hexcolor) {
            hexcolor = hexcolor.replace('#', '');
            const r = parseInt(hexcolor.substr(0,2),16);
            const g = parseInt(hexcolor.substr(2,2),16);
            const b = parseInt(hexcolor.substr(4,2),16);
            const yiq = ((r*299)+(g*587)+(b*114))/1000;
            return (yiq >= 128) ? '#000000' : '#FFFFFF';
        }
    }


}