<?php

include "../../../db_conn.php";

$clean_resident_archive_id = filter_var($_GET['resident_archive_id'], FILTER_SANITIZE_NUMBER_INT);
$resident_archive_id = filter_var($clean_resident_archive_id, FILTER_VALIDATE_INT);

$residentQuery = "SELECT * FROM resident_archive WHERE `resident_archive_id` = :resident_archive_id";
$residentStatement = $pdo->prepare($residentQuery);
$residentStatement->bindParam(':resident_archive_id', $resident_archive_id);
$residentStatement->execute();

$residentArchive = $residentStatement->fetch(PDO::FETCH_ASSOC);

$fetchImage = $residentArchive["img_url"];

$deletePath = "../../residents/images/" . $fetchImage;
if (unlink($deletePath)) {
    $residentDelete = "DELETE FROM `resident_archive` WHERE `resident_archive_id` = :resident_archive_id";
    $residentdeleteStatement = $pdo->prepare($residentDelete);
    $residentdeleteStatement->bindParam(':resident_archive_id', $residentarchive_id);
    $residentdeleteStatement->execute();

    header("location: ../resident-archive.php");
}
