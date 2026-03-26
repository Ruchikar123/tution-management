<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

// Total students
$total = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];

// Students per subject
$subjectData = $conn->query("SELECT subject, COUNT(*) as count FROM students GROUP BY subject");
?>

<!DOCTYPE html>
<html>
<head>
<title>Premium Admin Dashboard</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f1f5f9;
}

/* Top Navbar Buttons */
.top-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
    background: #1e293b;
    padding: 15px;
}

.top-buttons a {
    color: white;
    text-decoration: none;
    padding: 10px 18px;
    background: #4f46e5;
    border-radius: 8px;
    transition: 0.3s;
}

.top-buttons a:hover {
    background: #6366f1;
}

/* Main Content */
.container {
    padding: 30px;
}

/* Welcome */
.welcome {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

/* Cards */
.cards {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.card {
    flex: 1;
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
}

/* Subject Table */
.table-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

th {
    background: #f8fafc;
}
</style>
</head>

<body>

<!-- 🔥 Horizontal Buttons -->
<div class="top-buttons">
    <a href="students.php">Student List</a>
    <a href="attendance.php">Attendance</a>
    <a href="documents.php">Documents</a>
    <a href="notifications.php">Notifications</a>
    <a href="add_subject.php">Subjects</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">

<!-- 👋 Welcome -->
<div class="welcome">
    <h2>Welcome, <?php echo $username; ?> 👋</h2>
</div>

<!-- 📊 Total Students -->
<div class="cards">
    <div class="card">
        <h3>Total Students Admitted</h3>
        <h1><?php echo $total; ?></h1>
    </div>
</div>

<!-- 📚 Students per Subject -->
<div class="table-box">
    <h3>Students per Subject</h3>
    <table>
        <tr>
            <th>Subject</th>
            <th>Number of Students</th>
        </tr>

        <?php while($row = $subjectData->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['subject'] ?></td>
            <td><?= $row['count'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</div>

</body>
</html>