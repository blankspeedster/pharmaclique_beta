<?php
include("dbh.php");
$date = date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d H:i:s');

//Get Products
if (isset($_GET['getProducts'])) {
    $store_id = $_GET['getProducts'];
    $store_products = mysqli_query($mysqli, "SELECT * FROM pharmacy_products WHERE store_id = '$store_id' ORDER BY updated_at DESC");
    $products = array();
    while ($product = mysqli_fetch_assoc($store_products)) {
        $products[] = $product;
    }
    echo json_encode($products);
}

//Get Products
if (isset($_GET['searchProducts'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $searchVal = $data["searchVal"];
    if($searchVal == null || $searchVal == ""){
        $store_products = mysqli_query($mysqli, "SELECT * FROM pharmacy_products LIMIT 20 ");
    }
    else{
        $store_products = mysqli_query($mysqli, "SELECT * FROM pharmacy_products WHERE product_description LIKE '%$searchVal%' ");
    }
    $products = array();
    while ($product = mysqli_fetch_assoc($store_products)) {
        $products[] = $product;
    }
    echo json_encode($products);
}

//Search Products within the store
if (isset($_GET['searchProductsWithinStore'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $searchVal = $data["searchVal"];
    $store_id = $data["store_id"];
    if($searchVal == null || $searchVal == ""){
        $store_products = mysqli_query($mysqli, "SELECT * FROM pharmacy_products ");
    }
    else{
        $store_products = mysqli_query($mysqli, "SELECT * FROM pharmacy_products WHERE product_description LIKE '%$searchVal%' ");
    }
    $products = array();
    while ($product = mysqli_fetch_assoc($store_products)) {
        $products[] = $product;
    }
    echo json_encode($products);
}

//Add To Cart
if (isset($_GET['addToCart'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $product_id = $data["product_id"];
    $pharmacy_id = $data["pharmacy_id"];
    $subtotal = $data["subtotal"];

    $mysqli->query(" INSERT INTO cart (user_id, product_id, pharmacy_id, subtotal, updated_at) VALUES('$user_id', '$product_id', '$pharmacy_id', '$subtotal','$date') ") or die($mysqli->error);


    //Get last ID
    $last_id = $mysqli->insert_id;
    // OR
    // $last_id = mysqli_insert_id($mysqli);

    $jsonEncode = array('response' => 'Product has been added to basket! You may check your cart to modify the qty.');
    echo json_encode($jsonEncode);
}

//Get Store and Product Information
if(isset($_GET["getStoreInCart"])){
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    
    $getStores = mysqli_query($mysqli, " SELECT * FROM cart c
    JOIN pharmacy_products pp
    ON pp.id = c.product_id
    JOIN pharmacy_store ps
    ON ps.id = c.pharmacy_id
    WHERE c.user_id = '$user_id' AND c.check_out <> '1'
    GROUP BY ps.id ");

    $stores = array();
    while ($store = mysqli_fetch_assoc($getStores)) {
        $products = array();
        $store_id = $store["pharmacy_id"];
        $getProducts = mysqli_query($mysqli, " SELECT *, c.user_id as customer_id FROM cart c
        JOIN pharmacy_products pp
        ON pp.id = c.product_id
        JOIN pharmacy_store ps
        ON ps.id = c.pharmacy_id
        WHERE ps.id = '$store_id' AND c.check_out <> '1' ");
        while ($product = mysqli_fetch_assoc($getProducts)) {
            $products[] = $product;
        }        
        $stores[] = $products;
    }
    
    echo json_encode($stores);
}

//Get Specific Store and Product Information
if(isset($_GET["getSpecificPharmacyAndProduct"])){
    $data = json_decode(file_get_contents('php://input'), true);
    $store_id = $data["store_id"];
    $user_id = $data["user_id"];
    $getProducts = mysqli_query($mysqli, " SELECT *, c.id AS cart_id FROM cart c
    JOIN pharmacy_products pp
    ON pp.id = c.product_id
    JOIN pharmacy_store ps
    ON ps.id = c.pharmacy_id
    WHERE c.user_id = '$user_id' AND c.pharmacy_id = '$store_id' AND c.check_out <> '1' ");

    $products = array();
    while ($product = mysqli_fetch_assoc($getProducts)) { 
        $products[] = $product;
    }
    
    echo json_encode($products);
}

//Add QTY Product
if(isset($_GET["plusQuantity"])){
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data["cart_id"];

    $getCount = $mysqli->query("SELECT count AS qty, price FROM cart WHERE id ='$cart_id' ");
    $currentCount = mysqli_fetch_array($getCount);
    $newCount = $currentCount["qty"]+1;
    $newSubTotal = $newCount * $currentCount["price"];
    $mysqli->query(" UPDATE cart SET count = '$newCount', subtotal = '$newSubTotal' WHERE id='$cart_id' ") or die($mysqli->error);

    $jsonEncode = array('response' => 'Product in your cart has been updated!');
    echo json_encode($jsonEncode);
}

//Subtract QTY Product
if(isset($_GET["minusQuantity"])){
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data["cart_id"];

    $getCount = $mysqli->query("SELECT count AS qty, price FROM cart WHERE id ='$cart_id' ");
    $currentCount = mysqli_fetch_array($getCount);
    $newCount =  $currentCount["qty"];
    if($newCount == 1){
        $mysqli->query(" DELETE FROM cart WHERE id='$cart_id' ") or die($mysqli->error);
    }
    else{
        $newCount = $newCount-1;
        $newSubTotal = $newCount * $currentCount["price"];
        $mysqli->query(" UPDATE cart SET count = '$newCount', subtotal = '$newSubTotal' WHERE id='$cart_id' ") or die($mysqli->error);
    }


    $jsonEncode = array('response' => 'Product in your cart has been deleted!');
    echo json_encode($jsonEncode);
}

//Checkout
if(isset($_POST['checkout'])){
    $products = $_POST["products"];
    $currentProducts = array();
    //Get Subtotal
    $subtotal = 0;
    foreach ($products as $product){
        $getsubtotal = $mysqli->query("SELECT subtotal FROM cart WHERE id ='$product' ");
        $newSubtotal = mysqli_fetch_array($getsubtotal);
        $subtotal = $newSubtotal["subtotal"] + $subtotal;
        //insert array id in session products
        $currentProducts[] = $product;
    }

    $_SESSION['currentProducts'] = $currentProducts;
    $_SESSION['currentProductsSubtotal'] = $subtotal;
    
    header("location: place_order.php");
}

//Place Order
if(isset($_GET['placeOrder'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $lat = $data["lat"];
    $long = $data["long"];
    $completeAddress = $data["completeAddress"];
    $deliveryCharge = $data["deliveryCharge"];
    echo $mode_of_payment = $data["mode_of_payment"];

    $checkOutProducts = $_SESSION['currentProducts'];
    $user_id = 0;
    $pharmacy_id = 0;
    $subTotal = 0;

    foreach ($checkOutProducts as $cart_id){
        $checkCart = $mysqli->query("SELECT * FROM cart WHERE id = '$cart_id' ");
        $cart = mysqli_fetch_array($checkCart);
        $subTotal = $cart["subtotal"] + $subTotal;
        $pharmacy_id = $cart["pharmacy_id"];
        $user_id = $cart["user_id"];
    }

    $subTotal = $subTotal + $deliveryCharge;

    $mysqli->query(" INSERT INTO transaction (pharmacy_id, user_id, transaction_date, total_amount, amount_paid, user_long, user_lat, delivery_charge, mode_of_payment) VALUES('$pharmacy_id', '$user_id', '$date', '$subTotal','$subTotal', '$long', '$lat', '$deliveryCharge', '$mode_of_payment') ") or die($mysqli->error);

    //Get Transaction ID and update the status id of the cart
    $transaction_id = $mysqli->insert_id;
    foreach ($checkOutProducts as $cart_id){
        $mysqli->query(" UPDATE cart SET transaction_id = '$transaction_id', check_out = '1' WHERE id='$cart_id' ") or die($mysqli->error);
    }

    $jsonEncode = array("response" => "Place order completed!", "status"=>"1");

    echo json_encode($jsonEncode);
}

//Balance is enough
if(isset($_GET['check_balance'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $currenTotal = $data["currentTotal"];

    $user_id = $_SESSION['user_id'];

    $getBalance =  $mysqli->query(" SELECT * FROM users WHERE id = '$user_id' ") or die($mysqli->error);
    $newBalance = mysqli_fetch_array($getBalance);
    $balance = $newBalance["balance"];

    if($balance > $currenTotal){
        $jsonEncode = array("response" => "Balance is sufficient", "status" => "1");
        $currentBalance = $balance - $currenTotal;
        $mysqli->query(" UPDATE users SET balance = '$currentBalance' WHERE id = '$user_id' ") or die($mysqli->error);
    }
    else{
        $jsonEncode = array("response" => "Balance is not sufficient", "status" => "0", "balance" => $balance);
    }
    
    echo json_encode($jsonEncode);
}
