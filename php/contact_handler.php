<?php

session_start();
include '../connect.php';

//Only run this code if the form was actually submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $name    = htmlspecialchars(trim($_POST['Name']));
    $email   = htmlspecialchars(trim($_POST['Email']));
    $phone   = htmlspecialchars(trim($_POST['PhoneNum']));
    $message = htmlspecialchars(trim($_POST['Message']));


    if (empty($name) || empty($email) || empty($message)) {
        header("Location: ../html/aboutus.html?status=error");
        exit();
    }

    //Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../html/aboutus.html?status=invalid_email");
        exit();
    }

    //Insert into database using a prepared statement
    
    $stmt = $conn->prepare("INSERT INTO contacts (namaPeserta, emelPeserta, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);
    // "ssss" means all 4 values are strings (s = string, i = integer)

    if ($stmt->execute()) {
        $_SESSION['success'] = "Message sent! We will reply within 3 working days.";
        header("Location: ../html/aboutus.php");
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: ../html/aboutus.php");
    }

    $stmt->close();
    $conn->close();

} else {
    // Someone tried to access this file directly without submitting the form
    header("Location: ../html/aboutus.html");
}
exit();
?>
