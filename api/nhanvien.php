<?php
require_once("db.php");
header('Content-Type: application/json');

$res = $conn->query("SELECT * FROM nhan_vien");
echo json_encode($res->fetch_all(MYSQLI_ASSOC));
?>
