# Pertandingan Mendeklamasikan Sajak

A web-based poetry recitation competition management system built with PHP and MySQL. The system handles student and judge registration, mark entry, result viewing, and admin approval of judges.

---

## Features

- Student registration and login
- Judge registration with pending approval flow
- Admin panel to approve or reject judge applications
- Students can view their own competition results
- Judges can enter and update marks per student
- Contact form with messages saved to the database
- Role-based navigation — each role sees only what they need

---

## Tech Stack

| Layer      | Technology |
|------------|-----------|
| Frontend   | HTML, CSS, JavaScript |
| UI Libraries | SweetAlert2, Animate.css, Font Awesome 6 |
| Backend    | PHP |
| Database   | MySQL |
| Server     | Apache (LAMP stack via WSL2) |

---

## Project Structure

```
kerja kursus/
├── html/                   → All page files (.php)
│   ├── intro.php           → Public home page (role-based navbar)
│   ├── login.php           → Login page (all roles)
│   ├── registeruser.php    → Registration (student + judge)
│   ├── aboutus.php         → Contact form
│   ├── loginindexpeserta.php → Student results dashboard
│   ├── judgeDashboard.php  → Judge marks entry
│   └── adminDashboard.php  → Admin judge approval panel
│
├── php/                    → Backend processing files
│   ├── processLogin.php    → Handles login for all roles
│   ├── processRegisterUser.php → Handles registration
│   ├── processEditMarks.php → Updates student marks
│   ├── Contact.php         → Saves contact form to DB
│   ├── getJudges.php       → Returns judges by status (JSON)
│   ├── updateJudgeStatus.php → Approve/reject a judge
│   ├── sessionGuard.php    → Reusable session/role guard
│   └── logout.php          → Destroys session, redirects to login
│
├── js/                     → JavaScript files
│   ├── Register.js         → Registration form logic
│   └── judgeDashboard.js   → Live search, modal, mark saving
│
├── css/                    → Stylesheets
│   ├── login.css           → Login, register shared styles
│   ├── intro.css           → Home page + scrolling cards
│   ├── about_us.css        → Contact form styles
│   └── judgeDashboard.css  → Judge dashboard styles
│
├── images/                 → Background and card images
├── connect.php             → DB connection — NOT tracked in Git
└── .gitignore
```

---

## Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/kerja-kursus.git
cd kerja-kursus
```

### 2. Place in your server root

```bash
# For LAMP on WSL2
cp -r . /var/www/html/kerja\ kursus/
```

### 3. Create the database

Open phpMyAdmin and create a database called `dbsajak`, then run the following SQL:

```sql
CREATE TABLE user (
    usernamePeserta VARCHAR(50)  NOT NULL PRIMARY KEY,
    namaPeserta     VARCHAR(50)  NOT NULL,
    kataLaluanPeserta VARCHAR(255) NOT NULL,
    umurPeserta     INT          NOT NULL,
    emelPeserta     VARCHAR(100) NOT NULL,
    userMarks       DECIMAL(5,2) DEFAULT 0
);

CREATE TABLE judges (
    judgeId       INT AUTO_INCREMENT PRIMARY KEY,
    judgeName     VARCHAR(50)  NOT NULL,
    judgeUsername VARCHAR(50)  NOT NULL UNIQUE,
    judgePassword VARCHAR(255) NOT NULL,
    judgeEmail    VARCHAR(100) NOT NULL,
    judgeAge      INT          NOT NULL,
    judgeStatus   ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'
);

CREATE TABLE contacts (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    namaPeserta  VARCHAR(255) NOT NULL,
    emelPeserta  VARCHAR(255) NOT NULL,
    phone        VARCHAR(20)  DEFAULT NULL,
    message      TEXT         NOT NULL,
    submitted_at DATETIME     DEFAULT NULL
);
```

### 4. Create connect.php

This file is excluded from Git. Create it manually in the project root:

```php
<?php
$con = new mysqli('localhost', 'root', '', 'dbsajak');
if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}
?>
```

### 5. Set up the admin account

In `php/processLogin.php`, find the admin block and replace the placeholders:

```php
define('ADMIN_USERNAME', 'your_username');
define('ADMIN_HASH',     'your_password_hash');
```

To generate your hash, temporarily add this to any PHP file on your server, load it, copy the output, then delete it:

```php
<?php echo password_hash('yourActualPassword', PASSWORD_DEFAULT); ?>
```

### 6. Start Apache and MySQL

```bash
sudo service apache2 start
sudo service mysql start
```

### 7. Visit the site

```
http://localhost/kerja%20kursus/html/intro.php
```

---

## Roles and Access

| Role    | Access |
|---------|--------|
| Guest   | Home, About Us, Log In, Register |
| Student | + My Results (own marks only) |
| Judge (pending) | Home and About Us only — dashboard locked until approved |
| Judge (approved) | + Judge Dashboard (enter/edit student marks) |
| Admin   | + Admin Panel (approve or reject judge applications) |

---

## Notes

- `connect.php` is excluded from Git via `.gitignore` — create it manually on each machine
- Admin credentials are hardcoded in `php/processLogin.php` — no admin table in the database
- All passwords are hashed using PHP `password_hash()` with `PASSWORD_DEFAULT`
- All database queries use prepared statements to prevent SQL injection
- Zone.Identifier files (Windows metadata) are excluded via `.gitignore`
