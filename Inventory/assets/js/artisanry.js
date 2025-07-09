var artisanry = document.getElementById("artisanry");

artisanry.addEventListener("click",function(){
    window.location.href = "inventory.php?loc=artisanry"
})

if(document.getElementById("artisan")){
    const qr_generator_modal = new bootstrap.Modal(document.getElementById('qr_generator_modal'),unclose);

    var qr_generator = document.getElementById("qr_generator");

    qr_generator.addEventListener("click",function(){
        qr_generator_modal.show()
    })
    // sole.get("../../controllers/artisanry/artisanry.php")
    // .then(res => console.log(res))
}
