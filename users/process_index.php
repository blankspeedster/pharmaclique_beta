<?php
    include("dbh.php");

    //Get Pharmacy
    if(isset($_GET["getPharmacy"])){
        $getPharmacys= mysqli_query($mysqli, "SELECT * FROM pharmacy_store");
        $pharmacys = array();
        while ($pharmacy = mysqli_fetch_assoc($getPharmacys)) {
            $pharmacys[] = $pharmacy;
        }
        echo json_encode($pharmacys);
    }
?>