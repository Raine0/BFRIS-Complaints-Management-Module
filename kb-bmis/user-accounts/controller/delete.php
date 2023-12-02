<?php
session_start();
include "../../../db_conn.php";

if (filter_has_var(INPUT_POST, 'user_id') && filter_has_var(INPUT_POST, 'role')) {

    $santize_user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_var($santize_user_id, FILTER_VALIDATE_INT);

    $postPassword = htmlspecialchars(md5($_POST['password']));
    $role = htmlspecialchars($_POST['role']);
}

$userQuery = "SELECT * FROM users WHERE password = :password";
$userStatement = $pdo->prepare($userQuery);
$userStatement->bindParam(':password', $postPassword);
$userStatement->execute();

$userCount = $userStatement->rowCount();

if ($userCount !== 1) {
    $_SESSION['error'] = "Incorrect Password";
    header("location: ../view-user.php?user_id=$user_id&role=$role");
    exit();
}

// Delete without archive

$deleteuserQuery = "DELETE FROM `users` WHERE user_id = :user_id";
$userdeleteStatement = $pdo->prepare($deleteuserQuery);
$userdeleteStatement->bindParam(':user_id', $user_id);
$userdeleteStatement->execute();

$_SESSION['success'] = "{$role} Account Deleted Successfully";
header("location: ../");
