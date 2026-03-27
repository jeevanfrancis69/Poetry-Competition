<?php
// ================================================================
// judgeDashboard.php — Judge dashboard: student list + marks entry
// ================================================================
require_once '../php/sessionGuard.php';
guardSession('judge'); // Redirects anyone who isn't a logged-in judge

require_once '../connect.php';

// Fetch all students ordered alphabetically by name
// NOTE: never SELECT * — only pull what you actually display
$stmt = $con->prepare("
    SELECT usernamePeserta, namaPeserta, userMarks
    FROM user
    ORDER BY namaPeserta ASC
");
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Dashboard</title>
    <link rel="stylesheet" href="../css/judgeDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav>
    <ul>
        <li class="active"><a href="../html/judgeDashboard.php">Dashboard</a></li>
        <li><a href="../html/intro.php">Home</a></li>
        <li><a href="../html/aboutus.php">About Us</a></li>
        <li><a href="../php/logout.php">Log Out</a></li>
    </ul>
</nav>

<div class="dashboard-wrapper">

    <div class="dashboard-header">
        <div>
            <h1>Student List</h1>
            <p class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['nama']); ?></p>
        </div>
        <!-- Live search — filters table rows in JS, no page reload -->
        <div class="search-box">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()">
        </div>
    </div>

    <?php if (count($students) === 0): ?>
        <p class="no-results">No students registered yet.</p>

    <?php else: ?>
        <div class="table-wrapper">
            <table id="studentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Current Marks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $i => $student): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo htmlspecialchars($student['usernamePeserta']); ?></td>
                            <td><?php echo htmlspecialchars($student['namaPeserta']); ?></td>
                            <td>
                                <!-- Colour-coded mark badge -->
                                <span class="mark-badge <?php
                                    $m = (float)$student['userMarks'];
                                    if ($m === 0.0)      echo 'mark-none';
                                    elseif ($m >= 75)    echo 'mark-good';
                                    elseif ($m >= 50)    echo 'mark-avg';
                                    else                 echo 'mark-low';
                                ?>">
                                    <?php echo $m === 0.0 ? '—' : number_format($m, 1); ?>
                                </span>
                            </td>
                            <td>
                                <!-- Pass username + current mark to the modal via data attributes -->
                                <button class="edit-btn"
                                        data-username="<?php echo htmlspecialchars($student['usernamePeserta']); ?>"
                                        data-nama="<?php echo htmlspecialchars($student['namaPeserta']); ?>"
                                        data-marks="<?php echo $student['userMarks']; ?>"
                                        onclick="openEditModal(this)">
                                    <i class="fa fa-pen"></i> Enter Marks
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<!-- ── Edit Marks Modal ─────────────────────────────────────── -->
<div id="editModal" class="modal-overlay" onclick="closeModalOnOverlay(event)">
    <div class="modal-box">
        <h2 id="modalTitle">Enter Marks</h2>
        <p id="modalSubtitle" class="modal-subtitle"></p>

        <label for="marksInput">Marks (0 – 100)</label>
        <input type="number" id="marksInput" min="0" max="100" step="0.1" placeholder="e.g. 87.5">

        <!-- Hidden field carries the username to JS -->
        <input type="hidden" id="modalUsername">

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <button class="btn-save" onclick="saveMarks()">
                <i class="fa fa-floppy-disk"></i> Save
            </button>
        </div>
    </div>
</div>

<script src="../js/judgeDashboard.js"></script>
</body>
</html>
