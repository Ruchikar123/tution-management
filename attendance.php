<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$date = date("Y-m-d");

// Get students
$students = $conn->query("SELECT * FROM students");

// Save attendance
if (isset($_POST['submit'])) {
    foreach ($_POST['status'] as $id => $status) {

        // Prevent duplicate
        $check = $conn->prepare("SELECT * FROM attendance WHERE student_id=? AND date=?");
        $check->bind_param("is", $id, $date);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $id, $date, $status);
            $stmt->execute();

            // 📩 Notification (for absent)
            if ($status == "Absent") {
                $row = $conn->query("SELECT father_phone FROM students WHERE id=$id")->fetch_assoc();
                $phone = $row['father_phone'];

                // 👉 SMS API (Fast2SMS)
                $otpMsg = "Your child is absent today ($date)";
                file_get_contents("https://www.fast2sms.com/dev/bulkV2?authorization=YOUR_API_KEY&route=v3&message=$otpMsg&numbers=$phone");
            }
        }
    }

    echo "<script>alert('Attendance Saved');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Attendance</title>

<style>
body { font-family: Arial; background: #f1f5f9; padding: 20px; }

table { width: 100%; background: white; border-collapse: collapse; }

th, td { padding: 10px; border: 1px solid #ddd; }

button { padding: 10px; background: #4f46e5; color: white; border: none; }
</style>
</head>

<body>

<h2>Mark Attendance (<?php echo $date; ?>)</h2>

<form method="POST">
<table>
<tr>
    <th>Name</th>
    <th>Present</th>
    <th>Absent</th>
</tr>

<?php while($row = $students->fetch_assoc()) { ?>
<tr>
    <td><?= $row['first_name'] ?></td>
    <td><input type="radio" name="status[<?= $row['id'] ?>]" value="Present" required></td>
    <td><input type="radio" name="status[<?= $row['id'] ?>]" value="Absent"></td>
</tr>
<?php } ?>

</table>

<br>
<button name="submit">Save Attendance</button>
</form>

</body>
</html>