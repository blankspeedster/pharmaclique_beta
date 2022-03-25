<?php
require_once("process_rider.php");
include("head.php");
$getCurrentBooking =  $mysqli->query("SELECT * FROM rider_transaction WHERE delivered = '0' ") or die($mysqli->error);
if (mysqli_num_rows($getCurrentBooking) <= 0) {
    header("location: rides.php");
    }
$booking = mysqli_fetch_array($getCurrentBooking);
$booking_id = $booking["id"];
?>

<title>PharmaClique - Rides</title>
<style>
    #map {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="vueApp">

                <div id="content">

                    <!-- Topbar -->
                    <?php include("topbar.php"); ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Notification here -->
                        <div v-if="showNotification" class="alert alert-success alert-dismissible">
                            <!-- <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a> -->
                            {{ messageNotification }}
                        </div>
                        <!-- End Notification -->
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h5 class="h5 mb-0 text-gray-800">Rides</h5>
                        </div>

                        <!-- Pending orders waiting for acceptance from rider -->
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Here is the pending order for pickup</h6>
                                    </div>
                                    <div class="card-body">
                                        <span v-for="b in currentBooking">
                                            <div class="row card shadow mb-2 mt-2 p-2">
                                                <div class="col-lg-12">
                                                    <b>Store Name: </b>{{b.store_name}} <br>
                                                    <b>Address: </b> {{b.address}}<br>
                                                    <b>Customer Name: </b> {{b.firstname}} {{b.lastname}} <br>
                                                    <b>Total Amount to be paid: </b> ₱{{b.total_amount - b.delivery_charge}} <br><br>
                                                    <b>Products:</b><br>
                                                    <span v-for="product in b.products">
                                                        {{product.product_name}} x {{product.count}};<br>
                                                    </span>
                                                </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Location and Pharmacy Store -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Map - {{mapMessage}}</h6>
                                </div>
                                <div class="card-body">
                                    <br>
                                    <!-- Location in map -->
                                    <div class="card" style="height: 500px !important;">
                                        <div class="card-header pb-0 bg-gradient-success">
                                            <div class="row">
                                                <div class="col-lg-6 col-7">
                                                    <h6 class="text-white">Current location</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-0 pb-2">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                                <a @click="updateRiderLocationClick()" class="btn btn-info m-2"> Update location</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
        </div>
        <!-- End of Main Content -->

        <?php include("footer.php"); ?>

        <!-- Start scripts here -->

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/chart-area-demo.js"></script>
        <script src="../js/demo/chart-pie-demo.js"></script>

        <!-- End scripts here -->
        <script>
            var map, rider, destination, customer, customerCircle;
            new Vue({
                el: "#vueApp",
                data() {
                    return {
                        showNotification: false,
                        messageNotification: "",
                        currentBooking: null,
                        booking_id: <?php echo $booking_id; ?>,
                        user_id: <?php echo $_SESSION['user_id']; ?>,

                        lat: null,
                        long: null,

                        //Pharmacy Location
                        pharmaLat: null,
                        pharmaLong: null,
                        customerLat: null,
                        customerLong: null,
                        status: null,
                        mapMessage: null,
                    }
                },
                methods: {
                    //Get Current Orders
                    async getCurrentBooking() {
                        const options = {
                            method: "POST",
                            url: "process_rider.php?getCurrentBooking",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                user_id: this.user_id,
                                booking_id: this.booking_id,
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.currentBooking = response.data;
                                this.pharmaLat = response.data[0].pharmacyLat;
                                this.pharmaLong = response.data[0].pharmacyLong;
                                this.status = response.data[0].status;
                                this.customerLat = response.data[0].user_lat;
                                this.customerLong = response.data[0].user_long;

                                //Set Message
                                if (this.status === "-1") {
                                    this.mapMessage = "On the way to the Pharmacy";
                                } else if (this.status === "-2") {
                                    this.mapMessage = "On the way to the Customer";
                                }

                            })
                            .catch((error) => {
                                console.log(error);
                            });

                            // this.loopGetRider();
                    },

                    //Purely GeoLocationn Stuff here
                    //Get Geo Location
                    getLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(this.showPosition, this.showError);
                        } else {
                            this.long = "Geolocation is not supported by this browser.";
                        }
                    },

                    async showPosition(position) {
                        this.lat = position.coords.latitude;
                        this.long = position.coords.longitude;

                        var userLat = this.lat;
                        var userLong = this.long;

                        //Show Markers
                        var container = L.DomUtil.get('map');
                        if (container != null) {
                            container._leaflet_id = null;
                        }
                        map = L.map('map', {
                                center: [9.0820, 8.6753],
                                zoom: 8
                            }).setView([userLat, userLong], 13);
                        var gl = L.mapboxGL({
                            attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
                            style: 'https://api.maptiler.com/maps/osm-standard/style.json?key=gcypTzmAMjrlMg46MJG3#5.9/16.04327/120.29239'
                        }).addTo(map);
                        navigator.geolocation.getCurrentPosition(this.renderRider, this.showError);
                        // this.loopGetRider();
                    },

                    //Loop Get Rider Location
                    loopGetRider(){
                        let newTime = 20000;
                        setInterval(() => {
                            navigator.geolocation.getCurrentPosition(this.renderRider, this.showError)
                        }, newTime);
                        // this.delay(newTime).then(() => navigator.geolocation.getCurrentPosition(this.renderRider, this.showError));
                        console.log("renderRider");
                    },

                    //Force Update Location
                    updateRiderLocationClick(){
                        navigator.geolocation.getCurrentPosition(this.clickRenderRider, this.showError);
                        console.log("updateRiderLocation");
                    },

                    //Render Rider
                    async renderRider(position) {
                        this.lat = position.coords.latitude;
                        this.long = position.coords.longitude;
                        let accuracy = position.coords.accuracy;

                        if (rider) {
                            map.removeLayer(rider)
                        }

                        if (destination) {
                            map.removeControl(destination)
                        }

                        if (customerCircle) {
                            map.removeControl(customerCircle)
                        }


                        var riderIcon = L.icon({
                            iconUrl: '../assets/images/rider.png',
                            iconSize: [50, 50],
                            iconAnchor: [25, 25]
                        });

                        // Current Position
                        rider = L.marker([this.lat, this.long], {
                                clickable: true,
                                icon: riderIcon,
                            }).addTo(map)
                            .bindPopup('You are here', {
                                autoPan: false
                            })
                            .openPopup();

                        //Add Routing
                        // Code to Add Routing
                        //If Status is -1 (For Pick up)
                        if (this.status === "-1") {
                            destination = L.Routing.control({
                                waypoints: [
                                    L.latLng(this.lat, this.long),
                                    L.latLng(this.pharmaLat, this.pharmaLong)
                                ]
                            }).addTo(map);
                            L.marker([this.pharmaLat, this.pharmaLong], {
                                clickable: true,
                            }).addTo(map)
                            .bindPopup('Descination: Pharmacy', {
                                autoPan: true
                            })
                            .openPopup();                            
                            // customerCircle = L.circle([this.customerLat, this.customerLong], { radius: 2000 }).addTo(map);
                        } else if (this.status === "-2") {
                            destination = L.Routing.control({
                                waypoints: [
                                    L.latLng(this.lat, this.long),
                                    L.latLng(this.customerLat, this.customerLong)
                                ]
                            }).addTo(map);
                            L.marker([this.customerLat, this.customerLong], {
                                clickable: true,
                            }).addTo(map)
                            .bindPopup('Descination: Customer', {
                                autoPan: false
                            })
                            .openPopup();   
                            // customerCircle = L.circle([this.customerLat, this.customerLong], { radius: 2000 }).addTo(map);
                        }

                        // End Code to Routing
                        this.getCurrentBooking();
                    },

                    //Render Rider on Click
                    async clickRenderRider(position) {
                        this.lat = position.coords.latitude;
                        this.long = position.coords.longitude;
                        let accuracy = position.coords.accuracy;

                        if (rider) {
                            map.removeLayer(rider)
                        }

                        if (destination) {
                            map.removeControl(destination)
                        }

                        if (customerCircle) {
                            map.removeControl(customerCircle)
                        }


                        var riderIcon = L.icon({
                            iconUrl: '../assets/images/rider.png',
                            iconSize: [50, 50],
                            iconAnchor: [25, 25]
                        });

                        // Current Position
                        rider = L.marker([this.lat, this.long], {
                                clickable: true,
                                icon: riderIcon,
                            }).addTo(map)
                            .bindPopup('You are here', {
                                autoPan: false
                            })
                            .openPopup();

                        //Add Routing
                        // Code to Add Routing
                        //If Status is -1 (For Pick up)
                        if (this.status === "-1") {
                            destination = L.Routing.control({
                                waypoints: [
                                    L.latLng(this.lat, this.long),
                                    L.latLng(this.pharmaLat, this.pharmaLong)
                                ]
                            }).addTo(map);
                            L.marker([this.pharmaLat, this.pharmaLong], {
                                clickable: true,
                            }).addTo(map)
                            .bindPopup('Descination: Pharmacy', {
                                autoPan: true
                            })
                            .openPopup();                            
                            // customerCircle = L.circle([this.customerLat, this.customerLong], { radius: 2000 }).addTo(map);
                        } else if (this.status === "-2") {
                            destination = L.Routing.control({
                                waypoints: [
                                    L.latLng(this.lat, this.long),
                                    L.latLng(this.customerLat, this.customerLong)
                                ]
                            }).addTo(map);
                            L.marker([this.customerLat, this.customerLong], {
                                clickable: true,
                            }).addTo(map)
                            .bindPopup('Descination: Customer', {
                                autoPan: false
                            })
                            .openPopup();   
                            // customerCircle = L.circle([this.customerLat, this.customerLong], { radius: 2000 }).addTo(map);
                        }

                        // End Code to Routing
                        this.getCurrentBooking();
                    },

                    //Function for delay
                    delay(time) {
                        return new Promise(resolve => setTimeout(resolve, time));
                    },

                    //Show Error
                    showError(error) {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                this.long = "User denied the request for Geolocation."
                                break;
                            case error.POSITION_UNAVAILABLE:
                                this.long = "Location information is unavailable."
                                break;
                            case error.TIMEOUT:
                                this.long = "The request to get user location timed out."
                                break;
                            case error.UNKNOWN_ERROR:
                                this.long = "An unknown error occurred."
                                break;
                        }
                    },

                },
                async mounted() {
                    await this.getCurrentBooking();
                    await this.getLocation();
                    this.loopGetRider();
                }
            });
        </script>
</body>

</html>