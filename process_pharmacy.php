<?php   
    include("dbh.php");

    //Save Storename
    if(isset($_POST['save_storename'])){
        $store_name = $mysqli -> real_escape_string($_POST['store_name']);
        $description = $mysqli -> real_escape_string($_POST['description']);
        $address = $mysqli -> real_escape_string($_POST['address']);
        $user_id = $_SESSION['user_id'];

        $mysqli->query(" INSERT INTO pharmacy_store (user_id, store_name, description, address) VALUES('$user_id', '$store_name','$description', '$address') ") or die ($mysqli->error);

        $_SESSION['pharmacyError'] = "Store has been created!";
        $_SESSION['msg_type'] = "success";
        header("location: pharmacy.php");
    }

    //Update Storename
    if(isset($_POST['update_storename'])){
        $store_name = $mysqli -> real_escape_string($_POST['store_name']);
        $description = $mysqli -> real_escape_string($_POST['description']);
        $address = $mysqli -> real_escape_string($_POST['address']);
        $store_id = $mysqli -> real_escape_string($_POST['store_id']);

        $mysqli->query(" UPDATE pharmacy_store SET store_name = '$store_name', description = '$description', address = '$address' WHERE id = '$store_id' " ) or die ($mysqli->error);

        $_SESSION['pharmacyError'] = "Store has been updated!";
        $_SESSION['msg_type'] = "info";
        header("location: pharmacy.php");
    }
?>