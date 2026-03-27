<?php
// ================================================================
// loginindexpeserta.php — Student results page
// ================================================================
require_once '../php/sessionGuard.php';
guardSession('student'); // Redirects to login if not a logged-in student

require_once '../connect.php';

// Fetch this student's full record using the session username
$stmt = $con->prepare("
    SELECT namaPeserta, userMarks 
    FROM user 
    WHERE usernamePeserta = ?
");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

// Fallback if somehow the query returns nothing
$nama   = $row['namaPeserta'] ?? 'Unknown';
$marks  = $row['userMarks']   ?? 0;

// Cap the bar at 100% even if marks exceed 100
$barWidth = min((float)$marks, 100);

// Colour of the bar changes based on score band
if ($barWidth >= 75) {
    $barColour = '#4caf50'; // green  — good
} elseif ($barWidth >= 50) {
    $barColour = '#ff9800'; // orange — average
} else {
    $barColour = '#f44336'; // red    — needs improvement
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Results</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ── Page layout ───────────────────────────────────────── */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .results-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* ── Profile card ──────────────────────────────────────── */
        .profile-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 40px 48px;
            width: 100%;
            max-width: 480px;
            color: white;
            backdrop-filter: blur(6px);
        }

        .profile-card h1 {
            font-size: 1.8rem;
            font-weight: 400;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            padding-bottom: 14px;
            margin-bottom: 28px;
            text-align: center;
        }

        /* ── Info rows ─────────────────────────────────────────── */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 0.95rem;
        }

        .info-row:last-of-type {
            border-bottom: none;
        }

        .info-label {
            color: rgba(255,255,255,0.6);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            font-weight: 500;
        }

        /* ── Marks score (big number) ──────────────────────────── */
        .score-section {
            margin-top: 32px;
            text-align: center;
        }

        .score-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.5);
            margin-bottom: 8px;
        }

        .score-number {
            font-size: 3.5rem;
            font-weight: 300;
            line-height: 1;
            color: <?php echo $barColour; ?>;
            transition: color 0.5s ease;
        }

        .score-number span {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.4);
        }

        /* ── Progress bar ──────────────────────────────────────── */
        .bar-track {
            margin-top: 18px;
            height: 10px;
            background: rgba(255,255,255,0.12);
            border-radius: 99px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            width: 0%;                        /* starts at 0 — animates to actual value */
            background: <?php echo $barColour; ?>;
            border-radius: 99px;
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .bar-caption {
            margin-top: 8px;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.4);
            text-align: right;
        }

        /* ── Marks not released yet notice ────────────────────── */
        .pending-notice {
            margin-top: 24px;
            background: rgba(255,193,7,0.12);
            border: 1px solid rgba(255,193,7,0.4);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.82rem;
            color: #ffe082;
            text-align: center;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li class="active"><a href="../html/loginindexpeserta.php">My Results</a></li>
        <li><a href="../html/intro.php">Home</a></li>
        <li><a href="../html/aboutus.php">About Us</a></li>
        <li><a href="../php/logout.php">Log Out</a></li>
    </ul>
</nav>

<div class="results-wrapper">
    <div class="profile-card">
        <h1>My Results</h1>

        <div class="info-row">
            <span class="info-label"><i class="fa fa-user"></i> Username</span>
            <span class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>

        <div class="info-row">
            <span class="info-label"><i class="fa fa-id-card"></i> Name</span>
            <span class="info-value"><?php echo htmlspecialchars($nama); ?></span>
        </div>

        <div class="score-section">
            <p class="score-label">Your Score</p>

            <?php if ($marks == 0): ?>
                <!-- Marks haven't been entered yet -->
                <div class="pending-notice">
                    <i class="fa fa-clock"></i>
                    Your marks have not been released yet. Check back soon.
                </div>

            <?php else: ?>
                <div class="score-number">
                    <?php echo number_format((float)$marks, 1); ?>
                    <span>/ 100</span>
                </div>

                <div class="bar-track">
                    <div class="bar-fill" id="barFill"></div>
                </div>
                <p class="bar-caption"><?php echo $barWidth; ?>%</p>

                <script>
                    // Trigger the bar animation after the page renders
                    window.addEventListener('load', function () {
                        setTimeout(function () {
                            document.getElementById('barFill').style.width = '<?php echo $barWidth; ?>%';
                        }, 100); // small delay so the CSS transition fires
                    });
                </script>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>
