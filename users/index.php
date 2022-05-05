<?php
require_once("process_index.php");
include("head.php");
?>
<title>PharmaClique - Home</title>
<style>
    #map {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    @media only screen and (max-width: 600px) {
        .for-desktop{
            display: none;
        }
        .for-mobile{
            display: block;
        }
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
                        <div v-if="showNotification" class="alert alert-success alert-dismissible">
                            <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a>
                            {{ messageNotification }}
                        </div>

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Home</h1>
                        </div>

                        <div class="row for-desktop">
                            <!-- Search Medicine -->
                            <div class="col-lg-12 mb-2">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Search Medicine</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" @submit.prevent="searchMedicine()">
                                            <div class="row">
                                                <div class="col-lg-8 mb-4">
                                                    <input class="form-control" type="text" id="search" placeholder="Search Medicine" style="width: 100%;" v-model="searchValue" />
                                                </div>
                                                <div class="col-lg-4 mb-4">
                                                    <button id="searchbutton" class="btn btn-success" type="submit" style="width: 100%;">
                                                        <i class="fas fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-lg-12">
                                            <div class="products">
                                                <span v-for="p in products">
                                                    <div class="product">
                                                        <div class="product-img">
                                                            <img :src="'../assets/images/'+p.product_url">

                                                        </div>
                                                        <div class="product-content">
                                                            <h3>
                                                                {{p.product_name}}
                                                                <small>{{p.product_description}}</small>
                                                            </h3>
                                                            <p class="product-text price">₱{{p.product_price}}</p>
                                                            <p class="product-text genre">{{p.product_brand}}</p>
                                                            <p class="product-text genre">{{p.product_stock}} pcs available</p>
                                                            <span v-if="p.product_type === '0'" class="badge badge-success badge-counter">Prescription not needed</span>
                                                            <span v-if="p.product_type === '1'" class="badge badge-primary badge-counter">Physical buying</span>
                                                            <span v-if="p.product_type === '2'" class="badge badge-secondary badge-counter">Prescription needed</span>
                                                            <p class="product-text genre"><a :href="'store.php?id='+p.store_id"><i>{{p.store_name}}</i></a></p>
                                                            <a v-if="p.product_type != '1'" @click="addToCart(p.product_id, p.store_id, p.product_price)" style="float: right; color: black !important;" class="btn btn-sm btn-warning">Add to cart</a>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- List of bookings -->

                        <div class="row for-mobile">
                            <!-- Search Medicine -->
                            <div class="col-lg-12 mb-2">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Search Medicine</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" @submit.prevent="searchMedicine()">
                                            <div class="row">
                                                <div class="col-lg-8 mb-4">
                                                    <input class="form-control" type="text" id="search" placeholder="Search Medicine" style="width: 100%;" v-model="searchValue" />
                                                </div>
                                                <div class="col-lg-4 mb-4">
                                                    <button id="searchbutton" class="btn btn-success" type="submit" style="width: 100%;">
                                                        <i class="fas fa-search"></i> Search
                                                    </button>
                                                </div>
                                                <div class="col-lg-12 mb-4">
                                                    <div class="products products-table">
                                                        <span v-for="p in products">
                                                            <div class="product">
                                                                <div class="product-img">
                                                                    <img :src="'../assets/images/'+p.product_url">

                                                                </div>
                                                                <div class="product-content">
                                                                    <h3>
                                                                        {{p.product_name}}
                                                                        <small>{{p.product_description}}</small>
                                                                    </h3>
                                                                    <p class="product-text price">₱{{p.product_price}}</p>
                                                                    <p class="product-text genre">{{p.product_brand}}</p>
                                                                    <p class="product-text genre">{{p.product_stock}} pcs available</p>
                                                                    <span v-if="p.product_type === '0'" class="badge badge-success badge-counter">Prescription not needed</span>
                                                                    <span v-if="p.product_type === '1'" class="badge badge-primary badge-counter">Physical buying</span>
                                                                    <span v-if="p.product_type === '2'" class="badge badge-secondary badge-counter">Prescription needed</span>
                                                                    <p class="product-text genre"><a :href="'store.php?id='+p.store_id"><i>{{p.store_name}}</i></a></p>
                                                                    <a v-if="p.product_type != '1'" @click="addToCart(p.product_id, p.store_id, p.product_price)" style="float: right; color: black !important;" class="btn btn-sm btn-warning">Add to cart</a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- if no products in pharmacy currently -->
                        <div v-if="productsLen === 0" class="alert alert-success alert-dismissible">
                            {{productsMessage}}
                        </div>
                        <!-- if no products in pharmacy currently -->

                        <!-- Pharmacy Store -->
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Pharmacy Store</h6>
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

        <!-- End scripts here -->
        <script>
            new Vue({
                el: "#vueApp",
                data() {
                    return {
                        //data model here
                        searchValue: null,
                        products: [],
                        productsMessage: null,
                        productsLen: null,
                        showNotification: false,
                        messageNotification: "",
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

                    //Get Pharmacys
                    async getPharmacys() {
                        const options = {
                            method: "GET",
                            url: "process_index.php?getPharmacy",
                            headers: {
                                Accept: "application/json",
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                this.pharmacys = response;
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

                    //Search Medicine
                    async searchMedicine() {
                        const options = {
                            method: "POST",
                            url: "process_store.php?searchProducts",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                searchVal: this.searchValue,
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                this.products = response.data;
                                this.productsLen = this.products.length;
                                if (this.productsLen === 0) {
                                    this.productsMessage = "Your search term did not return results";
                                }
                                console.log(this.products);
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                    //Add To Cart
                    async addToCart(productId, storeId, subTotal) {
                        var userId = <?php echo $_SESSION['user_id']; ?>;
                        const options = {
                            method: "POST",
                            url: "process_store.php?addToCart",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                product_id: productId,
                                pharmacy_id: storeId,
                                user_id: userId,
                                subtotal: subTotal
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.showNotification = true;
                                this.messageNotification = response.data.response;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },
                },
                async mounted() {
                    await this.getPharmacys();
                    this.getLocation();
                    await this.searchMedicine();
                }
            });
        </script>
</body>

</html>