<?php
session_start();
include "db.php";

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['upload']) && isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

    $title = $_POST['title'];

    $file = $_FILES['file'];

    $fileName = time() . "_" . $file['name'];
    $fileTmp = $file['tmp_name'];

    // 🔐 VALIDATION
    $allowed = ['pdf','jpg','jpeg','png','mp4'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        die("Invalid file type");
    }

    // ✅ Upload
    move_uploaded_file($fileTmp, "uploads/" . $fileName);

    // Save to DB
    $stmt = $conn->prepare("INSERT INTO documents (title, file_name, file_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $fileName, $file['type']);
    $stmt->execute();

    echo "<script>alert('Uploaded Successfully');</script>";
}

// Fetch documents
$docs = $conn->query("SELECT * FROM documents ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Documents</title>

<style>
body { font-family: Arial; background: #f1f5f9; padding: 20px; }

.container { max-width: 800px; margin: auto; }

.box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

input, button {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
}

button {
    background: #4f46e5;
    color: white;
    border: none;
}

.doc {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
</style>
</head>

<body>

<div class="container">

<div class="box">
<h3>Upload Document</h3>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Document Title" required>
    <input type="file" name="file" required>
    <button name="upload">Upload</button>
</form>
</div>

<div class="box">
<h3>Uploaded Documents</h3>

<?php while($row = $docs->fetch_assoc()) { ?>
<div class="doc">

    <strong><?= $row['title'] ?></strong><br>
    <?= $row['file_name'] ?><br><br>

    <!-- 🔗 ADD LINKS HERE -->
    <a href="edit_document.php?id=<?= $row['id'] ?>">✏ Edit</a> |
    
    <a href="delete_document.php?id=<?= $row['id'] ?>" 
       onclick="return confirm('Delete this document?')">
       ❌ Delete
    </a>

</div>
<?php } ?>

</div>

</div>

</body>
</html>