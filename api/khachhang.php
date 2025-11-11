<?php
require_once("db.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $res = $conn->query("SELECT * FROM khachhang");
  echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}
?>
