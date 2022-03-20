<?php
require_once("process_index.php");
$user_counts = $mysqli->query("SELECT COUNT(id) AS total_count FROM users") or die($mysqli->error());
$user_count = $user_counts->fetch_array();
$user_count = $user_count['total_count'];
include("head.php");
?>

<title>PharmaClique - Place Order</title>
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
                            <!-- <h1 class="h3 mb-0 text-gray-800">Place Order</h1> -->
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <!-- Pharmacy Store -->
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Your current location</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" class="mb-4">
                                            <div class="col-lg-6">
                                                Current Subtotal: <input type="text" class="form-control" v-model="subtotal" readonly>
                                            </div>
                                            <div class="col-lg-6">
                                                Delivery Charge: <input type="number" step="0.1" class="form-control" v-model="deliveryCharge" readonly>
                                            </div>                                            
                                        </div>

                                        <input type="text" class=" mt-4 form-control" v-model="completeAddress" placeholder="Please type your complete address here.">
                                        <br>
                                        <!-- Location in map -->
                                        <div class="card" style="height: 500px !important;">
                                            <div class="card-header pb-0 bg-gradient-success">
                                                <div class="row">
                                                    <div class="col-lg-12 col-12">
                                                        <h6 class="text-white">Current location</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body px-0 pb-2">
                                                <div id="map"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span v-if="!orderPlacedSuccesful">
                                    <button v-if="!placingOrder" @click="placeOrder()" style="float: right;" class="m-1 btn btn-success btn-m">{{placeOrderMessage}}</button>
                                    <button v-else style="float: right;" class="m-1 btn btn-success btn-m" disabled>{{placeOrderMessage}}</button>
                                    <a href="cart.php" style="float: right;" class="m-1 btn btn-danger btn-m">Cancel</a>
                                </span>
                                <span v-if="orderPlacedSuccesful">
                                    <a href="orders.php">
                                    <div class="alert alert-success alert-dismissible">
                                        <!-- <a href="#" class="close" aria-label="close" @click="orderPlacedSuccesful = false">&times;</a> -->
                                        {{ messagePlaceOrder }}
                                    </div>
                                    </a>
                                </span>
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
                new Vue({
                    el: "#vueApp",
                    data() {
                        return {
                            showNotification: false,
                            messageNotification: "",
                            completeAddress: null,
                            subtotal: <?php echo $_SESSION['currentProductsSubtotal']; ?>,
                            deliveryCharge: 49.9,
                            //address for lat and lang
                            lat: null,
                            long: null,

                            //UI
                            placingOrder: false,
                            placeOrderMessage: "Place Order",
                            orderPlacedSuccesful: false,
                            messagePlaceOrder: null,
                        }
                    },
                    methods: {
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
                            var map = L.map('map').setView([userLat, userLong], 13);
                            var gl = L.mapboxGL({
                                attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
                                style: 'https://api.maptiler.com/maps/osm-standard/style.json?key=gcypTzmAMjrlMg46MJG3#5.9/16.04327/120.29239'
                            }).addTo(map);

                            var pharmacyIcon = L.icon({
                                iconUrl: '../assets/images/pharmacy.png',
                                iconSize: [50, 50],
                                iconAnchor: [25, 25]
                            });

                            //Current Position
                            L.marker([userLat, userLong], {
                                    draggable: true,
                                    clickable: true
                                }).on('dragend', (e) => {
                                    e.target.getLatLng().lat;
                                    e.target.getLatLng().lng;
                                    this.lat = e.target.getLatLng().lat;
                                    this.long = e.target.getLatLng().lng;
                                }).addTo(map)
                                .bindPopup('You are here', {
                                    autoPan: false
                                })
                                .openPopup();

                            //Add Routing
                            // Code to Add Routing
                            // L.Routing.control({
                            //     waypoints: [
                            //         L.latLng(userLat, userLong),
                            //         L.latLng(15.158700522438865, 120.59249274173763) //SPCF
                            //     ]
                            // }).addTo(map);
                            // End Code to Routing

                            let pharmacys = this.pharmacys.data;

                            for (i = 0; i < pharmacys.length; i++) {
                                url = "<a href='store.php?id=" + pharmacys[i].id + "'>" + pharmacys[i].store_name + "</a>"
                                L.marker([pharmacys[i].latitude, pharmacys[i].longitude], {
                                        icon: pharmacyIcon
                                    }).addTo(map)
                                    .bindPopup(url, {
                                        autoPan: false
                                    })
                                    .openPopup();
                            }
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

                        //Place Order
                        async placeOrder() {
                            this.placingOrder = true;
                            this.placeOrderMessage = "Placing Order";
                            const options = {
                                method: "POST",
                                url: "process_cart.php?placeOrder",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    lat: this.lat,
                                    long: this.long,
                                    completeAddress: this.completeAddress,
                                    deliveryCharge: this.deliveryCharge
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.placingOrder = false;
                                    this.placeOrderMessage = "Place Order";
                                    this.orderPlacedSuccesful = true;
                                    this.showNotification = false;
                                    this.messagePlaceOrder = "Order Succesful. Pharmacy is currently reviewing your order. You may now this close window.";
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        }

                    },
                    async mounted() {
                        this.getLocation();
                        this.showNotification = true;
                        this.messageNotification = "Checked Out successfully. In order to complete your oder, please move your pin location in the map below, and add your complete address in the field.";
                    }
                });
            </script>
</body>

</html>