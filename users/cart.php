<?php
require_once("process_index.php");
$user_counts = $mysqli->query("SELECT COUNT(id) AS total_count FROM users") or die($mysqli->error());
$user_count = $user_counts->fetch_array();
$user_count = $user_count['total_count'];
include("head.php");
?>

<title>PharmaClique - Cart</title>
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
                            <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a>
                            {{ messageNotification }}
                        </div>
                        <!-- End Notification -->
                        <!-- Page Heading -->
                        <div class=" align-items-center  mb-4">
                            <h1 class="h3 mb-0 text-gray-800">My Cart</h1>
                            <h6 v-if="!checkedPharmacy">Please select store you wish to place your order. Note that you can only checkout for one pharmacy at a time.</h6>
                            <h6 v-if="checkedPharmacy">Select Products in your cart for checkout.</h6>
                            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                        </div>
                        <br>

                        <!-- Content Row for checking what pharmacy to check out -->

                        <span v-if="!checkedPharmacy" v-for="p in productsInCart">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Collapsable Card Example -->
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Accordion -->
                                        <a :href="'#collapseCardExample'+p[0].store_id" class="d-block card-header">
                                            <h6 class="m-0 font-weight-bold text-primary">{{p[0].store_name}}</h6>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="" :id="'collapseCardExample'+p[0].store_id">
                                            <div class="card-body">
                                                <!-- {{p}} -->
                                                Products: <br>
                                                <span v-for="product in p">
                                                    <div class="products products-table">
                                                        <div class="product">
                                                            <div class="product-img">
                                                                <img :src="'../assets/images/'+product.product_url">
                                                            </div>
                                                            <div class="product-content">
                                                                <h3>
                                                                    {{product.product_name}}
                                                                    <small>{{product.product_description}}</small>
                                                                </h3>
                                                                <p class="product-text price">SUBTOTAL: ₱{{product.subtotal}}</p>
                                                                <p class="product-text genre">PRICE: ₱{{product.product_price}}</p>
                                                                <p class="product-text genre">QTY: {{product.count}} pcs</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                <br>
                                                <a @click="selectPharmacy(p[0].store_id)" class="btn btn-sm btn-warning mt-4 mb-2" style="float: right; color: black !important;">Select this pharmacy</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>

                        <!-- Check Out Pharmacy -->
                        <span v-if="checkedPharmacy">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Collapsable Card Example -->
                                    <div class="card shadow mb-4">
                                        <!-- Card Header - Accordion -->
                                        <a class="d-block card-header">
                                            <h6 class="m-0 font-weight-bold text-primary">{{checkOutStoreName}}</h6>
                                        </a>
                                        <!-- Card Content - Collapse -->
                                        <div class="">
                                            <div class="card-body">
                                                <!-- {{p}} -->
                                                <form method="post" action="process_cart.php">
                                                    Products: <br>
                                                    <span v-for="product in productsInCart">
                                                        <div class="products products-table">
                                                            <div class="product">
                                                                <div class="product-img">
                                                                    <img :src="'../assets/images/'+product.product_url">
                                                                </div>
                                                                <div class="product-content">
                                                                    <label class="container">{{product.product_name}}
                                                                        <input type="checkbox" name="products[]" :value="product.cart_id">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <h3>
                                                                        <small>{{product.product_description}}</small>
                                                                    </h3>
                                                                    <p class="product-text price">SUBTOTAL: ₱{{product.subtotal}}</p>
                                                                    <p class="product-text genre">PRICE: ₱{{product.product_price}}</p>
                                                                    <p class="product-text genre">
                                                                        QTY: <a class="btn btn-sm btn-dark mr-1" @click="minusQuantity(product.cart_id)">-</a>
                                                                        <b> {{product.count}} </b>
                                                                        <a class="btn btn-sm btn-dark ml-1" @click="plusQuantity(product.cart_id)">+</a> pcs
                                                                    </p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <button type="submit" name="checkout" class="btn btn-sm btn-warning mt-4 mb-2" style="float: right; color: black !important;">Checkout</button>
                                                </form>
                                                <br>
                                                <!-- <a @click="checkout()" class="btn btn-sm btn-warning mt-4 mb-2" style="float: right; color: black !important;">Checkout</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>

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
                            //data model here
                            searchValue: null,
                            products: [],

                            showNotification: false,
                            messageNotification: "",

                            productsInCart: null,
                            checkedPharmacy: false,
                            checkedOut: false,
                            store_id: null,
                            checkOutStoreName: null,
                        }
                    },
                    methods: {

                        //Get Stores in Cart
                        async getStoreInCart() {
                            var userId = <?php echo $_SESSION['user_id']; ?>;
                            const options = {
                                method: "POST",
                                url: "process_cart.php?getStoreInCart",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    user_id: userId,
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.productsInCart = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Select Pharmacy
                        async selectPharmacy(store_id) {
                            var userId = <?php echo $_SESSION['user_id']; ?>;
                            this.store_id = store_id;
                            const options = {
                                method: "POST",
                                url: "process_cart.php?getSpecificPharmacyAndProduct",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    store_id: this.store_id,
                                    user_id: userId,
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    this.productsInCart = response.data;
                                    console.log(response);
                                    this.checkOutStoreName = response.data[0].store_name;
                                    this.checkedPharmacy = true;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        // Minus Quantity
                        async minusQuantity(cart_id) {
                            const options = {
                                method: "POST",
                                url: "process_cart.php?minusQuantity",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    cart_id: cart_id,
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.checkedPharmacy = true;
                                    this.showNotification = true;
                                    this.messageNotification = response.data.response;
                                    this.selectPharmacy(this.store_id);
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        // Plus Quantity
                        async plusQuantity(cart_id) {
                            const options = {
                                method: "POST",
                                url: "process_cart.php?plusQuantity",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    cart_id: cart_id,
                                },
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.showNotification = true;
                                    this.messageNotification = response.data.response;
                                    this.checkedPharmacy = true;
                                    this.selectPharmacy(this.store_id);
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                    },
                    async created() {
                        await this.getStoreInCart();
                    }
                });
            </script>
</body>

</html>