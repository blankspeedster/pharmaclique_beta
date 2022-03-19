<?php
require_once("process_pharmacy.php");
include("head.php");

$user_id = $_SESSION['user_id'];
$checkStore = $mysqli->query("SELECT * FROM pharmacy_store WHERE user_id='$user_id' ");
$storeExist = false;
$storeId = 0;
if (mysqli_num_rows($checkStore) > 0) {
    $storeExist = true;
    $store = $checkStore->fetch_array();
    $storeId = $store['id'];
}
?>
<title>PharmaClique - Settings</title>
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
            <div id="content">

                <!-- Topbar -->
                <?php include("topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div id="vueApp">

                        <!-- Notification here -->
                        <?php
                        if (isset($_SESSION['pharmacyError'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $_SESSION['pharmacyError'];
                                unset($_SESSION['pharmacyError']);
                                ?>
                            </div>
                        <?php } ?>
                        <!-- End Notification -->


                        <!-- Notification here -->
                        <div v-if="showNotification" class="alert alert-success alert-dismissible">
                            <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a>
                            {{ messageNotification }}
                        </div>
                        <!-- End Notification -->


                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Settings</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Storename and Location</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <!-- <div class="collapse show" id="collapseCardExample"> -->
                                    <!-- <div class="collapse <?php //if (!$storeExist) { echo "show"; } 
                                                                ?>" id="collapseStore"> -->
                                    <div class="collapse show" id="collapseStore">
                                        <div class="card-body">
                                            <form method="post" action="process_settings.php">
                                                <div class="row">
                                                    <!-- Store Name -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Store Name</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editStoreName" type="text" class="form-control" name="store_name" value="<?php if ($storeExist) {
                                                                                                                                                                    echo $store['store_name'];
                                                                                                                                                                } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Store Address</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <textarea :disabled="!editStoreName" class="form-control" name="address"><?php if ($storeExist) {
                                                                                                                                                    echo $store['address'];
                                                                                                                                                } ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Description</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <textarea :disabled="!editStoreName" class="form-control" name="description"><?php if ($storeExist) {
                                                                                                                                                        echo $store['description'];
                                                                                                                                                    } ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- User Location -->
                                                    <div class="col-xl-6 col-md-6 mb-4" style="visibility: hidden;">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Current location</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input type="text" readonly class="" name="latitude" v-model="lat">
                                                                    <input type="text" readonly class="" name="longitude" v-model="long">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <br>
                                                    Please drag the pin for accurate location of your store. Once done, click Save or Update to save the changes.

                                                    <!-- Location in map -->
                                                    <!-- <div class="row mb-4"> -->
                                                    <div class="col-lg-12 col-md-12 mb-md-0 mb-4" style="height: 500px !important;">
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
                                                    <!-- </div> -->


                                                    <div class="col-xl-12 col-md-12 mb-4 mt-4" style="">
                                                        <?php if (!$storeExist) { ?>
                                                            <button type="submit" style="float: right;" class="btn btn-primary btn-sm m-1" :disabled="!editStoreName" name="save_storename">
                                                                <i class="far fa-save"></i> Save Store Information
                                                            </button>
                                                            <a v-if="!editStoreName" style="float: right;" class="btn btn-success btn-sm m-1" @click="editStoreName = true">
                                                                <i class="far fa-edit"></i> Edit
                                                            </a>
                                                            <a v-else style="float: right;" class="btn btn-warning btn-sm m-1" @click="editStoreName = false">
                                                                <i class="far fa-window-close"></i> Cancel
                                                            </a>
                                                        <?php } else { ?>
                                                            <input type="text" name="store_id" value="<?php echo $store['id']; ?>" style="visibility: hidden;">
                                                            <button type="submit" style="float: right;" class="btn btn-info btn-sm m-1" name="update_storename" :disabled="!editStoreName">
                                                                <i class="far fa-save"></i> Update Store Information
                                                            </button>
                                                            <a v-if="!editStoreName" style="float: right;" class="btn btn-success btn-sm m-1" @click="editStoreName = true">
                                                                <i class="far fa-edit"></i> Edit
                                                            </a>
                                                            <a v-else style="float: right;" class="btn btn-warning btn-sm m-1" @click="editStoreName = false">
                                                                <i class="far fa-window-close"></i> Cancel
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Do not delete -->
                        <div class="row">
                            <!-- Add Propducts - Collapsable -->
                            <div class="col-lg-12" id="addEditProduct" style="display: none;">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseAddProduct">
                                        <div class="card-body">
                                            <!-- <form @submit.prevent="postProduct"> -->
                                            <form>
                                                <div class="row">

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

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
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/datatables-demo.js"></script>

        <script>
            new Vue({
                el: "#vueApp",
                data() {
                    return {
                        editStoreName: false,
                        store_name: "",

                        //Product
                        name: null,
                        description: null,
                        category: 1,
                        stock: null,
                        price: 0,
                        weight: 0,
                        brand: null,
                        isEditProduct: false,

                        //Product list
                        products: [],
                        product_id: null,
                        //Notification
                        showNotification: false,
                        messageNotification: null,
                        isSaving: false,
                        saveBtnProduct: "Save Product Information",
                        updateBtnProduct: "Update Product Information",

                        //Store Location
                        long: 0,
                        lat: 0,
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


                        <?php if(!$storeExist){ ?>
                        var userLat = this.lat;
                        var userLong = this.long;
                        <?php } else { ?>
                        var userLat = <?php echo $store['latitude']; ?>;
                        var userLong = <?php echo $store['longitude']; ?>;
                        <?php } ?>

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

                        var userIcon = L.icon({
                            iconUrl: '../assets/images/pharmacy.png',
                            iconSize: [50, 50],
                            iconAnchor: [25, 25]
                        });

                        L.marker([userLat, userLong], {draggable: true,
                            clickable: true
                            }).on('dragend', (e)=>{
                            e.target.getLatLng().lat;
                            e.target.getLatLng().lng;
                            this.lat = e.target.getLatLng().lat;
                            this.long = e.target.getLatLng().lng;
                            }).addTo(map)
                            .bindPopup('Your Location', {
                                autoPan: false
                            })
                            .openPopup();

                        // This is the one with custom icon
                        // L.marker([userLat, userLong], {
                        //         icon: userIcon
                        //     }).addTo(map)
                        //     .bindPopup('Your Location', {
                        //         autoPan: false
                        //     })
                        //     .openPopup();

                        // this.delay(60000).then(() => this.getLocation());
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
                async created() {
                    this.getLocation();
                },
            });
        </script>
</body>

</html>