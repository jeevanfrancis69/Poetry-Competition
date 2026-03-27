<?php
// ================================================================
// Contact.php — Saves contact form submission to contacts table
// Called via fetch() from aboutus.php
// ================================================================
header('Content-Type: application/json');
require_once '../connect.php';

$name    = trim($_POST['Name']     ?? '');
$email   = trim($_POST['Email']    ?? '');
$phone   = trim($_POST['PhoneNum'] ?? '');
$message = trim($_POST['Message']  ?? '');

// Basic validation
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
    exit;
}

$stmt = $con->prepare("
    INSERT INTO contacts (namaPeserta, emelPeserta, phone, message, submitted_at)
    VALUES (?, ?, ?, ?, NOW())
");
$stmt->bind_param("ssss", $name, $email, $phone, $message);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Thank you for reaching out. We will reply within 3 working days.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again.']);
}
