<?php
// ================================================================
// processEditMarks.php — Updates userMarks for one student
// Called via fetch() from judgeDashboard.js
// ================================================================
require_once '../php/sessionGuard.php';
guardSession('judge'); // Only judges can update marks

header('Content-Type: application/json');
require_once '../connect.php';

// Decode the JSON body sent by fetch()
$data    = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$marks    = $data['marks']    ?? null;

// Validate
if (empty($username) || $marks === null || $marks < 0 || $marks > 100) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data received.']);
    exit;
}

// Update only the marks column for this student
$stmt = $con->prepare("UPDATE user SET userMarks = ? WHERE usernamePeserta = ?");
$stmt->bind_param("ds", $marks, $username);

if ($stmt->execute()) {
    if ($stmt->affected_rows === 0) {
        // Username didn't match any row
        echo json_encode(['status' => 'error', 'message' => 'Student not found.']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Marks updated successfully.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
}
