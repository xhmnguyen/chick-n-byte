<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Now - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=" async defer></script>
</head>

<body>
    
    <!-- Header -->
    <?php
    include 'phpscripts/header.php';
    ?>

    <!-- Store Pickup or Delivery -->
    <script>
        function setOrderType(type) {
            const pickup = document.getElementById('pickup');
            const delivery = document.getElementById('delivery');
    
            pickup.classList.remove('active');
            delivery.classList.remove('active');
    
            if (type === 'pickup') {
                pickup.classList.add('active');
            } else if (type === 'delivery') {
                delivery.classList.add('active');
            }
        }
    </script>

    <!-- Pickup/Delivery/Address -->
    <div class="order-container">
        <div class="order-options">
            <div class="order-buttons">
                <button class="order-type" id="pickup" onclick="setOrderType('pickup')">Pickup</button>
                <button class="order-type" id="delivery" onclick="setOrderType('delivery')">Delivery</button>
            </div> 
        </div>

        <div class="address-search">
            <input type="text" id="address" placeholder="City, State, or ZIP" name="address" required>
            <button type="submit">Search</button>
        </div>           
    </div>

    
    <!-- Map -->
    <div class="map-container" id="map"></div>

    <!-- Footer -->
    <?php
    include 'phpscripts/footer.php';
    ?>

    <script>
        let map;
        let geocoder;
    
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 34.3668, lng: -89.5192 },
                zoom: 12,
            });
    
            geocoder = new google.maps.Geocoder();
        }
    
        function findLocation() {
            const address = document.getElementById("address").value;
            if (address) {
                geocoder.geocode({ 'address': address }, function(results, status) {
                    if (status === 'OK') {
                        map.setCenter(results[0].geometry.location);
                        new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                        });
                    }
                });
            }
        }
    
        document.getElementById("address").addEventListener("change", findLocation);
    </script>
    

</body>
</html>
