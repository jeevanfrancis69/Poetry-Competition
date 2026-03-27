<?php
session_start();
header('Content-Type: application/json');
require_once "../connect.php";



$userIn = $_POST['usernamePeserta'] ?? '';
$passIn = $_POST['kataLaluanPeserta'] ?? '';


// DEFINE THE ADMIN
define('ADMIN_USERNAME', 'jeevan');
define('ADMIN_PASSWORD_HASH', '$2y$10$vTMBUvTD5K6Kte3NZRg5fOLc6S4dqhIMPI7yjY80SXDnNmNrQbzHe'); //poetryComp

if ($userIn === ADMIN_USERNAME) {
    if (password_verify($passIn, ADMIN_PASSWORD_HASH)) {
        $_SESSION['username'] = ADMIN_USERNAME;
        $_SESSION['nama']     = 'Jeevan';
        $_SESSION['role']     = 'admin';
        echo json_encode([
            'status' => 'success',
            'url'    => '../html/adminDashboard.php'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
    }
    exit;
}

// ----------------------------------------------------------------
// 1. CHECK STUDENT TABLE
// ----------------------------------------------------------------
$stmt = $con->prepare("SELECT kataLaluanPeserta, namaPeserta FROM user WHERE usernamePeserta = ?");
$stmt->bind_param("s", $userIn);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();
    if (password_verify($passIn, $row['kataLaluanPeserta'])) {
        // Store everything the rest of the site needs about this student
        $_SESSION['username'] = $userIn;
        $_SESSION['nama']     = $row['namaPeserta'];
        $_SESSION['role']     = 'student';
        echo json_encode([
            'status' => 'success',  
            'url'    => '../html/loginindexpeserta.php'  // student dashboard
        ]);
        exit;
    }
}

// ----------------------------------------------------------------
// 2. CHECK JUDGES TABLE
// ----------------------------------------------------------------
$stmtJudge = $con->prepare("
    SELECT judgePassword, judgeName, judgeStatus 
    FROM judges 
    WHERE judgeUsername = ?
");
$stmtJudge->bind_param("s", $userIn);
$stmtJudge->execute();
$resJudge = $stmtJudge->get_result();

if ($resJudge->num_rows === 1) {
    $rowJudge = $resJudge->fetch_assoc();

    if (password_verify($passIn, $rowJudge['judgePassword'])) {

        // Correct password — now check approval status
        if ($rowJudge['judgeStatus'] === 'pending') {
            $_SESSION['username']     = $userIn;
            $_SESSION['nama']         = $rowJudge['judgeName'];
            $_SESSION['role']         = 'judge';
            $_SESSION['judgeStatus']  = 'pending';
            echo json_encode([
                'status' => 'success',
                'url'    => '../html/intro.php'
            ]);
            exit;
        }

        if ($rowJudge['judgeStatus'] === 'rejected') {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Your judge application was not approved. Please contact the administrator.'
            ]);
            exit;
        }

        // judgeStatus === 'approved' — grant access
        $_SESSION['username'] = $userIn;
        $_SESSION['nama']     = $rowJudge['judgeName'];
        $_SESSION['role']     = 'judge';
        $_SESSION['judgeStatus'] = 'approved';
        echo json_encode([
            'status' => 'success',
            'url'    => '../html/judgeDashboard.php'  // judge dashboard
        ]);
        exit;
    }
}

// ----------------------------------------------------------------
// 3. NO MATCH FOUND
// ----------------------------------------------------------------
echo json_encode([
    'status'  => 'error',
    'message' => 'Invalid username or password.'
]);
