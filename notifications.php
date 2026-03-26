<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch students
$students = $conn->query("SELECT * FROM students");

// Handle submit
if (isset($_POST['send'])) {

    $student_id = $_POST['student_id'];
    $type = $_POST['type'];
    $message = $_POST['message'];

    // Save notification
    $stmt = $conn->prepare("INSERT INTO notifications (student_id, type, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $student_id, $type, $message);
    $stmt->execute();

    // Get father phone
    $row = $conn->query("SELECT father_phone FROM students WHERE id=$student_id")->fetch_assoc();
    $phone = $row['father_phone'];
    // 🔐 PHONE VALIDATION
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    die("Invalid phone number");
}
    // 📱 Send SMS (Fast2SMS)
    $msg = urlencode("Notification: $message");
    file_get_contents("https://www.fast2sms.com/dev/bulkV2?authorization=YOUR_API_KEY&route=v3&message=$msg&numbers=$phone");

    echo "<script>alert('Notification Sent');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Notifications</title>

<style>
body { font-family: Arial; background: #f1f5f9; padding: 20px; }

.box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    margin: auto;
}

input, select, textarea, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}

button {
    background: #4f46e5;
    color: white;
    border: none;
}
</style>
</head>

<body>

<div class="box">
<h2>Send Notification</h2>

<form method="POST">

<select name="student_id" required>
    <option value="">Select Student</option>
    <?php while($row = $students->fetch_assoc()) { ?>
        <option value="<?= $row['id'] ?>"><?= $row['first_name'] ?></option>
    <?php } ?>
</select>

<select name="type">
    <option>Marks</option>
    <option>Attendance</option>
    <option>Behaviour</option>
</select>

<textarea name="message" placeholder="Enter message..." required></textarea>

<button name="send">Send Notification</button>

</form>
</div>

</body>
</html>