<?php
require_once("process_booking.php");
include("head.php");

$user_id = $_SESSION['user_id'];

?>
<title>PharmaClique - Doctor Bookings</title>

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
                        <!-- List of bookings -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">List of Bookings</h6>
                                    </a>
                                    <div class="card-body">
                                        <div class="row">
                                            <div v-if="bookings.length === 0" class="col-xl-12 alert alert-warning">
                                                No bookings found currently associated with your account.
                                            </div>
                                            <div v-else class="col-xl-12 col-md-6 mb-4" v-for="b in bookings">
                                                <div class="card shadow row no-gutters align-items-center p-4">
                                                    <div class="col mr-2">
                                                        <div class="text font-weight-bold text-primary mb-1">
                                                            <a :href="'booking.php?id='+b.booking_id">
                                                                Booking ID: 00000{{b.booking_id}}<br>
                                                                Doctor: {{b.firstname}} {{b.lastname}}
                                                            </a>
                                                        </div>
                                                        <div class="text font-weight-bold text-primary mb-1">
                                                            Date: {{b.booking_date}}<br>
                                                            Time: {{b.boking_date_time_from}} - {{b.boking_date_time_to}}
                                                        </div>
                                                        <div class="text-xs font-weight-bold text-primary mb-1">
                                                            <span v-if="b.booking_status === '0'" class="badge badge-warning badge-counter">Awaiting Doctor's Approval</span>
                                                            <span v-if="b.booking_status === '1'" class="badge badge-success badge-counter">Approved</span>
                                                            <div class="mb-2">
                                                                <!-- Cancel Booking -->
                                                                <button class="btn btn-sm btn-danger m-1" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">
                                                                    <i class="fas fa-ban"></i> Cancel Booking
                                                                </button>
                                                                <div class="dropdown-menu shadow-danger m-1">
                                                                    <span class="dropdown-item">Do you really wish to cancel this booking?</span>
                                                                    <a class="dropdown-item text-danger" href="#">Cancel</a>
                                                                    <a class="dropdown-item text-success" @click="cancelBooking(b.booking_id)">Confirm Cancellation</a>
                                                                </div>
                                                                <a class="btn btn-sm btn-info m-1" style="float: right;" :href="'booking.php?id='+b.booking_id">
                                                                    <i class="fas fa-arrow-right"></i> Go to Booking
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- List of cancelled bookings -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">List of Cancelled Bookings</h6>
                                    </a>
                                    <div class="card-body">
                                        <div class="row">
                                            <div v-if="cancelledBookings.length === 0" class="col-xl-12 alert alert-warning">
                                                No cancelled bookings found currently associated with your account.
                                            </div>
                                            <div v-else class="col-xl-12 col-md-6 mb-4" v-for="b in cancelledBookings">
                                                <div class="card shadow row no-gutters align-items-center p-4" style="background-color: rgb(156 156 159);">
                                                    <div class="col mr-2">
                                                        <div class="text font-weight-bold mb-1" style="color: black;">
                                                            Doctor: {{b.firstname}} {{b.lastname}}
                                                        </div>
                                                        <div class="text font-weight-bold mb-1" style="color: black;">
                                                            Date: {{b.booking_date}}
                                                        </div>
                                                        <div class="text font-weight-bold mb-1" style="color: black;">
                                                            Time: {{b.boking_date_time_from}} - {{b.boking_date_time_to}}
                                                        </div>
                                                    </div>
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
                        userId: <?php echo $user_id; ?>,

                        //Doctors
                        bookings: [],
                        cancelledBookings: [],

                        //UI
                        colorScheme: "success",
                    }
                },
                methods: {
                    //Get confirmed bookings
                    async getBookings() {
                        const options = {
                            method: "POST",
                            url: "process_booking.php?getBookings",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                user_id: this.userId
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.bookings = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                    //Cancel Booking
                    async cancelBooking(booking_id) {
                        const options = {
                            method: "POST",
                            url: "process_booking.php?cancelBooking",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                booking_id: booking_id
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.getCancelledbookings();
                                this.getBookings();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },
                    
                    //Get cancelled bookings
                    async getCancelledbookings() {
                        const options = {
                            method: "POST",
                            url: "process_booking.php?getCancelledbookings",
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                user_id: this.userId
                            }
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.cancelledBookings = response.data;
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },


                },
                async created() {
                    await this.getBookings();
                    await this.getCancelledbookings();
                },
            });
        </script>
</body>

</html>