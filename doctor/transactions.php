<?php
require_once("../process_users.php");
include("head.php");

//Get current URI
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$session_user_id = $_SESSION['user_id'];

//transactions
$transactions = mysqli_query($mysqli, "SELECT * FROM rider_transaction rt
JOIN transaction t
ON t.id = rt.transaction_id
JOIN pharmacy_store ps
ON t.pharmacy_id = ps.id
JOIN users u
ON u.id = t.user_id
WHERE rt.rider_id = '$session_user_id'
");
?>

<title>PharmaClique - Transactions</title>

<head>
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

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

                    <!-- Notification here -->
                    <?php
                    if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    <?php } ?>
                    <!-- End Notification -->

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Transactions</h1>
                    <p class="mb-4"></p>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of transactions</h6>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                <table class="table table-bordered" id="transactionTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Pharmacy Store</th>
                                            <th>Products</th>
                                            <th>Amount Total</th>
                                            <th>Date of Purchase</th>
                                            <th>Ride Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Pharmacy Store</th>
                                            <th>Products</th>
                                            <th>Amount Total</th>
                                            <th>Date of Purchase</th>
                                            <th>Ride Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php while($transaction = mysqli_fetch_array($transactions)){ ?>
                                        <tr>
                                            <td><?php echo $transaction["firstname"]." ".$transaction["lastname"]; ?></td>
                                            <td><?php echo $transaction["store_name"]; ?></td>
                                            <td>
                                            <?php
                                                $counter = 1;
                                                $transaction_id = $transaction["transaction_id"];
                                                $products = mysqli_query($mysqli, "SELECT * FROM cart c
                                                JOIN pharmacy_products pp
                                                ON pp.id = c.product_id
                                                WHERE c.transaction_id = '$transaction_id' ");
                                                
                                                while($product = mysqli_fetch_array($products)){
                                                    echo $counter.". ".$product["product_name"]."<br>";
                                                    $counter++;
                                                }
                                                
                                            ?>
                                            </td>
                                            <td>₱<?php echo $transaction["total_amount"]; ?></td>
                                            <td><?php echo $transaction["transaction_date"]; ?></td>
                                            <td>
                                                <?php if($transaction["status"] == '1'){ ?>
                                                    <span class="badge badge-primary">Completed Order</span>
                                                <?php } ?>
                                                <?php if($transaction["status"] == '0'){ ?>
                                                    <span class="badge badge-secondary">Placed Order</span>
                                                <?php } ?>
                                                <?php if($transaction["status"] == '-1'){ ?>
                                                    <span class="badge badge-success">Awaiting Rider Pickup</span>
                                                <?php } ?>    
                                                <?php if($transaction["status"] == '-2'){ ?>
                                                    <span class="badge badge-warning" style="color: black;">On the Way (Picked Up)</span>
                                                <?php } ?>                                                    
                                                <?php if($transaction["status"] == '-3'){ ?>
                                                    <span class="badge badge-danger">Cancelled</span>
                                                <?php } ?>                                                

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include("footer.php"); ?>

            <!-- Bootstrap core JavaScript-->
            <script src="../vendor/jquery/jquery.min.js">
            </script>
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
                    $('#transactionTable').DataTable({
                    });
                });
            </script>
            <!-- End scripts here -->
</body>

</html>