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
<title>PharmaClique - Orders</title>
<style>
img{
    border-radius: 5px !important;
    filter: drop-shadow(1px 1px 1px #222);
    margin-right: 10px;
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
                            <!-- <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a> -->
                            {{ messageNotification }}
                        </div>
                        <!-- End Notification -->


                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h5 class="h5 mb-0 text-gray-800">Orders (Complete and Current)</h5>
                        </div>

                         <!-- Pending Orders -->
                         <div class="row">
                            <!-- Pending Orders -->
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Pending Orders</h6>
                                    </div>
                                    <div class="card-body">
                                        <span v-for="orders in currentOrders">
                                            <div class="col-lg-12 card shadow mb-4">
                                                <div>
                                                    <label class="h6 mt-3"><b>{{orders[0].firstname}} {{orders[0].lastname}}</b></label>
                                                    <!-- <label class="mt-3" style="float: right"><b>Total: </b>₱{{orders[0].total_amount}}</label> -->
                                                    <span v-if="orders[0].mode_of_payment === '0'" class="badge badge-warning badge-counter ml-4 mb-1">Cash on Delivery</span>
                                                    <span v-if="orders[0].mode_of_payment === '1'" class="badge badge-primary badge-counter ml-4 mb-1">Paid (PharmaPay) </span>
                                                    <label class="mt-3" style="float: right"><b>Total: </b>₱{{Number(orders[0].total_amount - orders[0].delivery_charge).toLocaleString() }}</label>
                                                    <label class="mt-3 mr-2" style="float: right !important;"><b>Order ID: </b> {{orders[0].transaction_id}}</label>
                                                </div>
                                                <span v-for="o in orders">
                                                    <div class="col-lg-12 card mb-2">
                                                        <div class="mt-1 mb-1">
                                                            <img :src="'../assets/images/'+o.product_url" width="100px" />
                                                            Name: <b>{{o.product_name}}</b>;
                                                            Qty: <b>{{o.count}}</b>
                                                            Subtotal:
                                                            <b v-if="o.is_pwd === '1'">₱{{o.subtotal * 0.8}}</b>
                                                            <b v-if="o.is_pwd === '0'">₱{{o.subtotal}}</b>

                                                            <i style="font-size: 10px;" v-if="o.is_pwd === '1'">with PWD Discount</i>
                                                            
                                                            <span v-if="o.product_type === '0'" class="badge badge-success badge-counter ml-4 mb-1">Prescription not needed</span>
                                                            <span v-if="o.product_type === '1'" class="badge badge-primary badge-counter ml-4 mb-1">Physical buying</span>
                                                            <span v-if="o.product_type === '2'" class="badge badge-secondary badge-counter ml-4 mb-1">Prescription needed</span>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div v-if="orders[0].status === '-1' " @click="getRiderInformation(orders[0].transaction_id)" class="alert alert-success alert-dismissible">
                                                    <span v-if="riderInformation.length >=1">
                                                        <b>Rider: </b>{{riderInformation[0].firstname}} {{riderInformation[0].lastname}}
                                                    </span>
                                                    <span v-if="riderInformation.length === 0">
                                                        No rider picked up the order yet. Click to update / check the status.
                                                    </span>
                                                </div>
                                                <!-- If not accepted order -->
                                                <div class="mb-2" v-if="orders[0].status != '-1' ">
                                                    <span v-if="orders[0].status === '0' " class="badge badge-warning m-1" style="float: left !important; color: black;">Status: Awaiting for your confirmation</span>
                                                    <span v-if="orders[0].status === '-1' " class="badge badge-success m-1" style="float: left !important;">Status: Waiting Rider for pickup</span>
                                                    
                                                    <button @click="confirmOrder(orders[0].transaction_id, orders[0].amount_paid, orders[0].delivery_charge, orders[0].mode_of_payment)" class="btn btn-sm btn-success m-1" style="float: right;">Accept Order</button>

                                                    <button class="btn btn-sm btn-danger m-1" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">Reject Order</button>
                                                    <div class="dropdown-menu shadow-danger mb-1">
                                                        <span class="dropdown-item">Confirm Rejection? This cannot be undone.</span>
                                                        <a class="dropdown-item text-success" href="#">Cancel</a>
                                                        <a @click="cancelOrder(orders[0].transaction_id)" class="dropdown-item text-danger">Confirm Rejection</a>
                                                    </div>

                                                    <a :href="'transaction_chat.php?id='+orders[0].transaction_id" class="btn btn-sm btn-primary m-1 mr-4" style="float: right;">Go to transaction thread</a>

                                                </div>
                                                <!-- If accepted order -->
                                                <div class="mb-2" v-if="orders[0].status === '-1' ">
                                                    <span v-if="orders[0].status === '0' " class="badge badge-warning m-1" style="float: left !important; color: black;">Status: Awaiting for your confirmation</span>
                                                    <span v-if="orders[0].status === '-1' " class="badge badge-success m-1" style="float: left !important;">Status: Waiting Rider for pickup</span>

                                                    <button @click="pickedUpOrder(orders[0].transaction_id)" class="btn btn-sm btn-success m-1" style="float: right;">Pick Up</button>

                                                    <button class="btn btn-sm btn-danger m-1" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;" disabled>Cancel Order</button>
                                                    <div class="dropdown-menu shadow-danger mb-1">
                                                        <span class="dropdown-item">Confirm Rejection? This cannot be undone.</span>
                                                        <a class="dropdown-item text-success" href="#">Cancel</a>
                                                        <a @click="cancelOrder(orders[0].transaction_id)" class="dropdown-item text-danger">Confirm Rejection</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                        <!-- Notification here -->
                                        <div v-if="currentOrders.length === 0" class="alert alert-success alert-dismissible">
                                            No current pending orders.
                                        </div>
                                        <!-- End Notification -->

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Completed Orders -->
                        <div class="row">
                            <!-- Compelted Orders -->
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Completed Orders</h6>
                                    </div>
                                    <div class="card-body">
                                        <span v-for="orders in completedOrders">
                                            <div class="col-lg-12 card shadow mb-4">
                                                <div>
                                                    <label class="h5 mt-3">{{orders[0].store_name}}</label>
                                                    <!-- <label class="mt-3" style="float: right">Total: <b>₱{{orders[0].total_amount}}</b></label> -->
                                                    <label class="mt-3" style="float: right"><b>Total: </b>₱{{Number(orders[0].total_amount - orders[0].delivery_charge).toLocaleString() }}</label>                                                    
                                                    <label class="mt-3 mr-2" style="float: right !important;"><b>Order ID: </b> {{orders[0].transaction_id}}</label>
                                                </div>
                                                <span v-for="o in orders">
                                                    <div class="col-lg-12 card mb-2">
                                                        <div class="mt-1 mb-1">
                                                            <img :src="'../assets/images/'+o.product_url" width="100px" />
                                                            Name: <b>{{o.product_name}}</b>;
                                                            Qty: <b>{{o.count}}</b>
                                                            Subtotal:
                                                            <b v-if="o.is_pwd === '1'">₱{{o.subtotal * 0.8}}</b>
                                                            <b v-if="o.is_pwd === '0'">₱{{o.subtotal}}</b>
                                                            
                                                            <i style="font-size: 10px;" v-if="o.is_pwd === '1'">with PWD Discount</i>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div class="mb-2">
                                                    <span v-if="orders[0].status === '0' " class="badge badge-warning m-1" style="float: left !important; color: black;">Status: Awaiting for your confirmation</span>
                                                    <span v-if="orders[0].status === '1' " class="badge badge-primary m-1" style="float: left !important;">Status: Completed</span>
                                                    <span v-if="orders[0].status === '-2' " class="badge badge-info m-1" style="float: left !important; color: black;">Status: On the way to customer.</span>
                                                </div>
                                            </div>
                                        </span>
                                        <!-- Notification here -->
                                        <div v-if="completedOrders.length === 0" class="alert alert-success alert-dismissible">
                                            No current completed orders.
                                        </div>
                                        <!-- End Notification -->
                                    </div>
                                </div>
                            </div>
                        </div>

                      <!-- Cancelled Orders -->
                      <div class="row">
                            <!-- Cancelled Orders -->
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Cancelled Orders</h6>
                                    </div>
                                    <div class="card-body">
                                        <span v-for="orders in cancelledOrders">
                                            <div class="col-lg-12 card shadow mb-4">
                                                <div>
                                                    <label class="h6 mt-3"><b>{{orders[0].firstname}} {{orders[0].lastname}}</b></label>
                                                    <!-- <label class="mt-3" style="float: right">Total: <b>₱{{ orders[0].total_amount - orders[0].delivery_charge }}</b></label> -->
                                                    <label class="mt-3" style="float: right">Total: <b>₱{{ Number(orders[0].total_amount - orders[0].delivery_charge).toLocaleString() }}</b></label>
                                                    <label class="mt-3 mr-2" style="float: right !important;"><b>Order ID: </b> {{orders[0].transaction_id}}</label>
                                                </div>
                                                <span v-for="o in orders">
                                                    <div class="col-lg-12 card mb-2">
                                                        <div class="mt-1 mb-1">
                                                            <img :src="'../assets/images/'+o.product_url" width="100px" />
                                                            Name: <b>{{o.product_name}}</b>;
                                                            Qty: <b>{{o.count}}</b>
                                                            Subtotal:

                                                            <b v-if="o.is_pwd === '1'">₱{{o.subtotal * 0.8}}</b>
                                                            <b v-if="o.is_pwd === '0'">₱{{o.subtotal}}</b>
                                                            
                                                            <i style="font-size: 10px;" v-if="o.is_pwd === '1'">with PWD Discount</i>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div class="mb-2">
                                                    <span v-if="orders[0].status === '1' " class="badge badge-primary m-1" style="float: left !important;">Status: Completed</span>
                                                    <span v-if="orders[0].status === '0' " class="badge badge-warning m-1" style="float: left !important; color: black;">Status: Awaiting for your confirmation</span>
                                                </div>
                                            </div>
                                        </span>
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
                            showNotification: false,
                            messageNotification: "",
                            currentOrders: [],
                            completedOrders: [],
                            cancelledOrders: [],
                            user_id: <?php echo $_SESSION['user_id']; ?>,

                            //Riders
                            riderInformation: [],
                        }
                    },
                    methods: {
                        //Get Current Orders
                        async getCurrentOrders() {
                            const options = {
                                method: "POST",
                                url: "process_order.php?getCurrentOrders",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    user_id: this.user_id
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.currentOrders = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Get Completed Orders
                        async getCompletedOrders() {
                            const options = {
                                method: "POST",
                                url: "process_order.php?getCompletedProducts",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    user_id: this.user_id
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.completedOrders = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },


                        //Get Cancelled Orders
                        async getCancelledOrders() {
                            const options = {
                                method: "POST",
                                url: "process_order.php?getCancelledOrders",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    user_id: this.user_id
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.cancelledOrders = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Get Completed Orders
                        async cancelOrder(order_id) {
                            const options = {
                                method: "POST",
                                url: "process_order.php?cancelOrder",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    transaction_id: order_id
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.getCurrentOrders();
                                    this.getCancelledOrders();
                                    this.showNotification = true;
                                    this.messageNotification = "Order has been rejected.";
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Confirm Order
                        async confirmOrder(order_id, amount_paid, delivery_charge, modeOfPayment) {
                            let pharmacyAmountPaid = amount_paid - delivery_charge;
                            
                            const options = {
                                method: "POST",
                                url: "process_order.php?confirmOrder",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    transaction_id: order_id,
                                    pharmacy_amount_paid: pharmacyAmountPaid,
                                    mode_of_payment: modeOfPayment
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.getCurrentOrders();
                                    this.getCompletedOrders();
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },

                        //Picked Up by Rider
                        async pickedUpOrder(order_id){
                            const options = {
                                method: "POST",
                                url: "process_order.php?pickedUpOrder",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    transaction_id: order_id
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.getCurrentOrders();
                                    this.getCompletedOrders();
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        },
                        
                        // Get Rider Information
                        async getRiderInformation(order_id){
                            const options = {
                                method: "POST",
                                url: "process_order.php?getRiderInformation",
                                headers: {
                                    Accept: "application/json",
                                },
                                data: {
                                    transaction_id: order_id
                                }
                            };
                            await axios
                                .request(options)
                                .then((response) => {
                                    console.log(response);
                                    this.riderInformation = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        }

                    },
                    async mounted() {
                        this.getCurrentOrders();
                        this.getCompletedOrders();
                        this.getCancelledOrders();
                    }
                });
            </script>
</body>

</html>