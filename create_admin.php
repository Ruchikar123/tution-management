<?php
include "db.php";

$password = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, role)
VALUES ('Admin', 'admin@gmail.com', '$password', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "Admin Created! <br>Email: admin@gmail.com <br>Password: admin123";
} else {
    echo "Error: " . $conn->error;
}
?>