<?php
    include("dbh.php");

    if(isset($_POST['delete'])){
        $user_id = $_GET['delete'];
        $mysqli->query("DELETE FROM users WHERE id='$user_id'") or die($mysqli->error());

        $_SESSION['message'] = "Record has been deleted!";
        $_SESSION['msg_type'] = "danger";
        header("location: users.php");
    }

    if(isset($_GET['edit'])){
        $user_id = $_GET['edit'];
        $users = $mysqli->query("SELECT * FROM users u JOIN role r ON r.id = u.role WHERE u.id='$user_id'") or die ($mysqli->error());
        $edit_user = $users->fetch_array();

    }
?>