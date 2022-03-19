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
?>
