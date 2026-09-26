var map=""; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 

function initMap() {
	if(document.getElementById('lat').value=='' && 
	document.getElementById('lng').value==''){
		var lati=41.100051630930466;
		var lngi=28.992919921875;
	}else{
		var lati=document.getElementById('lat').value;
		var lngi=document.getElementById('lng').value;
	}

    //The center location of our map.
    var centerOfMap = new google.maps.LatLng(lati,lngi);
 
    //Map options.
    var options = {
      center: centerOfMap, //Set center.
      zoom: 16, //The zoom value.
	  mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    //Create the map object.
    map = new google.maps.Map(document.getElementById('map'), options);
	
////////////////////////////////////////////////////////////
showPosition2(lati,lngi);

    //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) {
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker === false){
            //Create the marker.
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true //make it draggable
            });
            //Listen for drag events!
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Marker has already been added, so just change its location.
            marker.setPosition(clickedLocation);
        }
        //Get the marker's location.
        markerLocation();
    });


}
        
//This function will get the marker's current location and then add the lat/long
//values to our textfields so that we can save the location.
function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    //Add lat and lng values to a field that we can save.
    document.getElementById('lat').value = currentLocation.lat(); //latitude
    document.getElementById('lng').value = currentLocation.lng(); //longitude
}

function showError(error) {
	showPosition2(document.getElementById('lat').value,document.getElementById('lng').value);
}
function showPosition2(lat,lng) {
	map.setZoom(4);
	marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat, lng),
		map: map,
		center: new google.maps.LatLng(lat, lng),
		draggable: true //make it draggable
});
google.maps.event.addListener(marker, 'dragend', function (evt) {
    markerLocation();
});

marker.setMap(map);
map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
map.setCenter(new google.maps.LatLng(lat, lng));

markerLocation();
}
function showPosition(position) {
	map.setZoom(13);
	marker = new google.maps.Marker({
	position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
	map: map,
	center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
	draggable: true //make it draggable
});
google.maps.event.addListener(marker, 'dragend', function (evt) {
    markerLocation();
});
window.dispatchEvent(new Event('resize'));
marker.setMap(map);
map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));

window.dispatchEvent(new Event('resize'));

markerLocation();

}
