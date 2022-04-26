<?php
require_once("process_profile.php");
include("head.php");

$user_id = $_SESSION['user_id'];

$checkUser = $mysqli->query("SELECT * FROM users WHERE id='$user_id' ");
$userExist = false;
$profile_id = 0;
if (mysqli_num_rows($checkUser) > 0) {
    $userExist = true;
    $user = $checkUser->fetch_array();
    $profile_id = $user['id'];
}

// PWD Check if exist
$id_url = 'pwd-id.jpg';
$pwdExist = false;
$checkPwd = $mysqli->query("SELECT * FROM pwd WHERE user_id='$user_id' ");
if (mysqli_num_rows($checkPwd) > 0) {
    $pwdExist = true;
    $pwd = $checkPwd->fetch_array();
    $id_url = $pwd['id_url'];
}
$checkUser = $mysqli->query("SELECT * FROM users WHERE id='$user_id' ");
$user = $checkUser->fetch_array();
$first_name = $user["firstname"];
$last_name = $user["lastname"];
$email = $user["email"];
$phone_number = $user["phone_number"];
?>
<title>PharmaClique - user Cashin</title>

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
                            <h1 class="h3 mb-0 text-gray-800">Cashin</h1>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12 h5">
                                Balance: ₱ <?php echo number_format($user["balance"], 2); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Cash in</h6>
                                    </a>
                                    <div class="collapse show" id="collapseStore">
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Profle Picture -->
                                                <div class="col-xl-12 col-md-12 mb-4">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Enter Amount
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                <input class="form-control" type="number" id="amount" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-md-12 mb-4">
                                                    <button id="btnSubmit" class="btn btn-primary" style="float: right;">Cash in using Paypal</button>
                                                </div>
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

        <!-- JS here for paypal -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>
        <script type="module">
            import {
                accessToken
            } from "./paypal/environment.js";
            import {
                order
            } from "./paypal/paypal.js"


            document.addEventListener("DOMContentLoaded", function() {
                axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`;
            });

            window.document.getElementById('btnSubmit').onclick = function() {
                const amount = window.document.getElementById('amount').value;
                window.localStorage.setItem("cashInAmount", amount);
                let account_id = <?php echo $user_id; ?>;
                window.localStorage.setItem("account_id", account_id);
                order(amount);
            }
        </script>
        <!-- JS here for paypal -->

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
                                showNotification: false,
                                editUserProfile: false,
                                messageNotification: null,
                                isUploading: false,
                                uploadingMessage: "Upload Profile Picture"
                            }
                        },
                        methods: {
                            async uploadProfilePicture() {
                                this.isUploading = true;
                                this.uploadingMessage = "Uploading...";
                                var pictureFile = document.querySelector("#picture");
                                console.log(pictureFile.files[0]);
                                const form = new FormData();
                                form.append("picture", pictureFile.files[0]);

                                const options = {
                                    method: "POST",
                                    url: "process_profile.php?uploadProfilePicture=" + <?php echo $user_id; ?>,
                                    headers: {
                                        "Content-Type": "multipart/form-data",
                                    },
                                    data: form
                                };

                                await axios.request(options).then((response) => {
                                    this.showNotification = true;
                                    this.messageNotification = "ID PWD ID update successful!";
                                    this.isUploading = false;
                                    this.uploadingMessage = "Upload ID Picture";
                                    console.log(response);
                                }).catch((error) => {
                                    this.showNotification = true;
                                    this.messageNotification = "There is an error processing your request.";
                                    console.error(error);
                                });
                            },

                            async getPaypalToken() {

                            }
                        },
                            async created() {
                                // await this.getPaypalToken();
                            },
                        });
        </script>
</body>

</html>