<?php
session_start();
include "../../../db_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("location: ../../../");
    exit();
}

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$created_by = $username . '(' . $role . ')';
$term = htmlspecialchars('1st Term');

if (filter_has_var(INPUT_POST, 'btn_save')) {
    $resident_id = $_POST['resident_id'];
    $off_position = htmlspecialchars(ucwords($_POST['off_position']));
    $term_start = $_POST['term_start'];
}


//check if barangay chairman is already taken


$officialQuery = "SELECT COUNT(off_position) AS 'count' FROM official WHERE off_position = :off_position";
$officialStatement = $pdo->prepare($officialQuery);
$officialStatement->bindParam(':off_position', $off_position);
$officialStatement->execute();

while ($official = $officialStatement->fetch(PDO::FETCH_ASSOC)) {
    if ($off_position == "Barangay Chairman" || $off_position === 'Barangay Secretary') {
        if ($official['count'] === 1) {
            $_SESSION['error'] = "{$off_position} is already taken.";
            header("location: ../create-official.php?resident_id=$resident_id");
            exit();
        }
    }
}

$officialInsert = "INSERT INTO `official`( 
    `resident_id`,
    `off_position`,
    `term`,
    `first_term_start`,
    `created_by`              
    )
    VALUES 
    (
    :resident_id,
    :off_position,
    :term,
    :term_start,
    :created_by
)";

$insertStatement = $pdo->prepare($officialInsert);
$insertStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
$insertStatement->bindParam(':off_position', $off_position);
$insertStatement->bindParam(':term', $term);
$insertStatement->bindParam(':term_start', $term_start);
$insertStatement->bindParam(':created_by', $created_by);
$insertStatement->execute();

$chairmanUpdate = "UPDATE `resident` SET `occupation`=:off_position WHERE `resident_id` = :resident_id";
$chairmanStatement3 = $pdo->prepare($chairmanUpdate);
$chairmanStatement3->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
$chairmanStatement3->bindParam(':off_position', $off_position);
$chairmanStatement3->execute();

$_SESSION['success'] = "{$off_position} Created Successfully";
header("location: ../");
