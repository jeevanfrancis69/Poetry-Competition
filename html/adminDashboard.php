<?php
// ================================================================
// adminDashboard.php — Admin panel for judge approvals
// ================================================================
require_once '../php/sessionGuard.php';
guardSession('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ── Variables ───────────────────────────────────────── */
        :root {
            --bg-dark:    #1a1008;
            --bg-mid:     #2a1a08;
            --orange:     #c8711a;
            --orange-dim: rgba(200, 113, 26, 0.18);
            --gold:       #e8a84a;
            --text:       #f0e6d3;
            --text-dim:   rgba(240, 230, 211, 0.5);
            --border:     rgba(200, 113, 26, 0.25);
        }

        /* ── Reset ───────────────────────────────────────────── */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Georgia, serif;
            background-color: var(--bg-dark);
            /* Warm dark gradient — no background image dependency */
            background-image: radial-gradient(ellipse at top left, #2e1a06 0%, #1a1008 60%);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Nav ─────────────────────────────────────────────── */
        nav {
            border-bottom: 1px solid var(--border);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            font-size: 1rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.8;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 6px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--text-dim);
            padding: 5px 16px;
            border: 1px solid transparent;
            font-size: 0.88rem;
            letter-spacing: 0.04em;
            transition: color 0.3s, border-color 0.3s;
            font-family: sans-serif;
        }

        nav ul li a:hover,
        nav ul li.active a {
            color: var(--text);
            border-color: var(--border);
        }

        /* ── Page wrapper ────────────────────────────────────── */
        .page {
            max-width: 900px;
            margin: 0 auto;
            padding: 50px 24px 80px;
        }

        /* ── Page title ──────────────────────────────────────── */
        .page-title {
            font-size: 2rem;
            font-weight: normal;
            color: var(--gold);
            border-bottom: 1px solid var(--border);
            padding-bottom: 16px;
            margin-bottom: 36px;
            letter-spacing: 0.04em;
        }

        /* ── Tab buttons ─────────────────────────────────────── */
        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 28px;
        }

        .tab-btn {
            background: none;
            border: 1px solid var(--border);
            color: var(--text-dim);
            padding: 7px 20px;
            cursor: pointer;
            font-family: sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.04em;
            transition: all 0.25s ease;
            border-radius: 4px;
        }

        .tab-btn:hover { color: var(--text); border-color: var(--orange); }

        .tab-btn.active {
            background: var(--orange-dim);
            border-color: var(--orange);
            color: var(--gold);
        }

        /* ── Table ───────────────────────────────────────────── */
        .table-wrap {
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            font-size: 0.9rem;
        }

        thead tr { background: var(--orange-dim); }

        th {
            padding: 13px 16px;
            text-align: left;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gold);
            font-weight: normal;
        }

        td {
            padding: 13px 16px;
            border-top: 1px solid var(--border);
            color: var(--text);
            vertical-align: middle;
        }

        tbody tr:hover { background: rgba(200, 113, 26, 0.06); }

        /* ── Action buttons ──────────────────────────────────── */
        .btn-approve, .btn-reject {
            border: none;
            padding: 6px 16px;
            cursor: pointer;
            font-size: 0.8rem;
            border-radius: 4px;
            font-family: sans-serif;
            letter-spacing: 0.04em;
            transition: opacity 0.2s ease;
            margin-right: 6px;
        }

        .btn-approve {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid rgba(76, 175, 80, 0.4);
            color: #81c784;
        }

        .btn-reject {
            background: rgba(244, 67, 54, 0.15);
            border: 1px solid rgba(244, 67, 54, 0.35);
            color: #e57373;
        }

        .btn-approve:hover, .btn-reject:hover { opacity: 0.75; }

        /* ── Empty state ─────────────────────────────────────── */
        .empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-dim);
            font-family: sans-serif;
            font-size: 0.9rem;
        }

        .empty i { font-size: 2rem; margin-bottom: 12px; display: block; opacity: 0.4; }
    </style>
</head>
<body>

<nav>
    <span class="nav-brand">Pertandingan Mendeklamasikan Sajak</span>
    <ul>
        <li class="active"><a href="../html/adminDashboard.php">Admin Panel</a></li>
        <li><a href="../html/intro.php">Home</a></li>
        <li><a href="../html/aboutus.php">About Us</a></li>
        <li><a href="../php/logout.php">Log Out</a></li>
    </ul>
</nav>

<div class="page">
    <h1 class="page-title">Admin Panel</h1>

    <!-- Tabs to switch between pending and approved -->
    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('pending', this)">
            <i class="fa fa-clock"></i> Pending
        </button>
        <button class="tab-btn" onclick="showTab('approved', this)">
            <i class="fa fa-check"></i> Approved
        </button>
        <button class="tab-btn" onclick="showTab('rejected', this)">
            <i class="fa fa-times"></i> Rejected
        </button>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="judgeTable">
                <tr><td colspan="5" class="empty">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
let currentTab = 'pending';

// ── Load judges by status ────────────────────────────────────────
function loadJudges(status) {
    const table = document.getElementById('judgeTable');
    table.innerHTML = `<tr><td colspan="5" class="empty">
        <i class="fa fa-spinner fa-spin"></i> Loading...
    </td></tr>`;

    fetch(`../php/getJudges.php?status=${status}`)
    .then(res => res.json())
    .then(data => {
        if (data.length === 0) {
            table.innerHTML = `<tr><td colspan="5" class="empty">
                <i class="fa fa-inbox"></i>
                No ${status} judges found.
            </td></tr>`;
            return;
        }

        table.innerHTML = '';
        data.forEach(judge => {
            const row = document.createElement('tr');
            row.id = `judge-${judge.judgeId}`;

            // Only show action buttons for pending judges
            const actions = status === 'pending'
                ? `<button class="btn-approve" onclick="updateJudge(${judge.judgeId}, 'approved')">
                       <i class="fa fa-check"></i> Approve
                   </button>
                   <button class="btn-reject" onclick="updateJudge(${judge.judgeId}, 'rejected')">
                       <i class="fa fa-times"></i> Reject
                   </button>`
                : `<span style="color:var(--text-dim); font-size:0.8rem;">${status}</span>`;

            row.innerHTML = `
                <td>${escHtml(judge.judgeName)}</td>
                <td>${escHtml(judge.judgeUsername)}</td>
                <td>${escHtml(judge.judgeEmail)}</td>
                <td>${escHtml(String(judge.judgeAge))}</td>
                <td>${actions}</td>
            `;
            table.appendChild(row);
        });
    })
    .catch(() => {
        table.innerHTML = `<tr><td colspan="5" class="empty">
            <i class="fa fa-triangle-exclamation"></i> Could not load data.
        </td></tr>`;
    });
}

// ── Approve or reject ────────────────────────────────────────────
function updateJudge(id, newStatus) {
    const label = newStatus === 'approved' ? 'Approve' : 'Reject';

    Swal.fire({
        title: `${label} this judge?`,
        icon: newStatus === 'approved' ? 'question' : 'warning',
        showCancelButton: true,
        confirmButtonText: label,
        background: '#2a1a08',
        color: '#f0e6d3',
        confirmButtonColor: newStatus === 'approved' ? '#4caf50' : '#f44336',
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch('../php/updateJudgeStatus.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Done!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1200,
                    background: '#2a1a08',
                    color: '#f0e6d3',
                }).then(() => loadJudges(currentTab));
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message });
            }
        });
    });
}

// ── Tab switching ────────────────────────────────────────────────
function showTab(status, btn) {
    currentTab = status;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    loadJudges(status);
}

// ── Escape HTML to prevent XSS from DB values ───────────────────
function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// Load pending on first visit
loadJudges('pending');
</script>

</body>
</html>
