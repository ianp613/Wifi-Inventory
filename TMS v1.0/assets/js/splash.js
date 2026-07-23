function showSplash() {

    const splash = document.createElement("div");

    splash.id = "spinnerSplash";

    document.body.appendChild(splash);
}

function hideSplash() {

    const splash = document.getElementById("spinnerSplash");

    if (!splash) return;

    splash.style.opacity = "0";

    setTimeout(() => splash.remove(), 300);
}

function startSplash(){
    showSplash();
    setTimeout(() => {
       hideSplash() 
    }, 200);    
}

startSplash()