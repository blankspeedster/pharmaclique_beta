<?php
include("dbh.php");

//Save Storename
if (isset($_POST['save_storename'])) {
    $store_name = $mysqli->real_escape_string($_POST['store_name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $user_id = $_SESSION['user_id'];

    $mysqli->query(" INSERT INTO pharmacy_store (user_id, store_name, description, address) VALUES('$user_id', '$store_name','$description', '$address') ") or die($mysqli->error);

    $_SESSION['pharmacyError'] = "Store has been created!";
    $_SESSION['msg_type'] = "success";
    header("location: pharmacy.php");
}

//Update Storename
if (isset($_POST['update_storename'])) {
    $store_name = $mysqli->real_escape_string($_POST['store_name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $store_id = $mysqli->real_escape_string($_POST['store_id']);

    $mysqli->query(" UPDATE pharmacy_store SET store_name = '$store_name', description = '$description', address = '$address' WHERE id = '$store_id' ") or die($mysqli->error);

    $_SESSION['pharmacyError'] = "Store has been updated!";
    $_SESSION['msg_type'] = "info";
    header("location: pharmacy.php");
}

//Post Product
if (isset($_GET['createProduct'])) {
    $uploadDir = "assets/images/";
    $data = json_decode(file_get_contents('php://input'), true);
    
    //Upload image
    if ($_FILES['picture']) {
        $pictureName = $_FILES["picture"]["name"];
        $pictureTmpName = $_FILES["picture"]["tmp_name"];
        $error = $_FILES["picture"]["error"];
        if ($error > 0) {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file!"
            );
        } else {
            $randomName = rand(1000, 100000000000) . "-" . $pictureName;
            $randomName = strtolower($randomName);
            $uploadName = $uploadDir . strtolower($randomName);
            $uploadName = preg_replace('/\s+/', '-', $uploadName);

            if (move_uploaded_file($pictureTmpName, $uploadName)) {

                $response = array(
                    "status" => "success",
                    "error" => false,
                    "message" => "File uploaded successfully",
                    "url" => $uploadName
                );
            } else {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            }
        }
    }

    $product_name = $mysqli->real_escape_string($_POST["name"]);
    $product_code = $mysqli->real_escape_string(substr($product_name, 0, 5));
    $product_description = $mysqli->real_escape_string($_POST["description"]);
    $product_category_id = $mysqli->real_escape_string($_POST["category"]);
    $product_stock = $mysqli->real_escape_string($_POST["stock"]);
    $product_url = $randomName;
    $store_id = $mysqli->real_escape_string($_GET['createProduct']);



    $mysqli->query(" INSERT INTO pharmacy_products (store_id, product_code, product_name, product_description, product_url, product_stock, product_category_id) VALUES('$store_id','$product_code','$product_name','$product_description','$product_url','$product_stock','$product_category_id') ") or die($mysqli->error);

    $response[] = array("response"=>"Product has been saved!");

    echo json_encode($response);


}

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

//Delete Product
if(isset($_GET['deleteProduct'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'];
    $mysqli->query("DELETE FROM pharmacy_products WHERE id = '$productId' ") or die($mysqli->error);

    $jsonEncode = array('response' => 'Product has been deleted!');
    echo json_encode($jsonEncode);
}

?>
