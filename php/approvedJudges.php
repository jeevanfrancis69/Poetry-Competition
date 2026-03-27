<?php
require_once "../connect.php";

$id = $_GET['id'];

$stmt = $con->prepare("UPDATE judges SET judgeStatus = 'approved' WHERE judgeId = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
?>