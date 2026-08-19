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

// startSplash()

window.addEventListener('load', () => {
  const preloader = document.getElementById('preloader');

  if (preloader) {
    setTimeout(() => {
      preloader.style.transition = 'opacity 0.5s ease';
      preloader.style.opacity = '0';

      preloader.addEventListener('transitionend', () => {
        preloader.remove();
      }, { once: true });
    }, 100);
  }
});





// preloader demo
let preloader__ = null
function preloader_(time = 2000){
  let preloader_el = document.createElement("div");
  preloader_el.id = "preloader";
  document.body.insertAdjacentElement("afterbegin",preloader_el)

  preloader__ = document.getElementById('preloader');
  if (preloader__) {
    setTimeout(() => {
      preloader__.style.transition = 'opacity 0.5s ease';
      preloader__.style.opacity = '0';

      preloader__.addEventListener('transitionend', () => {
        preloader__.remove();
      }, { once: true });
    }, time);
  }
}
