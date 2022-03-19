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
    WHERE c.user_id = '$user_id'
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
        WHERE ps.id = '$store_id' ");
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
    WHERE c.user_id = '$user_id' AND c.pharmacy_id = '$store_id' ");

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
?>
