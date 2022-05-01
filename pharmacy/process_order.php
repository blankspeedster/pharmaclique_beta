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
    $pharmacy_amount_paid = $data["pharmacy_amount_paid"];
    $mode_of_payment = $data["mode_of_payment"];

    mysqli_query($mysqli, "UPDATE transaction SET status = '-1' WHERE id = '$transaction_id' ");
    
    //Less the product stock here
    $getCartInfo = mysqli_query($mysqli, "SELECT * FROM cart WHERE transaction_id = '$transaction_id' ");
    while($cart = mysqli_fetch_array($getCartInfo)){
        $cartQty = $cart["count"];
        $productId = $cart["product_id"];
        $products = mysqli_query($mysqli, "SELECT * FROM pharmacy_products WHERE id = '$productId' ");
        while($product = mysqli_fetch_array($products)){
            $productStock = $product["product_stock"];
            $newQty = $productStock - $cartQty;
            mysqli_query($mysqli, "UPDATE pharmacy_products SET product_stock = '$newQty' WHERE id = '$productId' ");
        }
    }

    //Update balance of the pharmacy
    if($mode_of_payment == '1'){
        $user_id = $_SESSION['user_id'];
        $getBalance = mysqli_query($mysqli, "SELECT * FROM users WHERE id = '$user_id' ");
        $newBalance = mysqli_fetch_array($getBalance);
        $currentBalance = $newBalance["balance"];
        $updatedBalance = $currentBalance + $pharmacy_amount_paid;
        mysqli_query($mysqli, "UPDATE users SET balance = '$updatedBalance' WHERE id = '$user_id' ");
    }
    //End update balance of the pharmacy

    $response[] = array("response"=>"Order has been confirmed. Awaiting Driver.");
    echo json_encode($response);
}

//Picked Up Order
if (isset($_GET['pickedUpOrder'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];

    mysqli_query($mysqli, "UPDATE transaction SET status = '-2' WHERE id = '$transaction_id' ");
    $response[] = array("response"=>"Order has been pickedup by the rider.");
    echo json_encode($response);
}

//Get Rider Information
if (isset($_GET['getRiderInformation'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];
    $riderInfo = array();
    
    $getAcceptedRiders = mysqli_query($mysqli, "SELECT * FROM rider_transaction rt
    JOIN users u ON u.id = rt.rider_id
    WHERE rt.transaction_id = '$transaction_id' ");
    
    $rider = mysqli_fetch_assoc($getAcceptedRiders);
    $riderInfo[] = $rider;

    echo json_encode($riderInfo);
}

?>