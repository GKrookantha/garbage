<?php
session_start();

if (!isset($_SESSION['username']))
{
    header('location: login.php');
}
if (isset($_GET['logout']))
{
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}


include_once 'PageHeader.php';
include_once 'MapFunctions.php';
?>
<title>CaptainMap - CMC</title>
<link rel="stylesheet" type="text/css" href="AccountsStyle.css">


<div class="logout" align="right">

    <?php  if (isset($_SESSION['username'])) : ?>
        &nbsp;<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong>
            <a href="VolunteerMap.php?logout='1'" style="color: red;">Logout</a> </p>
    <?php endif ?>
</div>


<div id="map" style="height: 500px;width: 100%"></div>

<script>
    var map;
    var marker;
    var infowindow;
    var CMC = { lat: 6.9157, lng: 79.8636 };
    var blue_icon =  'http://maps.google.com/mapfiles/ms/icons/blue-dot.png' ;
    var yellow_pin = 'https://maps.gstatic.com/mapfiles/ms2/micons/ylw-pushpin.png' ;
    var locations = <?php get_all_locations() ?>;

    function initMap()
    {
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'),
            {
            center: {lat:6.927079,lng:79.861244},
            zoom: 12
            });
        marker = new google.maps.Marker(
            {
                position: CMC,
                map: map,
                icon: "images/Government-Icon.png"
            });

        var i ; var confirmed = 0;
        for (i = 0; i < locations.length; i++)
        {

            if (locations[i][4] === '1')
            {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: blue_icon,
                    Animation:google.maps.Animation.BOUNCE,
                    html: document.getElementById('form')
                });
            }
            else
            {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: yellow_pin,
                    html: document.getElementById('form')
                });
            }

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                    $("#confirmed").prop(confirmed,locations[i][4]);
                    $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][3]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }

    function saveData() {
        var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
        var id = document.getElementById('id').value;
        var url = 'MapFunctions.php?confirm_location&id=' + id + '&confirmed=' + confirmed ;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200  && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
            }else{
                infowindow.setContent("<div style='color: purple; font-size: 12px;'>Inserting Errors</div>");
            }
        });
    }


    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }


</script>

<div style="display: none" id="form">
    <table class="map1">
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Description:</a></td>
            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
        </tr>
        <tr>
            <td><b>Confirm for Immediate Clean:</b></td>
            <td><input id='confirmed' type='checkbox' name='confirmed'></td>
        </tr>

        <tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
    </table>
</div>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_EDesHajAcy9y9IPukYsRgqrDA_MdZVo&callback=initMap">
</script>