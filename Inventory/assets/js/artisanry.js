var artisanry = document.getElementById("artisanry");

artisanry.addEventListener("click",function(){
    window.location.href = "inventory.php?loc=artisanry"
})

if(document.getElementById("artisan")){
    const qr_generator_modal = new bootstrap.Modal(document.getElementById('qr_generator_modal'),unclose);
    qr_generator_modal.show()

    // var qr_generator = document.getElementById("qr_generator");

    // var qr_type = document.getElementById("qr_type");
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
