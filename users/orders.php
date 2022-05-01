<?php
require_once("process_index.php");
include("head.php");
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
                            <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a>
                            {{ messageNotification }}
                        </div>

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
                                                    <label class="h5 mt-3">{{orders[0].store_name}}</label>

                                                    <span v-if="orders[0].mode_of_payment === '0'" class="badge badge-warning badge-counter ml-4 mb-1">Cash on Delivery</span>
                                                    <span v-if="orders[0].mode_of_payment === '1'" class="badge badge-primary badge-counter ml-4 mb-1">Paid (PharmaPay) </span>

                                                    <label class="mt-3" style="float: right">Total: <b>₱{{orders[0].total_amount}}</b></label>
                                                </div>
                                                <span v-for="o in orders">
                                                    <div class="col-lg-12 card mb-2">
                                                        <div class="mt-1 mb-1">
                                                            <img :src="'../assets/images/'+o.product_url" width="100px" />
                                                            Name: <b>{{o.product_name}}</b>;
                                                            Qty: <b>{{o.count}}</b>
                                                            Subtotal: <b>₱{{o.subtotal}}</b><i style="font-size: 11px;"> (Without Delivery fee of ₱{{o.delivery_charge}})</i>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div>
                                                    <a :href="'transaction_chat.php?id='+orders[0].transaction_id" class="btn btn-sm btn-primary m-1" style="float: right;">Go to transaction thread</a>
                                                </div>
                                                <div class="mb-2">
                                                    <span v-if="orders[0].status === '0' " class="badge badge-warning m-1" style="float: left !important; color: black;">Status: Pending</span>
                                                    <span v-if="orders[0].status === '-1' " class="badge badge-info m-1" style="float: left !important;">Status: Awaiting Rider Pick Up</span>
                                                    <span v-if="orders[0].status === '-2' " class="badge badge-info m-1" style="float: left !important; color: black;">Status: On the Way (Picked Up) from your store.</span>
                                                </div>

                                                <!-- If Status is On the way for pick up -->
                                                <div class="mb-2" v-if="orders[0].status === '-2' ">
                                                    <button class="btn btn-sm btn-danger m-1" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">Receive</button>
                                                    <div class="dropdown-menu shadow-danger mb-1">
                                                        <span class="dropdown-item">Confirm Received Order? This cannot be undone.</span>
                                                        <a class="dropdown-item text-danger" href="#">Cancel</a>
                                                        <a @click="receiveOrder(orders[0].transactionId)" class="dropdown-item text-success">Confirm Received Order</a>
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
                                                    <label class="mt-3" style="float: right">Total: <b>₱{{orders[0].total_amount}}</b></label>
                                                </div>
                                                <span v-for="o in orders">
                                                    <div class="col-lg-12 card mb-2">
                                                        <div class="mt-1 mb-1">
                                                            <img :src="'../assets/images/'+o.product_url" width="100px" />
                                                            Name: <b>{{o.product_name}}</b>;
                                                            Qty: <b>{{o.count}}</b>
                                                            Subtotal: <b>₱{{o.subtotal}}</b><i style="font-size: 11px;"> (Without Delivery fee of ₱{{o.delivery_charge}})</i>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div class="mb-2">
                                                    <span v-if="orders[0].status === '0' " class="badge badge-warning m-1" style="float: left !important; color: black;">Status: Pending</span>
                                                    <span v-if="orders[0].status === '1' " class="badge badge-primary m-1" style="float: left !important;">Status: Completed</span>
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
                                                    <label class="h5 mt-3">{{orders[0].store_name}}</label>
                                                    <label class="mt-3" style="float: right">Total: <b>₱{{orders[0].total_amount}}</b></label>
                                                </div>
                                                <span v-for="o in orders">
                                                    <div class="col-lg-12 card mb-2">
                                                        <div class="mt-1 mb-1">
                                                            <img :src="'../assets/images/'+o.product_url" width="100px" />
                                                            Name: <b>{{o.product_name}}</b>;
                                                            Qty: <b>{{o.count}}</b>
                                                            Subtotal: <b>₱{{o.subtotal}}</b><i style="font-size: 11px;"> (Without Delivery fee of ₱{{o.delivery_charge}})</i>
                                                        </div>
                                                    </div>
                                                </span>
                                                <div class="mb-2">
                                                    <span v-if="orders[0].status === '-3' " class="badge badge-danger m-1" style="float: left !important;">Status: Cancelled</span>
                                                </div>
                                            </div>
                                        </span>

                                        <!-- Notification here -->
                                        <div v-if="cancelledOrders.length === 0" class="alert alert-success alert-dismissible">
                                            No current cancelled orders.
                                        </div>
                                        <!-- End Notification -->
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
                    }
                },
                methods: {
                    //Get Current Orders
                    async getCurrentOrder() {
                        const options = {
                            method: "POST",
                            url: "process_order.php?getProducts",
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
                            url: "process_order.php?completedOrders",
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

                    // Receive Order
                    async receiveOrder(transactionId) {
                        console.log(transactionId);
                        const options = {
                            method: "POST",
                            url: "process_order.php?receiveOrder",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                transaction_id: transactionId
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);

                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                    //Get Completed Orders
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

                },
                async mounted() {
                    this.getCurrentOrder();
                    this.getCompletedOrders();
                    this.getCancelledOrders();
                }
            });
        </script>
</body>

</html>