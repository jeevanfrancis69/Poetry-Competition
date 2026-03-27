<?php

session_start();
require_once "../connect.php";
header('Content-Type: application/json'); // Tell the browser we are sending JSON

$username = $_POST['usernamePeserta'] ?? '';
$nama = $_POST['namaPeserta'] ?? '';
$pass = $_POST['kataLaluanPeserta'] ?? '';
$confPass = $_POST['ComKataLaluanPeserta'] ?? '';
$umur = $_POST['umurPeserta'] ?? '';
$emel = $_POST['emelPeserta'] ?? '';
$role     = $_POST['role'] ?? '';


// 1. Basic Validation
if ($pass !== $confPass) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match!']);
    exit;
}

$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

if ($role === 'peserta'){
    
    //Check if username exists (Prepared Statement)
    $stmt = $con->prepare("SELECT usernamePeserta FROM user WHERE usernamePeserta = ?");
    $stmt->bind_param("s", $username); // "s" means string
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
        exit;
    } 

    $insert = $con->prepare("INSERT INTO user (usernamePeserta, namaPeserta, kataLaluanPeserta, umurPeserta, emelPeserta) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("sssis", $username, $nama, $hashedPassword, $umur, $emel);
    if ($insert->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}


elseif ($role === 'judge') {

    // Check if username exists
    $stmt = $con->prepare("SELECT judgeUsername FROM judges WHERE judgeUsername = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
        exit;
    }

    $insert = $con->prepare("
        INSERT INTO judges (judgeName, judgeUsername, judgePassword, judgeEmail, judgeAge)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insert->bind_param("ssssi", $nama, $username, $hashedPassword, $emel, $umur);

    if ($insert->execute()) {
        echo json_encode([
            'status' => 'pending',
            'message' => 'Your judge account is pending admin approval.'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
}
else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid role specified.']);
}

?>