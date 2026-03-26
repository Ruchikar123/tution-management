<?php
include "db.php";

$id = $_GET['id'];

// Get file name
$result = $conn->query("SELECT file_name FROM documents WHERE id=$id");
$row = $result->fetch_assoc();

// Delete file from folder
$file = "uploads/" . $row['file_name'];
if (file_exists($file)) {
    unlink($file);
}

// Delete from DB
$conn->query("DELETE FROM documents WHERE id=$id");

header("Location: documents.php");
?>