<?php
// ================================================================
// sessionGuard.php
// ================================================================
// Include this at the TOP of every page that requires a login.
//
// Usage — student-only page:
//   require_once '../php/sessionGuard.php';
//   guardSession('student');
//
// Usage — judge-only page:
//   require_once '../php/sessionGuard.php';
//   guardSession('judge');
//
// Usage — any logged-in user:
//   require_once '../php/sessionGuard.php';
//   guardSession();
// ================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function guardSession($requiredRole = null) {
    // Not logged in at all — send to login page
    if (!isset($_SESSION['role'])) {
        header('Location: ../html/login.php');
        exit;
    }

    // Logged in but wrong role — send to their own dashboard
    if ($requiredRole !== null && $_SESSION['role'] !== $requiredRole) {
        if ($_SESSION['role'] === 'student') {
            header('Location: ../html/loginindexpeserta.php');
        } elseif ($_SESSION['role'] === 'judge') {
            header('Location: ../html/judgeDashboard.php');
        } else {
            header('Location: ../html/login.php');
        }
        exit;
    }
}
