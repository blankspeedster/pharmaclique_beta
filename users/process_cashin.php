<?php
    include("dbh.php");

    //push new balance after cash in
    if(isset($_GET["paypalCashIn"])){
        $data = json_decode(file_get_contents('php://input'), true);

        $user_id = $data["account_id"];
        $amount = $data["amount"];

        $chekcBalance = $mysqli->query("SELECT * FROM users WHERE id='$user_id' ") or die ($mysqli->error);
        $newBalance = $chekcBalance->fetch_array();
        $newBalance = $newBalance["balance"];
        $newBalance = $newBalance;
        $newAmount = $newBalance + $amount;
        $mysqli->query("UPDATE users SET balance = '$newAmount' WHERE id='$user_id' ") or die ($mysqli->error);

        $response = array('message' => 'cash in succesful');
        echo json_encode($response);
    }
