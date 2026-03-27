<?php
// ================================================================
// updateJudgeStatus.php — Approve or reject a judge
// Called by adminDashboard.php via fetch() with JSON body
// ================================================================
require_once '../php/sessionGuard.php';
guardSession('admin');

header('Content-Type: application/json');
require_once '../connect.php';

$data   = json_decode(file_get_contents('php://input'), true);
$id     = (int)($data['id']     ?? 0);
$status = $data['status'] ?? '';

// Whitelist — only these two transitions are allowed
if ($id <= 0 || !in_array($status, ['approved', 'rejected'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$stmt = $con->prepare("UPDATE judges SET judgeStatus = ? WHERE judgeId = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    $label = $status === 'approved' ? 'approved' : 'rejected';
    echo json_encode(['status' => 'success', 'message' => "Judge has been {$label}."]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Could not update. Judge may not exist.']);
}
