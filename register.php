<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    die("Please fill all fields.");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed')";
if (mysqli_query($conn, $sql)) {
    
    header("Location: index.html");
    exit();
} else {
    echo "Error while registering: " . mysqli_error($conn);
}
?>
