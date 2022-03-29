<?php
require_once("process_booking.php");
include("head.php");

$user_id = $_SESSION['user_id'];

$checkUser = $mysqli->query("SELECT * FROM doctor_profile WHERE doctor_id='$user_id' ");
$userExist = false;
$profile_id = 0;
if (mysqli_num_rows($checkUser) > 0) {
    $userExist = true;
    $user = $checkUser->fetch_array();
    $profile_id = $user['id'];
    $hourly_rate = $user['hourly_rate'];
    $profile_url = $user['profile_image'];
    $specialization = $user['specialization'];
}
$checkUser = $mysqli->query("SELECT * FROM users WHERE id='$user_id' ");
$user = $checkUser->fetch_array();
$first_name = $user["firstname"];
$last_name = $user["lastname"];
$email = $user["email"];
$phone_number = $user["phone_number"];
?>
<title>PharmaClique - Doctor Booking</title>

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
                            <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">List of Doctors</h6>
                                    </a>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-10 mb-4">
                                            <form @submit.prevent="searchDoctors()">
                                                <input class="form-control" type="text" id="search" style="width: 100% ;" placeholder="Search by Specialization" v-model="searchVal"/>
                                            </div>
                                            <div class="col-lg-2 mb-4">
                                                <button id="searchbutton" class="btn btn-success" style="width: 100% ;" type="submit" @click="searchDoctors()">Search</button>
                                                </form>
                                            </div>

                                            <div v-if="doctors.length === 0" class="col-xl-12 alert alert-warning">
                                                No doctors found in that specialization
                                            </div>
                                            <div v-else class="col-xl-6 col-md-6 mb-4" v-for="d in doctors">
                                                <div class="card shadow row no-gutters align-items-center p-4">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            {{d.specialization}}
                                                        </div>
                                                        <div class="mb-0 font-weight-bold text-gray-800">
                                                            Name: {{d.firstname}} {{d.lastname}}<br>
                                                            Hourly Rate: ₱{{d.hourly_rate}}
                                                            <img :src="'../img/'+d.profile_image" style="max-height:100%; max-width: 100%;">
                                                            <button type="submit" style="float: right;" class="btn btn-primary btn-sm m-1" name="save_doctror_profile">Book</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-12 mb-4 mt-4">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display: <?php if (!$userExist) {
                                                                echo "none";
                                                            } ?>">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                                    </a>
                                    <div class="collapse show" id="collapseStore">
                                        <div class="card-body">
                                            <form method="post" @submit.prevent="uploadProfilePicture()">
                                                <div class="row">
                                                    <!-- Profle Picture -->
                                                    <div class="col-xl-6 col-md-12 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Upload Display Picture
                                                                </div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input class="form-control" type="file" id="picture" ref="picture" accept=".jpg,.png,.jpeg" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-md-12 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Display Picture</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <img src="../img/<?php echo $profile_url; ?>" style="max-height:100%; max-width: 100%;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-md-12 mb-4 mt-4">
                                                        <button type="submit" style="float: right;" class="btn btn-info btn-sm m-1" :disabled="isUploading">
                                                            <i class="far fa-save"></i> {{uploadingMessage}}
                                                        </button>
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
                        showNotification: false,
                        messageNotification: null,
                        editUserProfile: false,

                        //Doctors
                        doctors: [],
                        searchVal: null,
                        isUploading: false,
                        uploadingMessage: "Upload Profile Picture"
                    }
                },
                methods: {
                    //Get Doctors on load
                    async getDoctors() {
                        const options = {
                            method: "POST",
                            url: "process_booking.php?getDoctors",
                            headers: {
                                Accept: "application/json",
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.doctors = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                    //Search Doctors
                    async searchDoctors() {
                        const options = {
                            method: "POST",
                            url: "process_booking.php?searchDoctors="+this.searchVal,
                            headers: {
                                Accept: "application/json",
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.doctors = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
                async created() {
                    await this.getDoctors();
                },
            });
        </script>
</body>

</html>