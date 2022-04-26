<?php
include("dbh.php");
$updated_at = date_default_timezone_set('Asia/Manila');
$updated_at = date('Y-m-d H:i:s');


//Upload Receipt Picture
if(isset($_GET['uploadReceiptPicture'])){
    $uploadDir = "../img/";
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

    $receipt_url = $randomName;
    $book_id = $_GET["uploadReceiptPicture"];

    $mysqli->query("UPDATE doctor_bookings SET receipt_url = '$receipt_url', receipt = '1' WHERE id = '$book_id' ") or die($mysqli->error);

    $response[] = array("response" => "Receipt has been saved!");

    echo json_encode($response);    
}

//Upload Receipt Picture
if(isset($_GET['uploadPrescriptionPicture'])){
    $uploadDir = "../img/";
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

    $prescription_url = $randomName;
    $transaction_id = $_GET["uploadPrescriptionPicture"];

    $mysqli->query("UPDATE transaction SET prescription_url = '$prescription_url' WHERE id = '$transaction_id' ") or die($mysqli->error);

    $response[] = array("response" => "Prescription has been saved!");

    echo json_encode($response);    
}

// Get Transaction Information
if (isset($_GET['getTransactionInformation'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];

    $getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction t
    JOIN users u
    ON t.user_id = u.id
    WHERE t.id = '$transaction_id' ");

    $transactions = $getTransaction->fetch_assoc();

    echo json_encode($transactions);
}

// Get Chats
if(isset($_GET['sendMessage'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];
    $chat_message = $data["chat_message"];

    $mysqli->query("INSERT INTO transaction_threads (transaction_id, user, user_message, updated_at) VALUES ('$transaction_id', 'customer', '$chat_message', '$updated_at' )") or die($mysqli->error);
}

// Send Message
if(isset($_GET['getChats'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $transaction_id = $data["transaction_id"];

    $getChats = mysqli_query($mysqli, "SELECT * FROM transaction_threads WHERE transaction_id = '$transaction_id' ");

    $chats = array();

    while ($chat = mysqli_fetch_assoc($getChats)) {
        $chats[] = $chat;
    }

    echo json_encode($chats);

}
?>
