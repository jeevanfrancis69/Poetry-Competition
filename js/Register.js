function toggleFields(role) {
    const extraFields = document.getElementById('extraFields');
    const judgeNotice = document.getElementById('judgeNotice');
    const emailInput  = document.getElementById('emailInput');
    const ageInput    = document.getElementById('ageInput');

    // Swap active highlight on role cards
    document.getElementById('card-peserta').classList.toggle('active', role === 'peserta');
    document.getElementById('card-judge').classList.toggle('active', role === 'judge');

    if (role === 'judge') {
        judgeNotice.style.display = 'block';
    } else {
        judgeNotice.style.display = 'none';
    }

    // Both roles collect email + age (admin needs context for judge approval)
    extraFields.classList.remove('collapsed');
    emailInput.required = true;
    ageInput.required   = true;
}

// Set initial active state on page load
document.getElementById('card-peserta').classList.add('active');

document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Client-side password match check
    const pw  = document.getElementById('passwordField').value;
    const cpw = document.getElementById('confirmPasswordField').value;
    if (pw !== cpw) {
        Swal.fire({
            icon: 'error',
            title: 'Passwords do not match',
            text: 'Please make sure both password fields are the same.',
        });
        return;
    }

    const formData = new FormData(this);

    fetch('../php/processRegisterUser.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Registered!',
                text: data.message,
            }).then(() => {
                window.location.href = '../html/intro.php';
            });

        } else if (data.status === 'pending') {
            // Judge registered but awaiting approval
            Swal.fire({
                icon: 'info',
                title: 'Application Submitted',
                text: data.message,
            }).then(() => {
                window.location.href = '../html/intro.php';
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Something went wrong with the request.', 'error');
    });
});