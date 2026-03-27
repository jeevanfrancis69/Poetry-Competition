// ================================================================
// judgeDashboard.js
// ================================================================

// ── Live search ─────────────────────────────────────────────────
// Filters table rows by student name as the judge types.
// Reads column index 2 (Name column).
function filterTable() {
    const input  = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const rows   = document.querySelectorAll('#studentTable tbody tr');

    rows.forEach(row => {
        const nameCell = row.getElementsByTagName('td')[2]; // Name column
        if (nameCell) {
            const text = nameCell.textContent || nameCell.innerText;
            row.style.display = text.toUpperCase().includes(filter) ? '' : 'none';
        }
    });
}

// ── Modal: open ─────────────────────────────────────────────────
// Reads the data-* attributes off the clicked Edit button and
// populates the modal fields — no need to read from the table DOM.
function openEditModal(btn) {
    const username = btn.dataset.username;
    const nama     = btn.dataset.nama;
    const marks    = btn.dataset.marks;

    document.getElementById('modalTitle').textContent    = 'Enter Marks';
    document.getElementById('modalSubtitle').textContent = nama + ' (' + username + ')';
    document.getElementById('modalUsername').value       = username;
    document.getElementById('marksInput').value          = marks > 0 ? marks : '';

    document.getElementById('editModal').classList.add('active');
    document.getElementById('marksInput').focus();
}

// ── Modal: close ────────────────────────────────────────────────
function closeModal() {
    document.getElementById('editModal').classList.remove('active');
}

// Close if judge clicks the dark overlay (not the modal box itself)
function closeModalOnOverlay(event) {
    if (event.target === document.getElementById('editModal')) {
        closeModal();
    }
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// ── Save marks via fetch ─────────────────────────────────────────
// Sends username + new marks to processEditMarks.php as JSON.
// Updates the badge in the table on success without a page reload.
function saveMarks() {
    const username = document.getElementById('modalUsername').value;
    const marks    = parseFloat(document.getElementById('marksInput').value);

    // Client-side validation
    if (isNaN(marks) || marks < 0 || marks > 100) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid marks',
            text: 'Please enter a number between 0 and 100.'
        });
        return;
    }

    fetch('../php/processEditMarks.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username: username, marks: marks })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: data.message,
                showConfirmButton: false,
                timer: 1200
            }).then(() => {
                closeModal();
                // Update the badge in the table without reloading the page
                updateBadge(username, marks);
            });
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: data.message });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Could not connect to the server.', 'error');
    });
}

// ── Update badge in table after save ───────────────────────────
// Finds the row whose Edit button has the matching username,
// then updates its mark badge colour and value live.
function updateBadge(username, marks) {
    const buttons = document.querySelectorAll('.edit-btn');
    buttons.forEach(btn => {
        if (btn.dataset.username === username) {
            // Update the data attribute so re-opening the modal shows the new value
            btn.dataset.marks = marks;

            // Find the badge in the same row
            const row   = btn.closest('tr');
            const badge = row.querySelector('.mark-badge');

            badge.textContent = marks.toFixed(1);

            // Swap colour class
            badge.classList.remove('mark-none', 'mark-good', 'mark-avg', 'mark-low');
            if (marks >= 75)      badge.classList.add('mark-good');
            else if (marks >= 50) badge.classList.add('mark-avg');
            else                  badge.classList.add('mark-low');
        }
    });
}
