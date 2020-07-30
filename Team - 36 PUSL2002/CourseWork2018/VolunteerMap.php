<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

include_once 'PageHeader.php';
include 'MapFunctions.php';
?>

<?php
if(isset($_POST["submit"]))
{
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false)
    {
        $uname = $_SESSION['username'];
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $db = new mysqli('localhost', 'root', '', 'cmcdb');
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $dataTime = date("Y-m-d");
        $insert = $db->query("INSERT into images (username,image, created) VALUES ('$uname','$imgContent', '$dataTime')");
        if($insert)
        {
            echo "<script>alert('data inserted successfully')</script>";
        }
        else
        {
            echo "<script>alert('failed to insert data')</script>";
        }

    }
}

?>
    <title>VolunteerMap - CMC</title>
    <link rel="stylesheet" type="text/css" href="AccountsStyle.css">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_EDesHajAcy9y9IPukYsRgqrDA_MdZVo">
    </script>

    <div class="logout" align="right">
        <?php  if (isset($_SESSION['username'])) : ?>
            &nbsp;<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong>
                <a href="VolunteerMap.php?logout='1'" style="color: red;">Logout</a> </p>
        <?php endif ?>
    </div>

    <div id="map"style="height: 500px;width: 100%"></div>
    <script>
        var infowindow;
        var map;
        var marker;
        var green_pin =  'https://maps.gstatic.com/mapfiles/ms2/micons/grn-pushpin.png' ;
        var CMC = { lat: 6.9157, lng: 79.8636 };
        var mapProperties =
            {
                zoom: 12,
                center: new google.maps.LatLng(6.927079,79.861244)
            };
        map = new google.maps.Map(document.getElementById('map'), mapProperties);
        marker = new google.maps.Marker(
            {
                position: CMC,
                map: map,
                icon: "images/Government-Icon.png"
            });


        var markers = {};

        var getMarkerUniqueId= function(lat, lng)
        {
            return lat + '_' + lng;
        };

        var getLatLng = function(lat, lng)
        {
            return new google.maps.LatLng(lat, lng);
        };

        var addMarker = google.maps.event.addListener(map, 'click', function(e)
        {
            var lat = e.latLng.lat(); // lat of clicked point
            var lng = e.latLng.lng(); // lng of clicked point
            var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
            var marker = new google.maps.Marker(
                {
                    position: getLatLng(lat, lng),
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon:green_pin,
                    id: 'marker_' + markerId,
                    html:
                        "<form method='post' enctype='multipart/form-data'>"+
                        "<div id='info_"+markerId+"'>\n" +
                        "        <table class=\"map1\">\n" +
                        "            <tr>\n" +
                        "                <td><a>Description:</a></td>\n" +
                        "                <td><textarea id='description' placeholder='Description'></textarea></td></tr>\n" +
                        "       <tr>\n" +
                        "                <td><a>Image:</a></td>\n" +
                        "                <td><input type='file' name='image' /></td></tr>\n" +
                        "            <tr><td></td><td><input type='submit' name='submit' value='Save' onclick='saveData("+lat+","+lng+")'/></td></tr>\n" +
                        "        </table>\n" +
                        "    </div></form>"
                });

            markers[markerId] = marker; // cache marker in markers object
            bindMarkerinfo(marker); // bind infowindow with click event to marker
        });

        var bindMarkerinfo = function(marker)
        {
            google.maps.event.addListener(marker, "click", function (point)
            {
                var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
                var marker = markers[markerId]; // find marker
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent(marker.html);
                infowindow.open(map, marker);
            });
        };

        function saveData(lat,lng)
        {
            var description =  document.getElementById('description').value;
            var url = 'MapFunctions.php?add_location&description=' + description + '&lat=' + lat + '&lng=' + lng;
            downloadUrl(url, function(data, responseCode)
            {
                if (responseCode === 200  && data.length > 1)
                {
                    var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
                    var manual_marker = markers[markerId]; // find marker
                    manual_marker.setIcon(green_pin);
                    infowindow.close();
                    infowindow.setContent("<div style=' color:black; font-size: 12px;'>Location inserted</div>");
                    infowindow.open(map, manual_marker);
                }
                else
                {
                    console.log(responseCode);
                    console.log(data);
                    infowindow.setContent("<div style='color: red; font-size: 12px;'>Inserting Errors</div>");
                }
            });
        }

        function downloadUrl(url, callback)
        {
            var request = window.ActiveXObject ?
                new ActiveXObject('Microsoft.XMLHTTP') :
                new XMLHttpRequest;

            request.onreadystatechange = function()
            {
                if (request.readyState == 4) {
                    callback(request.responseText, request.status);
                }
            };
            request.open('GET', url, true);
            request.send(null);
        }


    </script>


<?php
include_once 'PageFooter.php';
?>