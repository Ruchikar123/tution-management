<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$docs = $conn->query("SELECT * FROM documents ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>User Documents</title>

<style>
body { font-family: Arial; background: #f1f5f9; padding: 20px; }

.grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    width: 220px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

.card a {
    display: block;
    margin-top: 10px;
    text-decoration: none;
    color: white;
    background: #4f46e5;
    padding: 8px;
    text-align: center;
    border-radius: 5px;
}
</style>
</head>

<body>

<h2>Study Materials</h2>

<div class="grid">

<?php while($row = $docs->fetch_assoc()) { ?>

<div class="card">

    <h4><?= $row['title'] ?></h4>

    <?php
    $file = "uploads/" . $row['file_name'];
    $type = $row['file_type'];

    if (strpos($type, "image") !== false) {
        echo "<img src='$file' width='100%'>";
    } elseif (strpos($type, "video") !== false) {
        echo "<video width='100%' controls><source src='$file'></video>";
    } else {
        echo "<p>📄 PDF/Document</p>";
    }
    ?>

    <a href="<?= $file ?>" download>Download</a>

</div>

<?php } ?>

</div>

</body>
</html>