<?php
// ================================================================
// getJudges.php — Returns judges filtered by status
// Called by adminDashboard.php via fetch()
// ================================================================
require_once '../php/sessionGuard.php';
guardSession('admin');

header('Content-Type: application/json');
require_once '../connect.php';

$status = $_GET['status'] ?? 'pending';

// Whitelist the status value — never trust user input directly
$allowed = ['pending', 'approved', 'rejected'];
if (!in_array($status, $allowed)) {
    echo json_encode([]);
    exit;
}

$stmt = $con->prepare("
    SELECT judgeId, judgeName, judgeUsername, judgeEmail, judgeAge
    FROM judges
    WHERE judgeStatus = ?
    ORDER BY judgeName ASC
");
$stmt->bind_param("s", $status);
$stmt->execute();
$result = $stmt->get_result();

$judges = [];
while ($row = $result->fetch_assoc()) {
    $judges[] = $row;
}

echo json_encode($judges);
