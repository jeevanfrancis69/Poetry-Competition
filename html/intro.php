<?php
// ================================================================
// intro.php — Public home page
// Everyone can see this page (guests included).
// Session is started only to read the role for the navbar —
// no guardSession() call so access is never blocked.
// ================================================================
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? 'guest';
$nama = $_SESSION['nama'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertandingan Mendeklamasikan Sajak</title>
    <link rel="stylesheet" href="../css/intro.css">
</head>
<body>

<nav>
    <ul>
        <li class="active"><a href="../html/intro.php">Home</a></li>
        <li><a href="../html/aboutus.php">About Us</a></li>
        <?php if ($role === 'student'): ?>
            <li><a href="../html/loginindexpeserta.php">My Results</a></li>
            <li><a href="../php/logout.php">Log Out</a></li>

        <?php elseif ($role === 'judge'): ?>
            <?php if (($_SESSION['judgeStatus'] ?? '') === 'pending'): ?>
                <li><a href = "../php/logout.php">Log Out</a></li>
            <?php else: ?>                  
                <li><a href="../html/judgeDashboard.php">Dashboard</a></li>
                <li><a href="../php/logout.php">Log Out</a></li>
            <?php endif; ?>

        <?php elseif ($role === 'admin'): ?>
            <li><a href="../html/adminDashboard.php">Admin Panel</a></li>
            <li><a href="../php/logout.php">Log Out</a></li>

        <?php else: ?>
            <!-- Guest — not logged in -->
            <li><a href="../html/login.php">Log In</a></li>
        <?php endif; ?>

    </ul>
</nav>

<header>
    <div>
        <h1>Pertandingan Mendeklamasikan Sajak</h1>
        <p>"Speak your truth, you are not voiceless"</p>
        <?php if ($role !== 'guest'): ?>
            <!-- Personalised greeting for logged-in users -->
            <p style="margin-top: 12px; font-size: 0.9em; opacity: 0.6;">
                Welcome back, <?php echo htmlspecialchars($nama); ?>
            </p>
        <?php endif; ?>
        <?php if ($role === 'judge' && ($_SESSION['judgeStatus'] ?? '') === 'pending'): ?>
            <div style="
                max-width: 500px;
                margin: 0 auto 40px;
                background: rgba(255,193,7,0.12);
                border: 1px solid rgba(255,193,7,0.4);
                border-radius: 8px;
                padding: 14px 20px;
                text-align: center;
                color: #ffe082;
                font-family: sans-serif;
                font-size: 0.88rem;
            ">
                ⏳ Welcome, <?php echo htmlspecialchars($nama); ?>. Your judge account is currently
                <strong>pending admin approval</strong>. You'll receive access to the judge
                dashboard once approved.
            </div>
        <?php endif; ?>
    </div>
</header>

<main>
    <ul id="cards">

        <li class="card" id="card_1">
            <div class="card__content">
                <div>
                    <h2>Peraturan dan Tatacara</h2>
                    <p>
                        Pertandingan ini hanya terbuka kepada pelajar Arus Perdana dari sekolah MSAB, English College.
                        Pemenang yang merangkul tempat tertinggi akan bertanding ke peringkat antarabangsa.
                        Tarikh penutup penghantaran deklamasi sajak adalah 31 December 2022.
                    </p>
                </div>
                <figure>
                    <img src="../images/skullpoetrycards.jpg" alt="Poetry rules">
                </figure>
            </div>
        </li>

        <li class="card" id="card_2">
            <div class="card__content">
                <div>
                    <h2>Format</h2>
                    <p>Penyampaian sajak haruslah tidak melebihi 10 minit. Tajuk sajak adalah bebas kepada kreativiti peserta.</p>
                    <p>Sajak mestilah dalam Bahasa Melayu dan dicipta sendiri.</p>
                    <p>Sajak tidak boleh published, self-published, atau dikongsi di media sosial.</p>
                </div>
                <figure>
                    <img src="../images/dare-to-be-great.jpg" alt="Competition format">
                </figure>
            </div>
        </li>

        <li class="card" id="card_3">
            <div class="card__content">
                <div>
                    <h2>Memorable Quotes from Poets</h2>
                    <p>"Poetry is when an emotion has found its thought and the thought has found words." — Robert Frost</p>
                    <p>"A poet is, before anything else, a person who is passionately in love with language." — W.H. Auden</p>
                </div>
                <figure>
                    <img src="../images/download.jpg" alt="Poet quotes">
                </figure>
            </div>
        </li>

        <li class="card" id="card_4">
            <div class="card__content">
                <div>
                    <h2>Tambahan Info</h2>
                    <p>Tarikh penghantaran sajak akan diumumkan secepat mungkin.</p>
                    <p>Pingat dan Sijil akan diberikan kepada semua peserta.</p>
                    <p>Untuk sebarang pertanyaan sila hubungi Jeevan Gabriel Francis, 5 Akas.</p>

                </div>
                <figure>
                    <img src="../images/poetrycards.jpg" alt="Additional info">
                </figure>
            </div>
        </li>

    </ul>
</main>

</body>
</html>
