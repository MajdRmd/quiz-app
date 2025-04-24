<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];
$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed')";
if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "error";
}
?>
