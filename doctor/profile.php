<?php
require_once("process_profile.php");
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
<title>PharmaClique - Doctor Profile</title>

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
                            <h1 class="h3 mb-0 text-gray-800">Profile Settings</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Update Profile Information</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <!-- <div class="collapse show" id="collapseCardExample"> -->
                                    <!-- <div class="collapse <?php //if (!$storeExist) { echo "show"; } 
                                                                ?>" id="collapseStore"> -->
                                    <div class="collapse show" id="collapseStore">
                                        <div class="card-body">
                                            <form method="post" action="process_profile.php">
                                                <div class="row">
                                                    <!-- First Name -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    First Name</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editUserProfile" type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Last Name -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Last Name</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editUserProfile" type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Email Address -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Email Address</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editUserProfile" type="text" class="form-control" name="email" value="<?php echo $email; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Phone Number -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Phone Number</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editUserProfile" type="text" class="form-control" name="phone_number" value="<?php echo $phone_number; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Hourly Rate -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Hourly Rate in Peso (₱)</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editUserProfile" type="number" class="form-control" name="hourly_rate" value="<?php if($userExist){echo $hourly_rate; } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Specialization -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Specialization</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editUserProfile" type="text" class="form-control" name="specialization" value="<?php if($userExist){echo $specialization; } ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-md-12 mb-4 mt-4">
                                                        <?php if (!$userExist) { ?>
                                                            <input type="text" name="user_id" value="<?php echo $user_id; ?>" style="visibility: hidden;">
                                                            <button type="submit" style="float: right;" class="btn btn-primary btn-sm m-1" :disabled="!editUserProfile" name="save_doctror_profile">
                                                                <i class="far fa-save"></i> Save Doctor Profile
                                                            </button>
                                                            <a v-if="!editUserProfile" style="float: right;" class="btn btn-success btn-sm m-1" @click="editUserProfile = true">
                                                                <i class="far fa-edit"></i> Edit
                                                            </a>
                                                            <a v-else style="float: right;" class="btn btn-warning btn-sm m-1" @click="editUserProfile = false">
                                                                <i class="far fa-window-close"></i> Cancel
                                                            </a>
                                                        <?php } else { ?>
                                                            <input type="text" name="user_id" value="<?php echo $user_id; ?>" style="visibility: hidden;">
                                                            <input type="text" name="profile_id" value="<?php echo $profile_id; ?>" style="visibility: hidden;">
                                                            <button type="submit" style="float: right;" class="btn btn-info btn-sm m-1" name="update_doctror_profile" :disabled="!editUserProfile">
                                                                <i class="far fa-save"></i> Update Doctor Profile
                                                            </button>
                                                            <a v-if="!editUserProfile" style="float: right;" class="btn btn-success btn-sm m-1" @click="editUserProfile = true">
                                                                <i class="far fa-edit"></i> Edit
                                                            </a>
                                                            <a v-else style="float: right;" class="btn btn-warning btn-sm m-1" @click="editUserProfile = false">
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

                        <div class="row" style="display: <?php if(!$userExist){ echo "none"; } ?>">
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
                                                                    <img src="../img/<?php echo $profile_url; ?>" style="max-height:100%; max-width: 100%; border-radius: 10px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-md-12 mb-4 mt-4">
                                                            <button type="submit" style="float: right;" class="btn btn-info btn-sm m-1" :disabled="isUploading" >
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
                        editUserProfile: false,
                        messageNotification: null,
                        isUploading: false,
                        uploadingMessage: "Upload Profile Picture"
                    }
                },
                methods: {
                    async uploadProfilePicture(){
                        this.isUploading = true;
                        this.uploadingMessage = "Uploading...";
                        var pictureFile = document.querySelector("#picture");
                        console.log(pictureFile.files[0]);
                        const form = new FormData();
                        form.append("picture", pictureFile.files[0]);

                        const options = {
                            method: "POST",
                            url: "process_profile.php?uploadProfilePicture=" + <?php echo $profile_id; ?>,
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                            data: form
                        };

                        await axios.request(options).then((response) => {
                            this.showNotification = true;
                            this.messageNotification = "Profile update successful!";
                            this.isUploading = false;
                        this.uploadingMessage = "Upload Profile Picture";
                            console.log(response);
                        }).catch((error) => {
                            this.showNotification = true;
                            this.messageNotification = "There is an error processing your request.";
                            console.error(error);
                        });
                    },

                },
                async created() {},
            });
        </script>
</body>

</html>