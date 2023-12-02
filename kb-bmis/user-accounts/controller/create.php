<?php
session_start();
include "../../../db_conn.php";

if (filter_has_var(INPUT_POST, 'resident_id') && filter_has_var(INPUT_POST, 'official_id')) {
    $santize_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($santize_resident_id, FILTER_VALIDATE_INT);

    $santize_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($santize_official_id, FILTER_VALIDATE_INT);

    $role = htmlspecialchars($_POST['role']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
}

$insertUser = "INSERT INTO `users`(
                `resident_id`,
                `official_id`,
                `username`, 
                `password`, 
                `role`
                ) 
                VALUES (
                :resident_id,
                :official_id,
                :username,
                :password,
                :role
                )";

$userStatement = $pdo->prepare($insertUser);
$userStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
$userStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
$userStatement->bindParam(':username', $username);
$userStatement->bindParam(':password', $password);
$userStatement->bindParam(':role', $role);
$userStatement->execute();

$_SESSION['success'] = "{$role} Account Created Successfully.";
header("location: ../");
