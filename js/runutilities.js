//Variables for our timer code:
var startTime = new Date().getTime();
var elapsed = 0;
var is_on = 1;
var t;
var goalTime = 0;
var goalTimePretty;
var runComplete = 0;

function formatTime(time) {
	var min = Math.floor(time/60000);
	var sec = Math.floor(time / 1000) - (min * 60);
	sec = ("0" + sec).slice(-2);
	var milli = time - (min * 60000) - (sec * 1000);
	milli = ("000" + milli).slice(-4);
	return (min + ":" + sec + ":" + milli);
}

function unformatTime(time) {
	var rawTime = 0;
	var bits = time.split(":");
	//console.log(bits.toString());
	rawTime += 3600000 * bits[0];
	rawTime += 60000 * bits[1];
	rawTime += 1000 * bits[2];
	return rawTime;
}

function runTimer() {
	var currTime = new Date().getTime();
	elapsed += currTime - startTime;
	startTime = currTime;
	var elapsedPretty = formatTime(elapsed);
	document.getElementById('yourTime').textContent="Your Time: " + elapsedPretty;
	t=setTimeout("runTimer()",50);
};

			
			
function pauseTimer() {
	clearTimeout(t);
	is_on = 0;
	sessionStorage.timePretty = formatTime(elapsed);
	//sessionStorage.goalTimePretty = goalTimePretty;
	sessionStorage.time = elapsed;
	sessionStorage.goalTime = goalTime;
	console.log("paused");
}
			
function resumeTimer() {
	if(!is_on) {
		is_on = 1;
		startTime = new Date().getTime();
		runTimer();
		console.log("resumed");				
	}
}

//initialize the currMarker
function initializeCurrLocation() {
	navigator.geolocation.getCurrentPosition(handleLocationInitialization, handleError);
}

//Continuously keep track of the user's current location
function trackLocation() {
	navigator.geolocation.getCurrentPosition(handleLocationUpdate, handleError)
	lt=setTimeout("trackLocation()", 10000);
}

//Set the initial location of the current location marker
function handleLocationInitialization(position) {
	var currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	locations[ticker] = currLatLng;
	currMarker = new google.maps.Marker({
		position: currLatLng,
		animation: google.maps.Animation.BOUNCE,
		title: "Current Location"
	});
	currMarker.setMap(map);
}

//Update the position of the current location marker
function handleLocationUpdate(position) {
//Calculate user's current position and add it to their locations
	var currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	currMarker.setPosition(currLatLng);
	//console.log("Lat:" + currLatLng.lat());
	//console.log("Lng:" + currLatLng.lng());
	//console.log(ticker);
	ticker++;
	locations[ticker] = currLatLng;

	//track and display the user's pace re: their goal time, if there is one.
	if(goalTime > 0 && !(Number(sessionStorage.locationOff) == 1)) {
		//Calculate their milage and update the page accordingly
		var currDistance = calculateDistance(locations);
		document.getElementById("mileage").textContent = currDistance + " miles run.";

		//Calculate how far on or off pace the runner is and display
		var distToGo = runDistance - currDistance;
		//var goalTime = 1000000;
		//console.log("elapsed: " + elapsed);
		//console.log("total run distance:" + runDistance);

		var lastTwoLocations = new Array(2);
		lastTwoLocations[0] = locations[locations.length - 2];
		lastTwoLocations[1] = locations[locations.length - 1];
		var lastLegVelocity = calculateDistance(lastTwoLocations) / 10000;
		//var lastLegVelocity = runDistance / goalTime;
		//console.log("llv: " + lastLegVelocity);

		if(lastLegVelocity > 0) {
			var timeNeeded = distToGo / lastLegVelocity;
			var timeLeft = goalTime - elapsed;
			//console.log("time needed:" + timeNeeded);
			//console.log("time left:" + timeLeft);
			if(timeNeeded < timeLeft) {
				//yay you're ahead by...
				var timeAhead = formatTime(timeLeft - timeNeeded);
				document.getElementById("pace").textContent = timeAhead + "ahead of pace.";

			}else {
				//sad face you're behind...
				var timeBehind = formatTime(timeNeeded - timeLeft);
				document.getElementById("pace").textContent = timeBehind + "behind pace :(";
			}
		}else {
			document.getElementById("pace").textContent = "Infinitely behind pace. Couch potato.";
		}
	}
}
			
function handleError(error) {
	if(!(sessionStorage.locationOff == 1)) {
		switch(error.code)  {  
            case error.PERMISSION_DENIED: alert("user did not share geolocation data");  
            break;  
            case error.POSITION_UNAVAILABLE: alert("could not detect current position");  
            break;  
            case error.TIMEOUT: alert("retrieving position timed out");  
            break;  
            default: alert("unknown error");  
            break;  
        }
        sessionStorage.locationOff = 1;
    }  
}

//Take an array of latlng objects and calculate the distance in miles from the first
//object in the array to the last
function calculateDistance(positions) {
	var earthRadius = 3963.1676;
	var totalDistance = 0;
	var piOverOneEighty = 3.14159265 / 180;
	for(var i = 1; i < positions.length; i++) {
		var lat1 = positions[i - 1].lat() * piOverOneEighty;
		var lat2 = positions[i].lat() * piOverOneEighty;
		var lng1 = positions[i - 1].lng() * piOverOneEighty;
		var lng2 = positions[i].lng() * piOverOneEighty;
		var x = (lng2 - lng1) * Math.cos((lat1 + lat2)/2);
		var y = (lat2 - lat1);
		totalDistance += Math.sqrt(x*x + y*y)*earthRadius;
		//console.log("Leg#" + i + ": " + Math.sqrt(x*x + y*y)*earthRadius);
	}
	return totalDistance.toFixed(2);
}

function calculateDistanceFancy(positions) {
	var totalDistance = 0;
	var earthRadius = 3963.1676;
	for(var i = 1; i < positions.length; i++) {
		var lat1 = positions[i - 1].lat();
		var lat2 = positions[i].lat();
		var lng1 = positions[i - 1].lng();
		var lng2 = positions[i].lng();
		var nextD = Math.acos(Math.sin(lat1)*Math.sin(lat2) + 
                  	Math.cos(lat1)*Math.cos(lat2) *
                  	Math.cos(lng2-lng1)) * earthRadius;
        //console.log("FancyLeg#" + i + ": " + nextD);					
		totalDistance += nextD;
	}
	return totalDistance.toFixed(2);
}