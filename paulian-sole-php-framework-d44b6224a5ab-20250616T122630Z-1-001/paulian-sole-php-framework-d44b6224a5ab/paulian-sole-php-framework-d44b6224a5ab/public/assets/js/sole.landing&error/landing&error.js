if(sole.element("particle")){
    document.body.onresize = particlesize
}
function particlesize(){
    var particle = sole.element("particle");
    var bodyHeight = document.body.clientHeight;
    var bodyWidth = document.body.clientWidth;
    particle.style = "width: " + bodyWidth + " !important; height: " + bodyHeight + " !important;";
}
if(sole.element("particle")){
    window.onload = function() {
        Particles.init({
            selector: '.particle',
            responsive: [{
                breakpoint: 3000,
                options: {
                    maxParticles: 150,
                    color: '#ffffff',
                    connectParticles: false,
                    sizeVariations: 5,
                    speed: .5,
                    minDistance: 120,
                }
            },]
        });
    };   
}
if(sole.element("errorparticle")){
    window.onload = function() {
        Particles.init({
            selector: '.errorparticle',
            responsive: [{
                breakpoint: 3000,
                options: {
                    maxParticles: 150,
                    color: '#ffffff',
                    connectParticles: false,
                    sizeVariations: 5,
                    speed: .5,
                    minDistance: 120,
                }
            },]
        });
    };   
}