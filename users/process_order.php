<?php
include("dbh.php");
$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

//Get Current Orders
if (isset($_GET['getProducts'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $orders = array();

    $getCurrentOrders = mysqli_query($mysqli, "SELECT *, t.id AS transactionId FROM transaction t JOIN pharmacy_store ps ON ps.id = t.pharmacy_id WHERE t.user_id = '$user_id' AND t.status <> '1' AND t.status <> '-3' ");

    while ($order = mysqli_fetch_assoc($getCurrentOrders)) {
        $products = array();
        $transaction_id = $order["transactionId"];
        $getProducts = mysqli_query($mysqli, " SELECT *, c.user_id as customer_id FROM cart c
        JOIN pharmacy_products pp
        ON pp.id = c.product_id
        JOIN pharmacy_store ps
        ON ps.id = c.pharmacy_id
        JOIN transaction t
        ON t.id = c.transaction_id
        WHERE c.transaction_id = '$transaction_id' ");

        while ($product = mysqli_fetch_assoc($getProducts)) {
            $products[] = $product;
        }        
        $orders[] = $products;
    }

    // while ($order = mysqli_fetch_assoc($getCurrentOrders)) {
    //     $orders[] = $order;
    // }

    echo json_encode($orders);
}

//Get Completed Orders
if (isset($_GET['completedOrders'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $orders = array();

    $getCurrentOrders = mysqli_query($mysqli, "SELECT *, t.id AS transactionId FROM transaction t JOIN pharmacy_store ps ON ps.id = t.pharmacy_id WHERE t.user_id = '$user_id' AND t.status = '1'");

    while ($order = mysqli_fetch_assoc($getCurrentOrders)) {
        $products = array();
        $transaction_id = $order["transactionId"];
        $getProducts = mysqli_query($mysqli, " SELECT *, c.user_id as customer_id FROM cart c
        JOIN pharmacy_products pp
        ON pp.id = c.product_id
        JOIN pharmacy_store ps
        ON ps.id = c.pharmacy_id
        JOIN transaction t
        ON t.id = c.transaction_id
        WHERE c.transaction_id = '$transaction_id' ");

        while ($product = mysqli_fetch_assoc($getProducts)) {
            $products[] = $product;
        }        
        $orders[] = $products;
    }

    // while ($order = mysqli_fetch_assoc($getCurrentOrders)) {
    //     $orders[] = $order;
    // }

    echo json_encode($orders);
}

if(isset($_GET["getCancelledOrders"])){
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $orders = array();

    $getCurrentOrders = mysqli_query($mysqli, "SELECT *, t.id AS transactionId FROM transaction t JOIN pharmacy_store ps ON ps.id = t.pharmacy_id WHERE t.user_id = '$user_id' AND t.status = '-3'");

    while ($order = mysqli_fetch_assoc($getCurrentOrders)) {
        $products = array();
        $transaction_id = $order["transactionId"];
        $getProducts = mysqli_query($mysqli, " SELECT *, c.user_id as customer_id FROM cart c
        JOIN pharmacy_products pp
        ON pp.id = c.product_id
        JOIN pharmacy_store ps
        ON ps.id = c.pharmacy_id
        JOIN transaction t
        ON t.id = c.transaction_id
        WHERE c.transaction_id = '$transaction_id' ");

        while ($product = mysqli_fetch_assoc($getProducts)) {
            $products[] = $product;
        }        
        $orders[] = $products;
    }

    // while ($order = mysqli_fetch_assoc($getCurrentOrders)) {
    //     $orders[] = $order;
    // }

    echo json_encode($orders);
}

?>