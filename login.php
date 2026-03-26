<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
           $_SESSION['user_id'] = $row['id'];   // ✅ ADD THIS
           $_SESSION['user'] = $row['name'];    // optional (for display)
           $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4facfe;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #00c6ff;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
        <a href="index.html" class="back-btn">← Back</a>
        
    </form>
</div>

</body>
</html>