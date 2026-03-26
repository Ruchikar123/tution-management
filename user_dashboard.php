<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI';
    background: #f1f5f9;
}

/* 🔥 Top Horizontal Menu */
.top-menu {
    display: flex;
    justify-content: center;
    gap: 15px;
    background: #1e293b;
    padding: 15px;
}

.top-menu a {
    color: white;
    text-decoration: none;
    padding: 10px 18px;
    background: #4f46e5;
    border-radius: 8px;
    transition: 0.3s;
}

.top-menu a:hover {
    background: #6366f1;
}

/* Container */
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
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
}

/* Content Box */
.box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<!-- 🔥 TOP MENU -->
<div class="top-menu">
    <a href="user_attendance.php">Attendance</a>
    <a href="user_documents.php">Documents</a>
    <a href="user_notifications.php">Notifications</a>
    <a href="subjects.php">Subjects</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">

<!-- 👋 Welcome -->
<div class="welcome">
    <h2>Welcome, <?php echo $username; ?> 🎓</h2>
</div>

<!-- 📊 Cards -->
<div class="cards">
    <div class="card">
        <h3>Attendance</h3>
        <p>100%</p>
    </div>
    <div class="card">
        <h3>Subjects</h3>
        <p>5 Subjects</p>
    </div>
</div>

<!-- 📦 Content Area -->
<div class="box">
    <h3>Dashboard Overview</h3>
    <p>Select any option from the top menu to view details like attendance, documents, notifications, etc.</p>
</div>

</div>

</body>
</html>