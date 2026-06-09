<?php
require_once 'db.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$service = $_POST['service'] ?? '';
$date = $_POST['date'] ?? '';

if ($name && $email && $service && $date) {
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, service, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $service, $date);
    $stmt->execute();
    $stmt->close();
    echo "Booking successful!";
} else {
    echo "Please fill in all fields.";
}

$conn->close();
?>