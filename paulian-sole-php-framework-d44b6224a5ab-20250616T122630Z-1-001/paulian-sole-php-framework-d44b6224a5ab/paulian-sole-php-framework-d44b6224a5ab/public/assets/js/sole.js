
class Sole{
    speechsynthesis = new SpeechSynthesisUtterance();
    get(url) {
        var request = fetch(url)
        return request.then(response => response.json())
    }
    post(url,value){
        var request = fetch(url,{
            method: 'POST',
            body: new URLSearchParams(value)
        })
        return request.then(response => response.json())
    }
    put(url,value){
        var request = fetch(url,{
            method: 'POST',
            body: new URLSearchParams(value)
        })
        return request.then(response => response.json())
    }
    delete(url,value){
        var request = fetch(url,{
            method: 'POST',
            body: new URLSearchParams(value)
        })
        return request.then(response => response.json())
    }
    element(id){
        var response = document.getElementById(id)
        return response
    }
    info(value, position = null){
        if(position == null){
            position = "top-right";
        }
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "hideDuration": 20000,
            "positionClass": "toast-"+position,
        }
        toastr.info(value);
    }
    success(value, position = null){
        if(position == null){
            position = "top-right";
        }
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "hideDuration": 20000,
            "positionClass": "toast-"+position,
        }
        toastr.success(value);
    }
    warning(value, position = null){
        if(position == null){
            position = "top-right";
        }
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "hideDuration": 20000,
            "positionClass": "toast-"+position,
        }
        toastr.warning(value);
    }
    error(value, position = null){
        if(position == null){
            position = "top-right";
        }
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "progressBar": true,
            "hideDuration": 20000,
            "positionClass": "toast-"+position,
        }
        toastr.error(value);
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
    console(){
        sole.get("../../.env.json")
        .then(res => console_print(res))
    }
    paintball(){
        initialize_paintball();
    }
    crowd(){
        initialize_crowd();
    }
    rain(){
        initialize_rain();
    }
    snake(){
        initialize_snake();
    }
    matchpuzzle(){
        initialize_matchpuzzle();
    }
}
var sole = new Sole;
sole.console();