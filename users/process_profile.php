<?php
include("dbh.php");

//Save Storename
if (isset($_POST['save_doctror_profile'])) {
    $first_name = $mysqli->real_escape_string($_POST['first_name']);
    $last_name = $mysqli->real_escape_string($_POST['last_name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
    $hourly_rate = $mysqli->real_escape_string($_POST['hourly_rate']);

    $doctor_id = $mysqli->real_escape_string($_POST['user_id']);

    $hourly_rate = $mysqli->real_escape_string($_POST['hourly_rate']);
    $specialization = $mysqli->real_escape_string($_POST['specialization']);

    $mysqli->query(" INSERT INTO doctor_profile (doctor_id, hourly_rate, specialization) VALUES('$doctor_id', '$hourly_rate','$specialization') ") or die($mysqli->error);
    $mysqli->query(" UPDATE users SET firstname = '$first_name', lastname = '$last_name', email='$email', phone_number='$phone_number' WHERE id = '$doctor_id'  ") or die($mysqli->error);


    $_SESSION['pharmacyError'] = "Doctor Profile has been created!";
    $_SESSION['msg_type'] = "success";
    header("location: profile.php");
}

//Update Storename
if (isset($_POST['update_doctror_profile'])) {
    $first_name = $mysqli->real_escape_string($_POST['first_name']);
    $last_name = $mysqli->real_escape_string($_POST['last_name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $phone_number = $mysqli->real_escape_string($_POST['phone_number']);
    $hourly_rate = $mysqli->real_escape_string($_POST['hourly_rate']);

    $doctor_id = $mysqli->real_escape_string($_POST['user_id']);
    $profile_id = $mysqli->real_escape_string($_POST['profile_id']);

    $hourly_rate = $mysqli->real_escape_string($_POST['hourly_rate']);
    $specialization = $mysqli->real_escape_string($_POST['specialization']);

    $mysqli->query("UPDATE doctor_profile SET hourly_rate = '$hourly_rate', specialization = '$specialization' WHERE id = '$profile_id' ") or die($mysqli->error);
    $mysqli->query("UPDATE users SET firstname = '$first_name', lastname = '$last_name', email='$email', phone_number='$phone_number' WHERE id = '$doctor_id'") or die($mysqli->error);

    $_SESSION['pharmacyError'] = "Doctor Profile has been updated!";
    $_SESSION['msg_type'] = "info";
    header("location: profile.php");
}


//Update Profile Picture
if (isset($_GET['uploadProfilePicture'])) {
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

    $id_url = $randomName;
    $user_id = $_GET["uploadProfilePicture"];

    $checkPWD = $mysqli->query("SELECT * FROM pwd WHERE user_id = '$user_id' ") or die($mysqli->error);

    if(mysqli_num_rows($checkPWD) > 0){
        $mysqli->query("UPDATE pwd SET id_url = '$id_url' WHERE user_id = '$user_id' ") or die($mysqli->error);
    }
    else{
        $mysqli->query("INSERT INTO pwd (user_id, id_url) VALUES ('$user_id','$id_url') ") or die($mysqli->error);
    }

    $response[] = array("response" => "Display Picture has been saved!");

    echo json_encode($response);
}
