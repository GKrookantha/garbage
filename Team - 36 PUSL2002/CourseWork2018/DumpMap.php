<?php
/**
 * Created by PhpStorm.
 * User: isuru
 * Date: 12/28/2018
 * Time: 10:28 AM
 */
include_once 'PageHeader.php'
?>


<title>DumpMaps - CMC</title>

<div id="GoogleMap" style="width: 100%;height: 600px"></div>

<script>
    var map, marker,marker1,marker2,marker3,marker4,marker5, infowindow;
    var red_icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';


    function MapLoading()
    {
        var center = { lat: 6.9367,lng: 79.9270};

        var mapProperties = { center: center, zoom: 10 };//Map loading properties
        map = new google.maps.Map(document.getElementById("GoogleMap"), mapProperties);
        marker = new google.maps.Marker(
            {
                position: { lat: 6.9157, lng: 79.8636 },
                map: map,
                animation: google.maps.Animation.DROP,
                icon: "images/Government-Icon.png"
            });

        marker1 = new google.maps.Marker(
            {
                position: {lat:6.8157,lng: 79.9028},
                map: map,
                animation: google.maps.Animation.DROP,
                icon: red_icon
            });

        marker2 = new google.maps.Marker(
            {
                position: {lat:6.9100 , lng: 79.8583},
                map: map,
                animation: google.maps.Animation.DROP,
                icon: red_icon
            });

         marker3 = new google.maps.Marker(
            {
                position: {lat:6.6685,lng: 80.0229},
                map: map,
                animation: google.maps.Animation.DROP,
                icon: red_icon
            });

        marker4 = new google.maps.Marker(
            {
                position: {lat: 7.1315, lng:79.8807},
                map: map,
                animation: google.maps.Animation.DROP,
                icon: red_icon
            });
        marker5 = new google.maps.Marker(
            {
                position: {lat:6.7999, lng:80.0141},
                map: map,
                animation: google.maps.Animation.DROP,
                icon: red_icon
            });




        infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'mouseover', function ()
        {
            infowindow.setContent
            ("<div style='float:left;height:auto; width: auto' align='center'><img src='DumpLocations/cmc.png'>"+
             "<p>Colombo Municipal Council</p></div>"
            );
            infowindow.open(map, this);
        });



        infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker1, 'mouseover', function ()
        {
            infowindow.setContent
                ("<div style='float:left;height:auto; width: auto' align='center'><img src='DumpLocations/karandeniya.png'>"+
                    "<p>Karandeniya Garbage Dump</p></div>"
                );
            infowindow.open(map, this);
        });



        infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker2, 'mouseover', function ()
        {
            infowindow.setContent
            ("<div style='float:left;height:auto; width: auto' align='center'><img src='DumpLocations/western.png'>"+
                "<p>Waste Management Authority Western Province</p></div>"
            );
            infowindow.open(map, this);
        });



       infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker3, 'mouseover', function ()
        {
            infowindow.setContent
            ("<div style='float:left;height:auto; width: auto' align='center'><img src='DumpLocations/deldora.png'>"+
                "<p>Deldorawatta Garbage Recycling Center</p></div>"
            );
            infowindow.open(map, this);
        });



        infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker4, 'mouseover', function ()
        {
            infowindow.setContent
            ("<div style='float:left;height:auto; width: auto' align='center'><img src='DumpLocations/katunayake.png'>"+
                "<p>katunayake seeduwa urban council dump yard</p></div>"
            );
            infowindow.open(map, this);
        });

        infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker5, 'mouseover', function ()
        {
            infowindow.setContent
            ("<div style='float:left;height:auto; width: auto' align='center'><img src='DumpLocations/CWMP.png'>"+
                "<p>Ceylon Waste Management (Pvt) Ltd</p></div>"
            );
            infowindow.open(map, this);
        });

    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_EDesHajAcy9y9IPukYsRgqrDA_MdZVo&callback=MapLoading"></script>





<?php
include_once 'PageFooter.php'
?>



