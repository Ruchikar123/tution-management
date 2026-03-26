<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM subjects ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Subjects</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    padding: 20px;
}

h2 {
    text-align: center;
}

.container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap: 20px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    margin-bottom: 10px;
}

.back-btn {
    display:inline-block;
    margin-bottom:20px;
    padding:10px 15px;
    background:#333;
    color:white;
    text-decoration:none;
    border-radius:5px;
}
</style>

</head>

<body>

<a href="user_dashboard.php" class="back-btn">← Back</a>

<h2>Subjects</h2>

<div class="container">

<?php while($row = $result->fetch_assoc()) { ?>
    <div class="card">
        <h3><?php echo $row['subject_name']; ?></h3>
        <p><?php echo $row['description']; ?></p>
    </div>
<?php } ?>

</div>

</body>
</html>