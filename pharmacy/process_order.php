<?php
include("dbh.php");
$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

//Get Current Orders
if (isset($_GET['getCurrentOrders'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $orders = array();

    $getCurrentOrders = mysqli_query($mysqli, "SELECT *, t.id AS transactionId, ps.id as userId
    FROM transaction t
    JOIN pharmacy_store ps ON ps.id = t.pharmacy_id
    WHERE ps.user_id = '$user_id' AND (t.status = '0' OR t.status = '-1') ");

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
        JOIN users u
        ON u.id = t.user_id
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
if (isset($_GET['getCompletedProducts'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $orders = array();

    $getCurrentOrders = mysqli_query($mysqli, "SELECT *, t.id AS transactionId FROM transaction t JOIN pharmacy_store ps ON ps.id = t.pharmacy_id WHERE ps.user_id = '$user_id' AND (t.status = '1' OR t.status = '-2')  ");

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

//Get Cancelled Orders
if (isset($_GET['getCancelledOrders'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $orders = array();

    $getCurrentOrders = mysqli_query($mysqli, "SELECT *, t.id AS transactionId FROM transaction t JOIN pharmacy_store ps ON ps.id = t.pharmacy_id WHERE ps.user_id =  '$user_id' AND t.status = '-3' ");

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
        JOIN users u
        ON u.id = t.user_id
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

//Cancel Order
if (isset($_GET['cancelOrder'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];

    $getCurrentOrders = mysqli_query($mysqli, "UPDATE transaction SET status = '-3' WHERE id = '$transaction_id' ");
    $response[] = array("response"=>"Order has been cancelled.");
    echo json_encode($response);
}

//Confirm Order
if (isset($_GET['confirmOrder'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];

    $getCurrentOrders = mysqli_query($mysqli, "UPDATE transaction SET status = '-1' WHERE id = '$transaction_id' ");
    $response[] = array("response"=>"Order has been confirmed. Awaiting Driver.");
    echo json_encode($response);
}

//Picked Up Order
if (isset($_GET['pickedUpOrder'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];

    $getCurrentOrders = mysqli_query($mysqli, "UPDATE transaction SET status = '-2' WHERE id = '$transaction_id' ");
    $response[] = array("response"=>"Order has been pickedup by the rider.");
    echo json_encode($response);
}

//Get Rider Information
if (isset($_GET['getRiderInformation'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];
    $riderInformation = array();
    
    $getAcceptedRiders = mysqli_query($mysqli, "SELECT * FROM rider_transaction rt WHERE rt.transaction_id = '$transaction_id' ");

    while ($rider = mysqli_fetch_assoc($getAcceptedRiders)) {
        $$riderInformation[] = $rider;
    }       
    echo json_encode($riderInformation);
}

?>