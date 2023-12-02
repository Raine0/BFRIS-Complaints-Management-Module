<?php
session_start();
include "../../../db_conn.php";

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$restored_by = $username . '(' . $role . ')';

$date_restored = date('Y-m-d H:i:s');

if (filter_has_var(INPUT_POST, 'official_archive_id')) {
    $sanitize_archive_id = filter_var($_POST['official_archive_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_archive_id = filter_var($sanitize_archive_id, FILTER_VALIDATE_INT);

    $postPassword = htmlspecialchars(md5($_POST['password']));
}


$userQuery = "SELECT * from users WHERE password = :password";
$userStatement = $pdo->prepare($userQuery);
$userStatement->bindParam(':password', $postPassword);
$userStatement->execute();

$userCount = $userStatement->rowCount();

if ($userCount !== 1) {
    $_SESSION['error'] = 'Incorrect Password';
    header("location: ../view-official.php?official_archive_id=$official_archive_id");
    exit();
}

$officialArchive = "SELECT * FROM `official_archive` WHERE `official_archive_id` = :official_archive_id";
$officialStatement = $pdo->prepare($officialArchive);
$officialStatement->bindParam(':official_archive_id', $official_archive_id);
$officialStatement->execute();

$official = $officialStatement->fetch(PDO::FETCH_ASSOC);

$residentArchive = "SELECT * FROM resident_archive WHERE resident_id = :resident_id";
$residentStatement = $pdo->prepare($residentArchive);
$residentStatement->bindParam(':resident_id', $official['resident_id']);
$residentStatement->execute();

$residentCount = $residentStatement->rowCount();


if ($residentCount === 1) {
    $_SESSION['error'] = "Cannot restore {$row['off_position']} profile. Resident profile exist in resident archive.";
    header("location: ../view-official.php?official_archive_id='$official_archive_id'");
} else {

    $residentInsert = "INSERT INTO `official` (
        `official_id`,
        `resident_id`,
        `off_position`,
        `term`,
        `first_term_start`,
        `first_term_end`,
        `second_term_start`,
        `second_term_end`,
        `third_term_start`,
        `third_term_end`,
        `created_by`,
        `date_created`,
        `updated_by`,
        `date_updated`,
        `restored_by`,
        `date_restored`
        )
        VALUES (
        :official_id,
        :resident_id,
        :off_position,
        :term,
        :first_term_start,
        :first_term_end,
        :second_term_start,
        :second_term_end,
        :third_term_start,
        :third_term_end,
        :created_by,
        :date_created,
        :updated_by,
        :date_updated,
        :restored_by,
        :date_restored
        )
    ";

    $residentinsertStatement = $pdo->prepare($residentInsert);
    $residentinsertStatement->bindParam(':official_id', $official['official_id']);
    $residentinsertStatement->bindParam(':resident_id', $official['resident_id']);
    $residentinsertStatement->bindParam(':off_position', $official['off_position']);
    $residentinsertStatement->bindParam(':term', $official['term']);
    $residentinsertStatement->bindParam(':first_term_start', $official['first_term_start']);
    $residentinsertStatement->bindParam(':first_term_end', $official['first_term_end']);
    $residentinsertStatement->bindParam(':second_term_start', $official['second_term_start']);
    $residentinsertStatement->bindParam(':second_term_end', $official['second_term_end']);
    $residentinsertStatement->bindParam(':third_term_start', $official['third_term_start']);
    $residentinsertStatement->bindParam(':third_term_end', $official['third_term_end']);
    $residentinsertStatement->bindParam(':created_by', $official['created_by']);
    $residentinsertStatement->bindParam(':date_created', $official['date_created']);
    $residentinsertStatement->bindParam(':updated_by', $official['updated_by']);
    $residentinsertStatement->bindParam(':date_updated', $official['date_updated']);
    $residentinsertStatement->bindParam(':restored_by', $official['restored_by']);
    $residentinsertStatement->bindParam(':date_restored', $official['date_restored']);
    $residentinsertStatement->execute();


    $residentUpdate = "UPDATE `resident` SET `occupation` = :off_position WHERE `resident_id` = :resident_id";
    $residentupdateStatement = $pdo->prepare($residentUpdate);
    $residentupdateStatement->bindParam(':resident_id', $official['resident_id'], PDO::PARAM_INT);
    $residentupdateStatement->bindParam(':off_position', $official['off_position']);
    $residentupdateStatement->execute();


    $officialDelete = "DELETE FROM `official_archive` WHERE `official_archive_id` = :official_archive_id";
    $officialdeleteStatement = $pdo->prepare($officialDelete);
    $officialdeleteStatement->bindParam(':official_archive_id', $official_archive_id, PDO::PARAM_INT);
    $officialdeleteStatement->execute();

    $_SESSION['success'] = "{$official['off_position']} Profile Restored Successfully";
    header('location:../official-archive.php');
}
