<?php
require_once("process_pharmacy.php");
include("head.php");

$user_id = $_SESSION['user_id'];
$checkStore = $mysqli->query("SELECT * FROM pharmacy_store WHERE user_id='$user_id' ");
$storeExist = false;
if (mysqli_num_rows($checkStore) > 0) {
    $storeExist = true;
    $store = $checkStore->fetch_array();
}
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
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Pharmacy</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        <h6 class="m-0 font-weight-bold text-primary">Storename</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <!-- <div class="collapse show" id="collapseCardExample"> -->
                                    <div class="collapse <?php if (!$storeExist) { echo "show"; } ?>" id="collapseCardExample">
                                        <div class="card-body">
                                            <form method="post" action="process_pharmacy.php">
                                                <div class="row">
                                                    <!-- Store Name -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Store Name</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editStoreName" type="text" class="form-control" name="store_name" value="<?php if ($storeExist) {echo $store['store_name'];} ?>" required>
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
                                                                    <textarea :disabled="!editStoreName" class="form-control" name="address"><?php if ($storeExist) { echo $store['address']; } ?></textarea>
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
                                                                    <textarea :disabled="!editStoreName" class="form-control" name="description"><?php if ($storeExist) { echo $store['description']; } ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-md-12 mb-4" style="">
                                                        <?php if (!$storeExist) { ?>
                                                            <button type="submit" style="float: right;" class="btn btn-primary btn-sm" name="save_storename">
                                                                <i class="far fa-save"></i> Save Store Information
                                                            </button>
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

                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Default Card Example -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Default Card Example
                                    </div>
                                    <div class="card-body">
                                        This card uses Bootstrap's default styling with no utility classes added. Global
                                        styles are the only things modifying the look and feel of this default card example.
                                    </div>
                                </div>

                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
                                    </div>
                                    <div class="card-body">
                                        The styling for this basic card example is created by using default Bootstrap
                                        utility classes. By using utility classes, the style of the card component can be
                                        easily modified with no need for any custom CSS!
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <!-- Dropdown Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Dropdown Card Example</h6>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Dropdown Header:</div>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        Dropdown menus can be placed in the card header in order to extend the functionality
                                        of a basic card. In this dropdown card example, the Font Awesome vertical ellipsis
                                        icon in the card header can be clicked on in order to toggle a dropdown menu.
                                    </div>
                                </div>

                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExample">
                                        <div class="card-body">
                                            This is a collapsable card example using Bootstrap's built in collapse
                                            functionality. <strong>Click on the card header</strong> to see the card body
                                            collapse and expand!
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
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>
            <script>
                new Vue({
                    el: "#vueApp",
                    data() {
                        return {
                            editStoreName: false,
                        }
                    },
                    methods: {

                    },
                    mounted() {
                        console.log('vue sample here!');
                    }
                });
            </script>
</body>

</html>