<?php
include "db.php";

$password = password_hash("user123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password, role)
VALUES ('User', 'user@gmail.com', '$password', 'user')";

if ($conn->query($sql) === TRUE) {
    echo "User Created! <br>Email: user@gmail.com <br>Password: user123";
} else {
    echo "Error: " . $conn->error;
}
?>