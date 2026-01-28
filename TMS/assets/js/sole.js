
class Sole{
    speechsynthesis = new SpeechSynthesisUtterance();
    file(url,value){
        var request = fetch(url, {
            method: "POST",
            body: value
        })
        return request.then(response => response.json().catch(() => alert("Upload failed")))
    }
    get(url) {
        var request = fetch(url)
        return request.then(response => response.json())
    }
    post(url,value){
        var request = fetch(url,{
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/json' // Inform the server about the JSON format
            },
            body: JSON.stringify(value)
        })
        return request.then(response => response.json())
    }
    put(url,value){
        var request = fetch(url,{
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/json' // Inform the server about the JSON format
            },
            body: JSON.stringify(value)
        })
        return request.then(response => response.json())
    }
    delete(url,value){
        var request = fetch(url,{
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/json' // Inform the server about the JSON format
            },
            body: JSON.stringify(value)
        })
        return request.then(response => response.json())
    }
    element(id){
        var response = document.getElementById(id)
        return response
    }
    speak(value, volume = null, rate = null, pitch = null){
        sole.speechsynthesis.text = value;
        if(volume == null){
            sole.speechsynthesis.volume = 1;
        }else{
            sole.speechsynthesis.pitch = volume;
        }
        if(rate == null){
            sole.speechsynthesis.rate = 1;
        }else{
            sole.speechsynthesis.pitch = rate;
        }
        if(pitch == null){
            sole.speechsynthesis.pitch = 1;
        }else{
            sole.speechsynthesis.pitch = pitch;
        }
        window.speechSynthesis.speak(sole.speechsynthesis);  
    }
    splash(Message, Timer, Type, Theme){
        initialize_splash_screen(Message, Timer, Type, Theme);
    }
    splash_img(Message, Timer, Img, Type, Theme){
        initialize_splash_screen_img(Message, Timer, Img, Type, Theme);
    }
}
var sole = new Sole;

let unclose = {
    backdrop: 'static',
    keyboard: false
}


function splash(message, seconds) {
  // Create splash element
  const splashScreen = document.createElement("div");
  const bs5_spinner = "<div style=\"height: 70px; width: 70px;\" class=\"spinner-border text-primary me-5\" role=\"status\"></div>"
  splashScreen.innerHTML = bs5_spinner
  splashScreen.id = "splash";
  splashScreen.style.position = "fixed";
  splashScreen.style.top = "0";
  splashScreen.style.left = "0";
  splashScreen.style.width = "100%";
  splashScreen.style.height = "100%";
  splashScreen.style.background = "white";
  splashScreen.style.display = "flex";
  splashScreen.style.alignItems = "center";
  splashScreen.style.justifyContent = "center";
  splashScreen.style.fontSize = "24px";
  splashScreen.style.opacity = "1";
  splashScreen.style.transition = "opacity 0.5s ease-out";
  splashScreen.style.zIndex = "9999";

  if (message) {
    splashScreen.innerHTML = message;
  }

  document.body.appendChild(splashScreen);

  // Remove after fade
  setTimeout(() => {
    splashScreen.style.opacity = "0";
    setTimeout(() => {
      splashScreen.remove();
    }, 500); // Matches fade transition duration
  }, seconds);
}
splash(null, 200)