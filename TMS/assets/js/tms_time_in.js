// LONGLAT -----------------------------------------------------------------


var latitude = document.getElementById("latitude");
var longitude = document.getElementById("longitude");
var locations = [];
var loc_disp = document.getElementById("loc_disp")
sole.get("../../controllers/get_tms_locations.php").then(res => {
  locations = res
})


const watchId = navigator.geolocation.watchPosition(
  (position) => {
    latitude.innerText = "Latitude: " + position.coords.latitude;
    longitude.innerText = "Longitude: " + position.coords.longitude;
    latitude.setAttribute("ll",position.coords.latitude)
    longitude.setAttribute("ll",position.coords.longitude)

    locations.forEach(r => {
      if(withinRadius(r.latitude,r.longitude,parseFloat(latitude.getAttribute("ll")),parseFloat(longitude.getAttribute("ll")),r.radius)){
        loc_disp.innerText = r.description
      }
    });
  },
  (error) => {
    console.error("Error occurred:", error);
  }
);  



// To stop watching:
// navigator.geolocation.clearWatch(watchId);


// TIME --------------------------------------------------------------------

function updateDateTime() {
    const now = new Date();

    // Format parts
    const optionsDate = { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' };
    const optionsTime = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };

    // Format date and time separately
    const dateStr = now.toLocaleDateString('en-US', optionsDate);
    const timeStr = now.toLocaleTimeString('en-US', optionsTime);

    // Custom output: Thursday Dec 18, 2025 | 8:29:09 AM
    document.getElementById('tms_datetime').textContent = `${dateStr} | ${timeStr}`;
}

// Update immediately and then every second
updateDateTime();
setInterval(updateDateTime, 1000);











const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');
const captureBtn = document.getElementById('capture');
const retakeBtn = document.getElementById('retake');
const output = document.getElementById('output');

let videoStream;
let video = document.createElement('video');
video.autoplay = true;
video.playsInline = true;

let animationFrameId;
let isPaused = false;

// Ask for camera access
navigator.mediaDevices.getUserMedia({ video: true })
  .then(stream => {
    videoStream = stream;
    video.srcObject = stream;
    drawToCanvas(); // start drawing
  })
  .catch(err => {
    console.error("Error accessing camera:", err);
  });

// Draw video frames to canvas
function drawToCanvas() {
  if (!isPaused) {
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    animationFrameId = requestAnimationFrame(drawToCanvas);
  }
}

// // Capture button click
captureBtn.addEventListener('click', () => {
  // Stop updating canvas (pause at current frame)
  isPaused = true;
  cancelAnimationFrame(animationFrameId);

  // Convert current canvas frame to Base64
  const dataUrl = canvas.toDataURL('image/png');
  output.value = dataUrl;
  latitude.getAttribute("ll")

  sole.get("../../controllers/get_tms_locations.php").then(res => {
    res.forEach(r => {
      if(withinRadius(r.latitude,r.longitude,parseFloat(latitude.getAttribute("ll")),parseFloat(longitude.getAttribute("ll")),r.radius)){
        alert("Time In Location is valid for " + r.description)
      }else{
        alert("Time In Location is not valid for " + r.description)
      }
    });
  })
});

retakeBtn.addEventListener("click", () => {
    isPaused = false;
    drawToCanvas();
})



function withinRadius(lat1, lon1, lat2, lon2, radiusMeters) {
  const R = 6371000; // Earth radius in meters
  const toRad = deg => (deg * Math.PI) / 180;

  const dLat = toRad(lat2 - lat1);
  const dLon = toRad(lon2 - lon1);

  const phi1 = toRad(lat1);
  const phi2 = toRad(lat2);

  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(phi1) * Math.cos(phi2) *
    Math.sin(dLon / 2) * Math.sin(dLon / 2);

  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  const distance = R * c; // distance in meters

  return distance <= radiusMeters;
}

// // Example usage:
// const lat1 = 10.0, lon1 = 125.0;
// const lat2 = 10.0002, lon2 = 125.0002;

// console.log(withinRadius(lat1, lon1, lat2, lon2)); // true or false
