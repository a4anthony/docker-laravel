function initialize() {
    $('#address_address').on('keyup keypress click', function(e) {
        var keyCode = e.keyCode || e.which;

        if ($('#address_address').prop('readonly') == true) {
            $('#address_address').val('');
        }
        if ($('#address-latitude').val() != '') {
            $('#address-latitude').val('');
            $('#address_address').val('');
        }
        if ($('#address-longitude').val() != '') {
            $('#address-longitude').val('');
        }


        $('#address_address').prop('readonly', false);

        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });



    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder;



    for (let i = 0; i < locationInputs.length; i++) {

        const input = locationInputs[i];

        const fieldKey = input.id.replace("_address", "");

        const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 5.051998;
        const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 7.879780;

        const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
            center: {
                lat: latitude - 0.0550,
                lng: longitude + 0.0650
            },
            zoom: 11
        });
        const marker = new google.maps.Marker({
            //  map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: {
                lat: latitude,
                lng: longitude
            },
        });
        marker.addListener('click', toggleBounce);



        marker.setVisible(isEdit);

        var storeRegion = new google.maps.Polygon({
            paths: [
                new google.maps.LatLng(5.07957, 7.8565),
                new google.maps.LatLng(5.00587, 7.85478),
                new google.maps.LatLng(4.91728, 7.96343),
                new google.maps.LatLng(4.87614, 8.08174),
                new google.maps.LatLng(4.97448, 8.06149),
                new google.maps.LatLng(5.04425, 8.02565),
                new google.maps.LatLng(5.08905, 8.01913),
                new google.maps.LatLng(5.11435, 7.97089),
                new google.maps.LatLng(5.07957, 7.8565),
            ],
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });
        storeRegion.setMap(map)



        var autocomplete = new google.maps.places.Autocomplete(input);
        // Set initial restrict to the greater list of countries.
        autocomplete.setComponentRestrictions({ 'country': ['ng'] });

        // Specify only the data fields that are needed.
        autocomplete.setFields(
            ["name", "geometry.location", "place_id", "formatted_address"]);






        autocomplete.key = fieldKey;
        autocompletes.push({
            input: input,
            map: map,
            marker: marker,
            autocomplete: autocomplete
        });

    }

    function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;




        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            marker.setVisible(false);
            const place = autocomplete.getPlace();


            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                input.value = "";
                return;
            }

            var storeRegion = new google.maps.Polygon({
                paths: [
                    new google.maps.LatLng(5.07957, 7.8565),
                    new google.maps.LatLng(5.00587, 7.85478),
                    new google.maps.LatLng(4.91728, 7.96343),
                    new google.maps.LatLng(4.87614, 8.08174),
                    new google.maps.LatLng(4.97448, 8.06149),
                    new google.maps.LatLng(5.04425, 8.02565),
                    new google.maps.LatLng(5.08905, 8.01913),
                    new google.maps.LatLng(5.11435, 7.97089),
                    new google.maps.LatLng(5.07957, 7.8565),
                ],
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            storeRegion.setMap(map)

            console.log(google.maps.geometry.poly.containsLocation(place.geometry.location, storeRegion));

            var inRegion = google.maps.geometry.poly.containsLocation(place.geometry.location, storeRegion);

            if (inRegion == true) {
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(11);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                point = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng()
                    },
                });
                $('#address-invalid').empty();


                geocoder.geocode({
                    'placeId': place.place_id
                }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        setLocationCoordinates(autocomplete.key, lat, lng);
                    }
                });
                $('#add-address-btn').prop('disabled', false);

            } else {

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(11);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                console.log(place);
                point = new google.maps.Marker({
                    map: map,
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                    },
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng()
                    },
                });
                $('#address-invalid').empty();

                $('#address_address').removeClass('is-invalid');
                $('#address-latitude').val('');
                $('#address-longitude').val('');

                $('#address-invalid').append('<strong>*sorry, we currently do not make deliveries to the selected region</strong>')
                $('#add-address-btn').prop('disabled', true);

                console.log('nope');
            }




            //    $('#address-map-container').addClass('d-none');



        });
    }
}



function setLocationCoordinates(key, lat, lng) {
    const latitudeField = document.getElementById(key + "-" + "latitude");
    const longitudeField = document.getElementById(key + "-" + "longitude");
    latitudeField.value = lat;
    longitudeField.value = lng;
}



google.maps.event.addDomListener(window, 'load', initialize);