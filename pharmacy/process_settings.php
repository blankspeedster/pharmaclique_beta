<?php
include("dbh.php");

//Save Storename
if (isset($_POST['save_storename'])) {
    $store_name = $mysqli->real_escape_string($_POST['store_name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $latitude = $mysqli->real_escape_string($_POST['latitude']);
    $longitude = $mysqli->real_escape_string($_POST['longitude']);

    $user_id = $_SESSION['user_id'];

    $mysqli->query(" INSERT INTO pharmacy_store (user_id, store_name, description, address, latitude, longitude) VALUES('$user_id', '$store_name','$description', '$address', '$latitude', '$longitude') ") or die($mysqli->error);

    $_SESSION['pharmacyError'] = "Store has been created!";
    $_SESSION['msg_type'] = "success";
    header("location: pharmacy_settings.php");
}

//Update Storename
if (isset($_POST['update_storename'])) {
    $store_name = $mysqli->real_escape_string($_POST['store_name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $latitude = $mysqli->real_escape_string($_POST['latitude']);
    $longitude = $mysqli->real_escape_string($_POST['longitude']);
    $store_id = $mysqli->real_escape_string($_POST['store_id']);

    $mysqli->query(" UPDATE pharmacy_store SET store_name = '$store_name', description = '$description', address = '$address', latitude='$latitude', longitude='$longitude' WHERE id = '$store_id' ") or die($mysqli->error);

    $_SESSION['pharmacyError'] = "Store has been updated!";
    $_SESSION['msg_type'] = "info";
    header("location: pharmacy_settings.php");
}

?>
