<?php
include_once('connection.php');

if(isset($_POST['register']))
{
    $name = $_POST['name'];
    $username = $_POST['username'];
    $pass = md5($_POST['password']);
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $role = isset($_POST['role']) ? $_POST['role'] : '0'; // Default to 0 if not set

    $sql = "INSERT INTO `tbl_user`(`name`, `username`, `password`, `poste`, `tel`, `role`) VALUES ('$name','$username','$pass','$position','$phone','$role')";
    $result = mysqli_query($conn, $sql);
    if($result){ 
        header('location:indexlog.php');
        echo "<script>alert('New User Register Success');</script>";   
    } else {
        die(mysqli_error($conn));
    }
}
?>
