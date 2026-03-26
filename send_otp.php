<?php
include "db.php";

$phone = $_POST['phone'];
$otp = rand(100000, 999999);

// Save OTP
$stmt = $conn->prepare("INSERT INTO otp_verification (phone, otp) VALUES (?, ?)");
$stmt->bind_param("ss", $phone, $otp);
$stmt->execute();

// 🔥 Fast2SMS API
$apiKey = "YOUR_API_KEY";

$message = "Your OTP is $otp";

$data = [
    "sender_id" => "FSTSMS",
    "message" => $message,
    "language" => "english",
    "route" => "q",
    "numbers" => $phone
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "authorization: $apiKey",
        "content-type: application/json"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

echo "OTP Sent Successfully!";
?>