<?php
session_start();
include "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// SEARCH
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ?");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Students Management</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f1f5f9;
}

/* Topbar */
.topbar {
    background: #1e293b;
    padding: 15px;
    color: white;
}

.topbar a {
    float: right;
    color: white;
    text-decoration: none;
}

/* Container */
.container {
    padding: 30px;
}

/* Form */
.form-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

input, select {
    padding: 10px;
    margin: 8px 0;
    width: 100%;
}

button {
    padding: 10px;
    background: #4f46e5;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background: #4338ca;
}

/* Table */
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

/* Search */
.search-box {
    margin-bottom: 15px;
}
</style>
</head>

<body>

<div class="topbar">
    Students Management
    <a href="admin_dashboard.php">⬅ Back</a>
</div>

<div class="container">

<!-- 🔍 Search -->
<form method="GET" class="search-box">
    <input type="text" name="search" placeholder="Search by name/email..." value="<?= $search ?>">
</form>

<!-- ➕ Add Student -->
<div class="form-box">
    <h3>Add Student</h3>
    <form action="add_student.php" method="POST">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="email" name="email" placeholder="Email" required>

        <select name="course">
            <option>Web Development</option>
            <option>Python</option>
            <option>Java</option>
        </select>

        <select name="subject">
            <option>HTML</option>
            <option>CSS</option>
            <option>JavaScript</option>
        </select>

        <button type="submit">Add Student</button>
    </form>
</div>

<!-- 📋 Student List -->
<div class="table-box">
    <h3>All Students</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Subject</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['course'] ?></td>
            <td><?= $row['subject'] ?></td>
            <td>
                <a href="delete_student.php?id=<?= $row['id'] ?>" 
                   onclick="return confirm('Delete this student?')">
                   ❌ Delete
                </a>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

</div>

</body>
</html>