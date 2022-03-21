<?php
include("dbh.php");
$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

//Get Current Orders
if (isset($_GET['getTransaction'])) {
    $data = json_decode(file_get_contents('php://input'), true);

    $getOrdersForPickUp = mysqli_query($mysqli, "SELECT *, t.id AS transactionId, ps.longitude as pharmacyLong, ps.latitude as pharmacyLat, t.user_long AS customer_long, t.user_lat AS customer_lat
    FROM transaction t
    JOIN pharmacy_store ps
    ON t.pharmacy_id = ps.id
    JOIN users u ON u.id = t.user_id
    LEFT JOIN rider_transaction rt ON rt.transaction_id = t.id 
    WHERE t.status = '-1' AND rt.transaction_id IS NULL  ");
    $orders = array();
    $counter = 0;
    while ($order = mysqli_fetch_assoc($getOrdersForPickUp)) {
        $orders[$counter] = $order;
        $transactionId = $order["transactionId"];
        $getProducts = mysqli_query($mysqli, "SELECT * FROM transaction t
        JOIN cart c ON c.transaction_id = t.id JOIN pharmacy_products pp ON pp.id = c.product_id WHERE t.id='$transactionId' ");
        while($product = mysqli_fetch_assoc($getProducts)){
            $orders[$counter]["products"][] = $product;
        }
        $counter++;
    }

    echo json_encode($orders);
}

//Accept Transaction acceptBooking
if (isset($_GET['acceptBooking'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $transaction_id = $data["transaction_id"];
    $lat = $data["lat"];
    $long = $data["long"];
    $customer_lat = $data["customer_lat"];
    $customer_long = $data["customer_long"];

    $mysqli->query(" INSERT INTO rider_transaction (rider_id, transaction_id, customer_lat, customer_long, updated_at) VALUES('$user_id', '$transaction_id', '$customer_lat', '$customer_long', '$date') ") or die($mysqli->error);
    $mysqli->query(" INSERT INTO rider_logs (rider_id, rider_lat, rider_long, transaction_id, updated_at) VALUES('$user_id', '$lat', '$long','$transaction_id', '$date') ") or die($mysqli->error);

    $response[] = array("response"=>"Product has been updated!");

    echo json_encode($response);
}

//Get Current Booking for Rides
if (isset($_GET['getCurrentBooking'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $booking_id = $data["booking_id"];

    $getOrdersForPickUp = mysqli_query($mysqli, "SELECT *, t.id AS transactionId, ps.longitude as pharmacyLong, ps.latitude as pharmacyLat, t.user_long AS customer_long, t.user_lat AS customer_lat
    FROM transaction t
    JOIN pharmacy_store ps
    ON t.pharmacy_id = ps.id
    JOIN users u ON u.id = t.user_id
    LEFT JOIN rider_transaction rt ON rt.transaction_id = t.id 
    WHERE rt.id = '$booking_id'  ");
    $orders = array();
    $counter = 0;
    while ($order = mysqli_fetch_assoc($getOrdersForPickUp)) {
        $orders[$counter] = $order;
        $transactionId = $order["transactionId"];
        $getProducts = mysqli_query($mysqli, "SELECT * FROM transaction t
        JOIN cart c ON c.transaction_id = t.id JOIN pharmacy_products pp ON pp.id = c.product_id WHERE t.id='$transactionId' ");
        while($product = mysqli_fetch_assoc($getProducts)){
            $orders[$counter]["products"][] = $product;
        }
        $counter++;
    }

    echo json_encode($orders);
}
