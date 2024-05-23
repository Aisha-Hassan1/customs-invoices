<?php
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO customers (name, phone_number) VALUES ('$name', '$phone')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_users.php");
        exit();
    } else {
        echo "خطأ: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}




?>