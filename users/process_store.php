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


    //Check first if cart is existing currently
    $checkProduct = $mysqli->query("SELECT * FROM cart WHERE user_id ='$user_id' AND product_id = '$product_id' AND check_out <> '1' ");
    if(mysqli_num_rows($checkProduct) <= 0){
        $mysqli->query(" INSERT INTO cart (user_id, product_id, pharmacy_id, subtotal, updated_at, price) VALUES('$user_id', '$product_id', '$pharmacy_id', '$subtotal','$date', '$subtotal') ") or die($mysqli->error);
    }
    else{
        $getCount = $mysqli->query("SELECT count AS qty, price, id FROM cart WHERE user_id ='$user_id' AND product_id = '$product_id' ");
        $currentCount = mysqli_fetch_array($getCount);
        $newCount = $currentCount["qty"];
        $subtotal = $currentCount["price"];
        $newCount = $newCount + 1;
        $cartId = $currentCount["id"];
        $newSubTotal = $subtotal*$newCount;
        $mysqli->query(" UPDATE cart SET count = '$newCount', subtotal = '$newSubTotal' WHERE id='$cartId' ") or die($mysqli->error);
    }


    //Get last ID
    $last_id = $mysqli->insert_id;
    // OR
    // $last_id = mysqli_insert_id($mysqli);

    $jsonEncode = array('response' => 'Product has been added to basket! You may check your cart to modify the qty.');
    echo json_encode($jsonEncode);
}
?>
