<?php
require_once("process_store.php");
include("head.php");

if (!isset($_GET['id'])) {
    header("location: index.php");
} else {
    $id = $_GET['id'];
}

$checkStore = $mysqli->query("SELECT * FROM pharmacy_store WHERE id='$id' ");
$store = mysqli_fetch_array($checkStore)
?>
<title>PharmaClique - Pharmacy</title>

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
                            <h1 class="h3 mb-0 text-gray-800">Pharmacy - <?php echo $store["store_name"]; ?></h1>
                        </div>

                        <div class="row">
                            <!-- Search Medicine -->
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Search Medicine</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" @submit.prevent="searchMedicine()">
                                            <div class="row">
                                                <div class="col-lg-8 mb-4">
                                                    <input class="form-control" type="text" id="search" placeholder="Search Medicine" v-model="searchValue" />
                                                </div>
                                                <div class="col-lg-4 mb-4">
                                                    <button id="searchbutton" class="btn btn-success" type="submit">Search</button>
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
                                                                    <p class="product-text genre">{{p.product_brand}}</p>                                                                    <span v-if="p.product_type === '0'" class="badge badge-success badge-counter">Prescription not needed</span>
                                                                    <span v-if="p.product_type === '1'" class="badge badge-primary badge-counter">Physical buying</span>
                                                                    <span v-if="p.product_type === '2'" class="badge badge-secondary badge-counter">Prescription needed</span>
                                                                    <a v-if="p.product_type != '1'" @click="addToCart(p.product_id, p.store_id, p.product_price)" style="float: right; color: black !important;" class="btn btn-sm btn-warning">Add to cart</a>
                                                                </div>
                                                            </div>
                                                        </span>

                                                        <div class="product" style="display: none;">
                                                            <div class="product-img">
                                                                <img src="https://placeimg.com/400/650/nature">
                                                            </div>
                                                            <div class="product-content">
                                                                <h3>
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti maxime doloribus sint, repudiandae.
                                                                    <small>Consectetur Adipisicing</small>
                                                                </h3>
                                                                <p class="product-text price">$9.99</p>
                                                                <p class="product-text genre">DVD Rental</p>
                                                            </div>
                                                        </div>
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
                            //Notification
                            showNotification: false,
                            messageNotification: null,

                            //Search Value
                            searchValue: null,
                            products: null,
                            productsLen: null,
                            productsMessage: null
                        }
                    },
                    methods: {

                        //Get Products
                        async getProducts() {
                            const options = {
                                method: "GET",
                                url: "process_store.php?getProducts=" + <?php echo $id; ?>,
                                headers: {
                                    Accept: "application/json",
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    this.products = response.data;
                                    this.productsLen = this.products.length;
                                    if (this.productsLen === 0) {
                                        this.productsMessage = "This pharmacy does not have current listing for medicines / products.";
                                    }
                                    console.log(this.products);
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Search Medicine
                        async searchMedicine() {
                            storeId = <?php echo $id; ?>;
                            const options = {
                                method: "POST",
                                url: "process_store.php?searchProductsWithinStore",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    searchVal: this.searchValue,
                                    store_id: storeId,
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    this.products = response.data;
                                    this.productsLen = this.products.length;
                                    if(this.productsLen === 0){
                                        this.productsMessage = "Your search did not return results.";
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
                    async created() {
                        //Get Products
                        await this.getProducts();
                    },

                });
            </script>
</body>

</html>