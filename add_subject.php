<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['subject_name'];
    $desc = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO subjects (subject_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $desc);

    if ($stmt->execute()) {
        $msg = "Subject Added Successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Subject</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg,#43e97b,#38f9d7);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box {
    background:white;
    padding:30px;
    width:350px;
    border-radius:10px;
}

input, textarea, button {
    width:100%;
    padding:10px;
    margin:10px 0;
}

button {
    background:#43e97b;
    border:none;
    color:white;
}
</style>
</head>

<body>

<div class="box">
<h2>Add Subject</h2>

<?php if(isset($msg)) echo "<p>$msg</p>"; ?>

<form method="POST">
<input type="text" name="subject_name" placeholder="Subject Name" required>
<textarea name="description" placeholder="Description"></textarea>
<button type="submit">Add Subject</button>
<a href="user_dashboard.php" class="back-btn">← Back</a>
</form>

</div>

</body>
</html>