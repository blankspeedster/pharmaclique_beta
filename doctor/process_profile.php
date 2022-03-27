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

?>
