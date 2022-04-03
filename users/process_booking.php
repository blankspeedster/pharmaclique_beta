<?php
include("dbh.php");
$updated_at = date_default_timezone_set('Asia/Manila');
$updated_at = date('Y-m-d H:i:s');

//Get Doctors
if (isset($_GET['getDoctors'])) {
    $getDoctors = mysqli_query($mysqli, "SELECT * FROM doctor_profile dp JOIN users u ON u.id = dp.doctor_id ");
    $doctors = array();
    while ($doctor = mysqli_fetch_assoc($getDoctors)) {
        $doctors[] = $doctor;
    }
    echo json_encode($doctors);
}

//Search Doctors
if (isset($_GET['searchDoctors'])) {
    $searchVal = $_GET['searchDoctors'];
    $getDoctors = mysqli_query($mysqli, "SELECT * FROM doctor_profile dp JOIN users u ON u.id = dp.doctor_id WHERE dp.specialization LIKE '%$searchVal%' ");
    $doctors = array();
    while ($doctor = mysqli_fetch_assoc($getDoctors)) {
        $doctors[] = $doctor;
    }
    echo json_encode($doctors);
}

//Attempt Booking
if (isset($_GET['attemptBooking'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $doctor_id = $data["doctor_id"];
    $date = $data["date"];
    $timeFrom = $data["timeFrom"];
    $timeTo = $data["timeTo"];

    $timeFrom = $date." ".$timeFrom;
    $timeTo = $date." ".$timeTo;

    // $getBookings = mysqli_query($mysqli, "SELECT * FROM doctor_bookings WHERE doctor_id = '$doctor_id'
    // AND (date_time_from <= '$timeFrom' AND '$timeFrom' >=  date_time_from)
    // AND (date_time_to <= '$timeTo' AND '$timeTo' >=  date_time_to) AND status <> -1");

    $getBookings = mysqli_query($mysqli, "SELECT * FROM doctor_bookings WHERE doctor_id = '$doctor_id'
    AND ((date_time_from <= '$timeFrom' AND '$timeFrom' >=  date_time_from) AND (date_time_from >= '$timeFrom' AND '$timeFrom' <=  date_time_from))
    AND ((date_time_to <= '$timeTo' AND '$timeTo' >=  date_time_to) AND (date_time_to >= '$timeTo' AND '$timeTo' <=  date_time_to))
    AND status <> -1");
    
    if(mysqli_num_rows($getBookings) > 0){
        $response = array("response"=> "0",
        "message" =>"There is already a patient during this time, or your time clashed with other patients.",
        "colorScheme"=>"danger");
    }
    else{
        mysqli_query($mysqli, " INSERT INTO doctor_bookings (doctor_id, patient_id, date_time_from, date_time_to, updated_at) VALUES('$doctor_id', '$user_id', '$timeFrom', '$timeTo', '$updated_at')");
        $response = array("response"=> "1",
        "message"=>"Booking an appopintment is succesful!",
        "colorScheme"=>"success");
    }

    echo json_encode($response);
}

//Get Bookings not cancelled
if (isset($_GET['getBookings'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $getBookings = mysqli_query($mysqli, "SELECT *, DATE_FORMAT(db.date_time_from, '%Y-%m-%d') AS booking_date,
    TIME_FORMAT(db.date_time_from, '%H:%i') AS boking_date_time_from,
    TIME_FORMAT(db.date_time_to, '%H:%i') AS boking_date_time_to,
    db.status AS booking_status,
    db.id as booking_id 
    FROM doctor_bookings db
    JOIN users u ON u.id = db.doctor_id
    WHERE db.patient_id = '$user_id' AND db.status <> '-1' ");
    $bookings = array();
    while ($booking = mysqli_fetch_assoc($getBookings)) {
        $bookings[] = $booking;
    }
    echo json_encode($bookings);
}

//Get Cancelled Bookings
if (isset($_GET['getCancelledbookings'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data["user_id"];
    $getBookings = mysqli_query($mysqli, "SELECT *, DATE_FORMAT(db.date_time_from, '%Y-%m-%d') AS booking_date,
    TIME_FORMAT(db.date_time_from, '%H:%i') AS boking_date_time_from,
    TIME_FORMAT(db.date_time_to, '%H:%i') AS boking_date_time_to,
    db.status AS booking_status 
    FROM doctor_bookings db
    JOIN users u ON u.id = db.doctor_id
    WHERE db.patient_id = '$user_id' AND db.status = '-1' ");
    $bookings = array();
    while ($booking = mysqli_fetch_assoc($getBookings)) {
        $bookings[] = $booking;
    }
    echo json_encode($bookings);
}

//Cancel booking
if (isset($_GET['cancelBooking'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $booking_id = $data["booking_id"];

    mysqli_query($mysqli, " UPDATE doctor_bookings SET status = '-1' WHERE id = '$booking_id' ");

    $response = array();
    $response = array("response"=> "Booking has been cancelled.");
    echo json_encode($response);
}


// Get Booking Information
if (isset($_GET['getBookingInformation'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $booking_id = $data["booking_id"];

    $getBooking = mysqli_query($mysqli, "SELECT * FROM doctor_bookings db
    JOIN users u
    ON db.doctor_id = u.id
    WHERE db.id = '$booking_id' ");

    $booking = $getBooking->fetch_assoc();

    // while ($book = mysqli_fetch_assoc($getBooking)) {
    //     $booking[] = $book;
    // }

    echo json_encode($booking);
}

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
?>
