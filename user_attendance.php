<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    die("Session not set. Please login again.");
}

// ✅ Directly get ID from session
$student_id = $_SESSION['user_id'];

$month = date("m");
$year = date("Y");

$stmt = $conn->prepare("SELECT * FROM attendance WHERE student_id=? AND MONTH(date)=? AND YEAR(date)=?");
$stmt->bind_param("iii", $student_id, $month, $year);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>My Attendance</title>

<style>
body { font-family: Arial; background: #f1f5f9; padding: 20px; }

table { width: 100%; background: white; border-collapse: collapse; }

th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }

.present { background: lightgreen; }
.absent { background: #ffb3b3; }
</style>
</head>

<body>

<h2>Attendance - This Month</h2>

<table>
<tr>
    <th>Date</th>
    <th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr class="<?= strtolower($row['status']) ?>">
    <td><?= $row['date'] ?></td>
    <td><?= $row['status'] ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>