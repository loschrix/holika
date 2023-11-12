<?php
require("../../connect.php");

$reviewId = $_POST['reviewId'];
$reviewId = intval($reviewId);

$stmtR = $connect->prepare("DELETE FROM reviews WHERE ID = ?");
$stmtI = $connect->prepare("DELETE FROM reviews_img WHERE reviews_ID = ?");
$stmtR->bind_param("i", $reviewId);
$stmtI->bind_param("i", $reviewId);
$stmtR->execute();
$stmtI->execute();

if ($stmtR->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmtR->error]);
}

$stmtR->close();
$stmtI->close();
$connect->close();
