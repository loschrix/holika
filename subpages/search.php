<?php
require("../connect.php");
$searchTerm = $_GET['searchTerm'];
$searchPattern = '%' . $searchTerm . '%';

$stmtP = $connect->prepare("SELECT 'cosmetics' AS source, cosmetics.name, img, price, price_after FROM cosmetics WHERE name LIKE ? LIMIT 6");
$stmtP->bind_param("s", $searchPattern);
$stmtP->execute();
$resultP = $stmtP->get_result();
$dataP = $resultP->fetch_all(MYSQLI_ASSOC);

$stmtT = $connect->prepare("SELECT 'type' AS source, type.name FROM type WHERE name LIKE ?;");
$stmtT->bind_param("s", $searchPattern);
$stmtT->execute();
$resultT = $stmtT->get_result();
$dataT = $resultT->fetch_all(MYSQLI_ASSOC);

$searchResults = array_merge($dataP, $dataT);
echo json_encode($searchResults);
