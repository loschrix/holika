<?php
$connect = mysqli_connect("localhost", "root", "", "holika-holika");

if (!$connect) {
    header("Location: strona.html");
    exit();
}
