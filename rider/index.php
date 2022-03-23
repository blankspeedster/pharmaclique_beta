<?php
require_once("dbh.php");
include("head.php");

$user_id = $_SESSION['user_id'];
$getCurrentBooking =  $mysqli->query("SELECT * FROM rider_transaction WHERE delivered = '0' ") or die($mysqli->error);
if(mysqli_num_rows($getCurrentBooking) >= 1){
    // header("location: rides.php");
    }
?>

<title>PharmaClique - Rider Home</title>
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

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Home</h1>
                            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                        </div>

                        <!-- Notification here -->
                        <a href="rides.php">
                        <div v-if="showNotification" class="alert alert-success alert-dismissible">
                            {{ messageNotification }}
                        </div>
                        </a>
                        <!-- End Notification -->

                        <!-- Pending orders waiting for acceptance from rider -->
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Here are the pending orders for pickup</h6>
                                    </div>
                                    <div class="card-body">
                                        <span v-for="o in pendingOrders">
                                            <div class="row card shadow mb-2 mt-2 p-2">
                                                <div class="col-lg-12">
                                                    <b>Store Name: </b>{{o.store_name}} <br>
                                                    <b>Address: </b> {{o.address}}<br>
                                                    <b>Customer Name: </b> {{o.firstname}} {{o.lastname}} <br>
                                                    <b>Total Amount to be paid: </b> ₱{{o.total_amount - o.delivery_charge}} <br><br>
                                                    Products:<br>
                                                    <span v-for="product in o.products">
                                                        {{product.product_name}} x {{product.count}}
                                                    </span>
                                                </div>
                                                <div class="mb-2">
                                                    <button @click="acceptBooking(o.transactionId, o.customer_long, o.customer_lat)" class="btn btn-sm btn-success m-1" style="float: right;">Accept Booking</button>
                                                </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pharmacy Store -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">My Location</h6>
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
        <!-- <script src="../js/demo/chart-area-demo.js"></script> -->
        <!-- <script src="../js/demo/chart-pie-demo.js"></script> -->

        <!-- End scripts here -->
        <script>
            new Vue({
                el: "#vueApp",
                data() {
                    return {
                        pendingOrders: null,
                        lat: null,
                        long: null,

                        showNotification: false,
                        messageNotification: null
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

                        var riderIcon = L.icon({
                            iconUrl: '../assets/images/rider.png',
                            iconSize: [50, 50],
                            iconAnchor: [25, 25]
                        });

                        //Current Position
                        L.marker([userLat, userLong], {
                                draggable: true,
                                clickable: true,
                                icon: riderIcon
                            }).on('dragend', (e) => {
                                e.target.getLatLng().lat;
                                e.target.getLatLng().lng;
                                this.lat = e.target.getLatLng().lat;
                                this.long = e.target.getLatLng().lng;
                            }).addTo(map)
                            .bindPopup('You are here', {
                                autoPan: true
                            });

                        //Add Routing
                        // Code to Add Routing
                        // L.Routing.control({
                        //     waypoints: [
                        //         L.latLng(userLat, userLong),
                        //         L.latLng(15.158700522438865, 120.59249274173763) //SPCF
                        //     ]
                        // }).addTo(map);
                        // End Code to Routing
                    },

                    //Get Transaction accepted by the pharmacy
                    async getTransaction() {
                        const options = {
                            method: "GET",
                            url: "process_rider.php?getTransaction",
                            headers: {
                                Accept: "application/json",
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.pendingOrders = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        
                        this.loopTransaction();
                    },

                    //Loop Transaction
                    async loopTransaction(){
                        setInterval(() => {
                            this.getTransaction();
                        }, 25000);
                    },

                    //Accept Transaction
                    async acceptBooking(transactionId, customer_lat, customer_long) {
                        let userId = <?php echo $_SESSION["user_id"]; ?>;
                        const options = {
                            method: "POST",
                            url: "process_rider.php?acceptBooking",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                transaction_id: transactionId,
                                user_id: userId,
                                long: this.long,
                                lat: this.lat,
                                customer_lat: customer_lat,
                                customer_long: customer_long
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.getTransaction();
                                this.showNotification = true;
                                this.messageNotification = "You have accepted a booking delivery. Click this notification to proceed to your ride information.";
                            })
                            .catch((error) => {
                                console.log(error);
                            });
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
                    await this.getLocation();
                    await this.getTransaction();
                }
            });
        </script>
</body>

</html>