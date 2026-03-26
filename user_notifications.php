<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM notifications WHERE student_id=? ORDER BY id DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Notifications</title>

<style>
body { font-family: Arial; background: #f1f5f9; padding: 20px; }

.card {
    background: white;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

.type {
    font-weight: bold;
    color: #4f46e5;
}
</style>
</head>

<body>

<h2>Notifications</h2>

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card">
    <div class="type"><?= $row['type'] ?></div>
    <p><?= $row['message'] ?></p>
    <small><?= $row['created_at'] ?></small>
</div>

<?php } ?>

</body>
</html>