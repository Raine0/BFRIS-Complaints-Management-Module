<?php
session_start();
include '../../../db_conn.php';

if (filter_has_var(INPUT_POST, 'submit')) {
    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);

    $clean_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($clean_official_id, FILTER_VALIDATE_INT);

    $date_of_residency = $_POST['date_of_residency'];
    $issued_by = $_SESSION['role'];
}

$jobseekerQuery = "INSERT INTO jobseeker_certificate (
        resident_id,
        official_id,
        date_of_residency,
        issued_by
        
    )
    VALUES(
        :resident_id,
        :official_id,
        :date_of_residency,
        :issued_by
    )";

$jobseekerStatement = $pdo->prepare($jobseekerQuery);
$jobseekerStatement->bindParam(':resident_id', $resident_id);
$jobseekerStatement->bindParam(':official_id', $official_id);
$jobseekerStatement->bindParam(':date_of_residency', $date_of_residency);
$jobseekerStatement->bindParam(':issued_by', $issued_by);
$jobseekerStatement->execute();

$SESSION['success'] = "Jobseeker Certificate Successfully Created";
header('location: ../jobseeker-list.php');
