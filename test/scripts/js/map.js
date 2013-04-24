/**
 * Creates the map with the specified parameters. 
 *
 * @param beachArray the array that contains all the data about the beach
 * @param state      the current state that is being viewed
 * @param sortBy     the current method of sorting the map markers
 * @param mapZoom    the level of zoom to create the map at
 * @param center     the position on which the map is centered
 */
function createMap(beachArray, state, sortBy, mapZoom, center, maxArray) {
    var address      = state;
    var geocoder     = new google.maps.Geocoder();
    var latlng; 
    var sort         = sortBy.toLowerCase();
    var zoom         = 6;

    markers          = new Array();

    switch (state) {
        case 'AL':
            address = 'Fort Morgan, Alabama';
            zoom    = 9;
        break;
        case 'CA':
            address = 'San Jose, California';
            zoom    = 5;
            document.getElementById('heatkey').className = 'westkey';
        break;
        case 'CT':
            address = 'Branford, Connecticut';
            zoom    = 9;
        break;
        case 'DE':
            address = 'Milford, Delaware';
            zoom    = 8;
        break;
        case 'FL':
            address = 'Florida';
            zoom    = 6;
        break;
        case 'GA':
            address = 'Dock Junction, Georgia';
            zoom    = 8;
        break;
        case 'LA':
            address = 'Abbeville, Louisiana';
            zoom    = 7;
        break;
        case 'MA':
            address = 'Provincetown, Massachusetts';
            zoom    = 8;
        break;
        case 'MD':
            address = 'Newark, Maryland';
            zoom    = 9;
        break;
        case 'ME':
            address = 'Rockland, Maine';
            zoom    = 7;
        break;
        case 'MS':
            address = 'Gulfport, Mississipi';
            zoom    = 9;
        break;
        case 'NC':
            address = 'Goldsboro, NC';
            zoom    = 7;
        break;
        case 'NJ':
            address = 'Manahawkin, New Jersey';
            zoom    = 8;
        break;
        case 'NY':
            address = 'New Rochelle, Ney York';
            zoom    = 8;
        break;
        case 'RI':
            address = 'Kingstown, Rhode Island';
            zoom    = 9;
        break;
        case 'SC':
            address = 'Sewee Bay, South Carolina';
            zoom    = 8;
        break;
        case 'TX':
            address = 'Shamrock Cove, Texas';
            zoom    = 7;
        break;
        case 'VA':
            address = 'Cape Charles, Virgina';
            zoom    = 8;
        break;
        case 'WA':
            address = 'Ocean Shores, Washington';
            zoom    = 7;
            document.getElementById('heatkey').className = 'westkey';
        break;
    }

    if (mapZoom == -1 && center == -1) {
        geocoder.geocode({ 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                latlng = results[0].geometry.location;
                myMap.setCenter(latlng);
            } else {
                alert("Invalid address!");
            }
        });
    } else {
        latlng = center;
        zoom = mapZoom;
    }


   var myOptions = {
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center : latlng
    }
    myMap = new google.maps.Map(document.getElementById("map_canvas"),
                                myOptions);

    jQuery.each(beachArray, function() {
        var marker = createMarkers(myMap, this, state, sort, maxArray);
        if (marker != null) {
            markers.push(marker);
        }
    });

    setMarkers(markers, myMap);
}

/**
 * Creates a marker for the Googel map. This function creates markers using
 * the specified paramters. It returns the function so that it can be used in
 * the calling function.
 *
 * @param  myMap the map that the markers are going to be added to
 * @param  beach the beach object that contains the information used in the
 *               content window
 * @param  state the state that is currently being viewed
 * @param  sort  the means by which to sort out the markers for the heatmap
 * @return the marker that as created
 */
function createMarkers(myMap, beach, state, sort, maxArray) {
    if (beach.latitude != null && beach.longitude != null) {
        var latlng     = new google.maps.LatLng(beach.latitude, 
                                                beach.longitude);

        var icon = getIcon(beach[sort], sort, maxArray);
        var marker = new google.maps.Marker({
            position: latlng,
            map: myMap,
            icon: icon,
            optimized: false
        });

        google.maps.event.addListener(marker, 'click', function() {
            var unitCost      = '$' + Math.round(beach.cost);
            var unit2010Cost  = '$' + Math.round(beach.cost2010);
            var unitVolume    = Math.round(beach.volume) + ' (cubic yards)';
            var unitLength    = Math.round(beach.len) + ' (feet)';

            var contentString = 
                  '<div style="height: 190px; width: 400px;">'
                + '<table cols="2" style="border-spacing: 10px 5px;">'
                + '<tr><td><font size="2px">Beach Location:</font></td>'
                + '<td><font size="2px">' + beach.beach + '</font></td></tr>'
                + '<tr><td><font size="2px">Episodes:</font></td><td>'
                + '<font size=2px">' + beach.episodes + '</font></td></tr>'
                + '<tr><td><font size="2px">Total volume:</font></td><td>'
                + '<font size=2px">' + numberWithCommas(unitVolume) 
                + '</font></td></tr>'
                + '<tr><td><font size="2px">Total length:</font></td><td>'
                + '<font size=2px">' + numberWithCommas(unitLength) 
                + '</font></td></tr>'
                + '<tr><td><font size="2px">Total cost:</font></td><td>'
                + '<font size=2px">' + numberWithCommas(unitCost)
                + '</font></td></tr>'
                + '<tr><td><font size="2px">Cost in 2012 dollars:</font></td><td>'
                + '<font size=2px">' + numberWithCommas(unit2010Cost)
                + '</font></td></tr>'
                + '</tr></table>'
                + '<a href="visualization.php?state=' + state + '&beach='
                + beach.beach + '" target="_top">Click here</a> '
                + 'for more information</div>';

            infoWindow.setContent(contentString);
            infoWindow.setPosition(marker.getPosition());
            infoWindow.open(myMap, marker);
            marker.setAnimation(google.maps.Animation.BOUNCE);

            selectedMarker = marker;
        });

        google.maps.event.addListener(infoWindow, 'position_changed', function() {
            infoWindow.close();
            marker.setAnimation(null);
        });

        google.maps.event.addListener(infoWindow, 'closeclick', function() {
            selectedMarker = null;
        });

        return marker;
    } else {
        return null;
    }
}

/**
 * Sets all the markers to the specified map (or null, if specified).
 *
 * @param markers the list of markers to set to the map
 * @param myMap   the map to add all the markers to (can be null to remove all
 *                markers from map)
 */
function setMarkers(markers, myMap) {
    jQuery.each(markers, function() {
        this.setMap(myMap);
    });
}

/**
 * Determines what color the marker should be by the value of the sorting
 * value.
 *
 * @param  value  the valuethat you are using to determine the color of the
 *               marker
 * @param  sortBy the means by which the values are sorted
 * @return the icon that will be used for the marker
 */
function getIcon(value, sortBy, maxArray) {
    var max     = maxArray[sortBy];
    var percent = (value / max) * 100;
    var color;

    if (percent >= 75) {
        color = 'red';
    } else if (percent >= 50) {
        color = 'orange';
    } else if (percent >= 25) {
        color = 'yellow';
    } else {
        color = 'green';
    }

    var markerIcon = new google.maps.MarkerImage('images/markers/' + color + '.png',
                         new google.maps.Size(15, 15), new google.maps.Point(0, 0),
                         new google.maps.Point(7, 10));

    return markerIcon;
}
