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

//create Product
if (isset($_GET['createProduct'])) {
    $uploadDir = "../assets/images/";
    $data = json_decode(file_get_contents('php://input'), true);
    
    //Upload image
    if ($_FILES['picture']) {
        $pictureName = $_FILES["picture"]["name"];
        $pictureName = preg_replace('/\s+/', '', $pictureName);
        $pictureTmpName = $_FILES["picture"]["tmp_name"];
        $pictureTmpName = preg_replace('/\s+/', '', $pictureTmpName);

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
    $product_price = $mysqli->real_escape_string($_POST["price"]);
    $product_weight = $mysqli->real_escape_string($_POST["weight"]);
    $product_brand = $mysqli->real_escape_string($_POST["brand"]);
    $product_type = $mysqli->real_escape_string($_POST["type"]);
    $product_url = $randomName;
    $store_id = $mysqli->real_escape_string($_GET['createProduct']);



    $mysqli->query(" INSERT INTO pharmacy_products (store_id, product_code, product_name, product_description, product_url, product_stock, product_category_id, product_price, product_weight, product_brand, product_type) VALUES('$store_id','$product_code','$product_name','$product_description','$product_url','$product_stock','$product_category_id', '$product_price', '$product_weight', '$product_brand', '$product_type') ") or die($mysqli->error);

    $response[] = array("response"=>"Product has been saved!", "product:" =>"Product created!");

    echo json_encode($response);
}

//Update Product
if (isset($_GET['updateProduct'])) {
    $uploadDir = "../assets/images/";
    $data = json_decode(file_get_contents('php://input'), true);
    $pictureExist = false;
    //Upload image
    if ($_FILES['picture']) {
        $pictureExist = true;
        $pictureName = $_FILES["picture"]["name"];
        $pictureName = preg_replace('/\s+/', '', $pictureName);
        $pictureTmpName = $_FILES["picture"]["tmp_name"];
        $pictureTmpName = preg_replace('/\s+/', '', $pictureTmpName);

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
    else{
        $pictureExist = false;
    }

    $product_name = $mysqli->real_escape_string($_POST["name"]);
    $product_code = $mysqli->real_escape_string(substr($product_name, 0, 5));
    $product_description = $mysqli->real_escape_string($_POST["description"]);
    $product_category_id = $mysqli->real_escape_string($_POST["category"]);
    $product_stock = $mysqli->real_escape_string($_POST["stock"]);
    $product_price = $mysqli->real_escape_string($_POST["price"]);
    $product_weight = $mysqli->real_escape_string($_POST["weight"]);
    $product_brand = $mysqli->real_escape_string($_POST["brand"]);
    $product_type = $mysqli->real_escape_string($_POST["type"]);
    $product_url = $randomName;
    $product_id = $mysqli->real_escape_string($_GET['updateProduct']);

    if(!$pictureExist){
        $mysqli->query(" UPDATE pharmacy_products SET
        product_code = '$product_code',
        product_name = '$product_name',
        product_description = '$product_description',
        product_stock = '$product_stock',
        product_category_id = '$product_category_id',
        product_price = '$product_price',
        product_weight = '$product_weight',
        product_description = '$product_description',
        product_brand = '$product_brand',
        product_type = '$product_type'
        WHERE id = '$product_id' ") or die($mysqli->error);
    }
    else{
        $mysqli->query(" UPDATE pharmacy_products SET
        product_code = '$product_code',
        product_name = '$product_name',
        product_description = '$product_description',
        product_stock = '$product_stock',
        product_category_id = '$product_category_id',
        product_price = '$product_price',
        product_weight = '$product_weight',
        product_description = '$product_description',
        product_brand = '$product_brand',
        product_type = '$product_type'
        product_url = '$product_url'
        WHERE id = '$product_id' ") or die($mysqli->error);
    }

    $response[] = array("response"=>"Product has been updated!");

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
