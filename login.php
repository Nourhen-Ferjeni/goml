<?php
session_start();
include_once('connection.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Validation des champs de formulaire
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in both username and password');</script>";
        exit;
    }

    $sql = "SELECT * FROM `tbl_user` WHERE `username`='$username' AND `password`='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 0) {
            header('Location: archif.php');
        } else if ($row['role'] == 1) {
            header('Location: index.php');
        }
        exit;
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
        exit;
    }
}
?>
