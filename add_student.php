<?php
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$course = $_POST['course'];
$subject = $_POST['subject'];

$stmt = $conn->prepare("INSERT INTO students (name, email, course, subject) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $course, $subject);
$stmt->execute();

header("Location: students.php");
?>