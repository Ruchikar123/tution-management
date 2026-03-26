<?php
include "db.php";

$phone = $_POST['phone'];
$otp = $_POST['otp'];

$stmt = $conn->prepare("SELECT * FROM otp_verification WHERE phone=? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    if ($row['otp'] == $otp) {

        // mark verified
        $conn->query("UPDATE users SET is_verified=1 WHERE phone='$phone'");

        echo "OTP Verified";
    } else {
        echo "Invalid OTP";
    }

} else {
    echo "OTP not found";
}
?>