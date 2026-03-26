<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name,email,phone,course,password) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $course, $hashed_password);

    if ($stmt->execute()) {
        $success = "Registered! Now verify OTP.";
    } else {
        $error = "Error!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box {
    background:white;
    padding:30px;
    width:350px;
    border-radius:10px;
}

input,select,button {
    width:100%;
    padding:10px;
    margin:10px 0;
}

button {
    background:#667eea;
    color:white;
    border:none;
}
</style>

</head>
<body>

<div class="box">
<h2>Register</h2>

<?php if(isset($error)) echo $error; ?>
<?php if(isset($success)) echo $success; ?>

<form method="POST">
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>

<input type="text" id="phone" name="phone" placeholder="Phone" required>

<button type="button" onclick="sendOTP()">Send OTP</button>

<input type="text" id="otp" placeholder="Enter OTP">

<button type="button" onclick="verifyOTP()">Verify OTP</button>

<select name="course">
<option>SSC</option>
<option>Banking</option>
</select>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Register</button>
</form>

</div>

<script>
function sendOTP() {
    let phone = document.getElementById("phone").value;

    fetch("send_otp.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "phone=" + phone
    })
    .then(res => res.text())
    .then(data => alert(data));
}

function verifyOTP() {
    let phone = document.getElementById("phone").value;
    let otp = document.getElementById("otp").value;

    fetch("verify_otp.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "phone=" + phone + "&otp=" + otp
    })
    .then(res => res.text())
    .then(data => alert(data));
}
</script>

</body>
</html>