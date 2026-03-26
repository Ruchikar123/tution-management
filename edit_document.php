<?php
include "db.php";

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM documents WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {

    $title = $_POST['title'];

    // If new file uploaded
    if ($_FILES['file']['name'] != "") {

        $newFile = time() . "_" . $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];

        move_uploaded_file($tmp, "uploads/" . $newFile);

        // delete old file
        unlink("uploads/" . $data['file_name']);

        $conn->query("UPDATE documents SET title='$title', file_name='$newFile' WHERE id=$id");

    } else {
        // only update title
        $conn->query("UPDATE documents SET title='$title' WHERE id=$id");
    }

    header("Location: documents.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Document</title>

<style>
body {
    font-family: Arial;
    background: #f1f5f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.box {
    background: white;
    padding: 30px;
    border-radius: 10px;
    width: 350px;
}

input, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}

button {
    background: #4f46e5;
    color: white;
    border: none;
}
</style>
</head>

<body>

<div class="box">
<h3>Edit Document</h3>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= $data['title'] ?>" required>

    <p>Current File: <?= $data['file_name'] ?></p>

    <input type="file" name="file">

    <button name="update">Update</button>
</form>
</div>

</body>
</html>