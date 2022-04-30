<?php
require_once("process_transaction.php");
include("head.php");

$user_id = $_SESSION['user_id'];
$transaction_id = 0;
if (isset($_GET["id"])) {
    $transaction_id = $_GET["id"];
    $getTransactionInformation = $mysqli->query("SELECT * FROM transaction t
    JOIN pharmacy_store p
    ON p.id = t.pharmacy_id
    JOIN users u
    ON u.id = p.user_id
    WHERE t.id = '$transaction_id' ") or die($mysqli->error);
    $transactionInfo = $getTransactionInformation->fetch_array();
} else {
    header("location: orders.php");
}

?>
<title>PharmaClique - Transaction</title>

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
                        <!-- End Notification -->


                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
                        </div>

                        <!-- Chat Thread with the Doctor -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Chat Thread with <?php echo $transactionInfo["store_name"]; ?></h6>
                                    </a>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 mb-4">
                                                <div class="card shadow row no-gutters align-items-center p-4">
                                                    <div class="col mr-2">
                                                        <div v-for="c in chats">

                                                            <div v-if="c.user === 'pharmacy' " class="containerChat">
                                                                <label class="text-xs font-weight-bold text-uppercase"><?php echo $transactionInfo["store_name"]; ?></h6></label>
                                                                <p>{{c.user_message}}</p>
                                                                <span class="text-xs">{{c.updated_at}}</span>
                                                            </div>

                                                            <div v-if="c.user === 'customer' " class="containerChat darker">
                                                                <label class="text-xs font-weight-bold text-uppercase float-right">You</label><br>
                                                                <label class="float-right">{{c.user_message}}</label><br><br>
                                                                <span class="text-xs float-right">{{c.updated_at}}</span>
                                                            </div>

                                                        </div>

                                                        <div class="text-xs font-weight-bold text-primary mb-1">
                                                            <form @submit.prevent="sendMessage()">
                                                                <div class="mb-2">
                                                                    <textarea v-model="chatMessage" class="form-control" placeholder="Send message to pharmacist." style="min-height: 100px;" required></textarea>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <button class="btn btn-sm btn-info m-1" style="float: right;">
                                                                        <i class="fas fa-paper-plane"></i> Send Message
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Receipt from the user -->
                        <div class="row">
                            <!-- show receipt -->
                            <div class="col-lg-12">
                                <!-- upload prescription -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Prescription (Upload / View Display Picture)</h6>
                                    </a>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 mb-4">
                                                <form @submit.prevent="uploadPrescriptionPicture()">
                                                    <div class="card shadow row no-gutters align-items-center p-4">
                                                        <div class="col mr-2">
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mb-4">
                                                                <input class="form-control" type="file" id="picture" ref="picture" accept=".jpg,.png,.jpeg" required>
                                                            </div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                                                <img :src="'../img/'+transaction.prescription_url" style="max-height:100%; min-width: 80%; max-width: 80%; border-radius: 10px;">
                                                            </div>
                                                            <div class="text-xs font-weight-bold text-primary mb-1">
                                                                <div class="mb-2">
                                                                    <button type="submit" class="btn btn-sm btn-primary m-1" style="float: right;" :disabled="isUploading"><i class="far fa-save"></i> {{uploadingMessage}}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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

        <script>
            $(document).ready(function() {
                $('#bookingsTable').DataTable({});
            });
            new Vue({
                el: "#vueApp",
                data() {
                    return {
                        showNotification: false,
                        messageNotification: null,
                        editUserProfile: false,
                        isUploading: false,
                        uploadingMessage: "Upload Prescription Picture",
                        userId: <?php echo $user_id; ?>,
                        transaction_id: <?php echo $transaction_id; ?>,
                        transaction: {
                            prescription_url: "receipt.png",
                        },
                        chatMessage: null,
                        chats: null,
                        //UI
                        colorScheme: "success",
                    }
                },
                methods: {
                    // Get Booking Information
                    async getTransactionInformation() {
                        const options = {
                            method: "POST",
                            url: "process_transaction.php?getTransactionInformation",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                transaction_id: this.transaction_id
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.transaction = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                    // Upload Display Picture
                    async uploadPrescriptionPicture() {
                        this.isUploading = true;
                        this.uploadingMessage = "Uploading...";
                        var pictureFile = document.querySelector("#picture");
                        console.log(pictureFile.files[0]);
                        const form = new FormData();
                        form.append("picture", pictureFile.files[0]);

                        const options = {
                            method: "POST",
                            url: "process_transaction.php?uploadPrescriptionPicture=" + <?php echo $transaction_id; ?>,
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                            data: form
                        };

                        await axios.request(options).then((response) => {
                            this.showNotification = true;
                            this.messageNotification = "Uploading Prescription Succesful!";
                            this.isUploading = false;
                            this.uploadingMessage = "Upload Prescription Picture";
                            console.log(response);
                        }).catch((error) => {
                            this.showNotification = true;
                            this.messageNotification = "There is an error processing your request.";
                            console.error(error);
                        });
                        this.getTransactionInformation();
                    },

                    // Get Chats
                    async getChats() {
                        const options = {
                            method: "POST",
                            url: "process_transaction.php?getChats",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                transaction_id: this.transaction_id
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.chats = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                    // Send message
                    async sendMessage() {
                        const options = {
                            method: "POST",
                            url: "process_transaction.php?sendMessage",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                chat_message: this.chatMessage,
                                transaction_id: this.transaction_id,
                                user_id: this.userId
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.chatMessage = null;
                                this.getChats();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }

                },
                async created() {
                    this.getChats();
                    this.getTransactionInformation();
                },
            });
        </script>
</body>

</html>