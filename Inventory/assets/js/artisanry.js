var artisanry = document.getElementById("artisanry");

artisanry.addEventListener("click",function(){
    window.location.href = "inventory.php?loc=artisanry"
})

if(document.getElementById("artisan")){
    // QR GENERATOR SECTION
    const qr_generator_modal = new bootstrap.Modal(document.getElementById('qr_generator_modal'),unclose);
    qr_generator_modal.show()

    var qr_type = document.getElementById("qr_type");
    var qr_generate_btn = document.getElementById("qr_generate_btn")
    var qr_text_container = document.getElementById("qr_text_container")
    var qr_wifi_container = document.getElementById("qr_wifi_container")

    var qr_text = document.getElementById("qr_text")
    var qr_color = document.getElementById("qr_color")
    
    var qr_encryption = document.getElementById("qr_encryption")
    var qr_password_container = document.getElementById("qr_password_container")
    var qr_password = document.getElementById("qr_password")

    var qr_preview = document.getElementById("qr_preview")

    var containers = [
        qr_text_container,
        qr_wifi_container
    ]

    qr_type.addEventListener("change",function(){
        containers[parseInt(this.value)].removeAttribute("hidden")
        for (let index = 0; index < containers.length; index++) {
            if(index != this.value){
                containers[index].setAttribute("hidden","true")
            }
        }
    })

    qr_encryption.addEventListener("change",function(){
        if(this.value != "none"){
            qr_password_container.removeAttribute("hidden")
        }else{
            qr_password.value = ""
            qr_password_container.setAttribute("hidden","true")
        }
    })


    // COLORS
    var bgColor = document.getElementById("bgColor")
    var bgTransparent = document.getElementById("bgTransparent")
    var bgImg = document.getElementById("bgImg")
    var bgImgFile = document.getElementById("bgImgFile")

    bgTransparent.addEventListener("change",function(){
        
        if(this.checked){
            bgImg.checked = false
            bgColor.classList.add("bgTransparent")
            bgImgFile.value = ""
            bgImgFile.setAttribute("hidden","true")
            bgColor.setAttribute("disabled","true")
            bgColor.value = "rgba(0, 0, 0, 0)"
            bgColor.style.color = "#000000"
        }else{
            bgColor.value = "#ffffff"
            bgColor.style.color = "#000000"
            bgColor.style.backgroundColor = "#ffffff"
            bgColor.classList.remove("bgTransparent")
            bgColor.removeAttribute("disabled")
        }
    })

    bgImg.addEventListener("change",function(){
        if(this.checked){
            bgTransparent.checked = false
            bgImgFile.removeAttribute("hidden")
            bgColor.value = "#ffffff"
            bgColor.style.color = "#000000"
            bgColor.style.backgroundColor = "#ffffff"
            bgColor.classList.remove("bgTransparent")
            bgColor.removeAttribute("disabled")
        }else{
            bgImgFile.value = ""
            bgImgFile.setAttribute("hidden","true")
        }
    })

    // qr_generate_btn.addEventListener("click",function(){
    //     const formData = new FormData();
    //     formData.append("qr_type", qr_type.value); 
    //     formData.append("qr_color", qr_color.value); 

    //     if(qr_type.value = "0"){
    //        formData.append("qr_text", qr_text.value); 
    //     }

    //     sole.file("../../controllers/artisanry/qr_generate.php",formData)
    //     .then(res => {
    //         console.log(res)
    //         qr_preview.classList.remove("image-wrapper")
    //         qr_preview.innerHTML = '<img src="'+res.image+'">'
    //     })
    // })

    


    // var qr_generator = document.getElementById("qr_generator");

    // 
    // var qr_type_text = document.getElementById("qr_type_text");
    // var qr_text = document.getElementById("qr_text");
    // var qr_type_wifi = document.getElementById("qr_type_wifi");
    // var qr_ssid = document.getElementById("qr_ssid");
    // var qr_key = document.getElementById("qr_key");
    
    // var qr_logo_overlay = document.getElementById("qr_logo_overlay");
    // var qr_custom_logo_display = document.getElementById("qr_custom_logo_display");
    // var qr_custom_logo = document.getElementById("qr_custom_logo");

    // var qr_generate_btn = document.getElementById("qr_generate_btn");

    // qr_type.addEventListener("change",function(){
    //     this.value == "wifi" ? qr_type_wifi.removeAttribute("hidden") : qr_type_wifi.setAttribute("hidden","true")
    //     this.value == "text" ? qr_type_text.removeAttribute("hidden") : qr_type_text.setAttribute("hidden","true")
    // })

    // qr_logo_overlay.addEventListener("change",function(){
    //     this.value == "custom" ? qr_custom_logo_display.removeAttribute("hidden") : qr_custom_logo_display.setAttribute("hidden","true")
    // })

    // qr_generator.addEventListener("click",function(){
    //     qr_generator_modal.show()
    // })

    // qr_generate_btn.addEventListener("click",function(){
    //     var submit = true
    //     if(qr_type.value === "text") submit = qr_text.value ? true : (alert("Please input text."), false);
    //     if(qr_type.value === "wifi") submit = (qr_ssid.value && qr_key.value) ? true : (alert("Please input both SSID and key."), false);
    //     if(qr_logo_overlay.value === "custom") submit = qr_custom_logo.files.length ? true : (alert("Please select a logo file."), false);

    //     if(submit){
    //         const formData = new FormData();
    //         formData.append("type", qr_type.value);
    //         formData.append("text", qr_text.value);
    //         formData.append("ssid", qr_ssid.value);
    //         formData.append("key", qr_key.value);
    //         formData.append("overlay", qr_logo_overlay.value);

    //         if(qr_custom_logo.files.length){
    //             formData.append("logo", qr_custom_logo.files[0]);    
    //         }
            

    //         sole.file("../../controllers/artisanry/qr_generate.php",{
    //             "type" : qr_type.value,
    //         })
    //     }
    // })
    // sole.get("../../controllers/artisanry/artisanry.php")
    // .then(res => console.log(res))
}
