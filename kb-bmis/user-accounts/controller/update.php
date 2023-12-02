<?php
session_start();
include "../../../db_conn.php";

if (filter_has_var(INPUT_POST, 'btn_update')) {
    $clean_user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_var($clean_user_id, FILTER_VALIDATE_INT);
    $username = htmlspecialchars($_POST['username']);
    $role = htmlspecialchars(ucwords($_POST['role']));

    if (!empty($_POST['new_pass'])) {
        $new_pass = htmlspecialchars($_POST['new_pass']);
        $user_new_hashpass = md5($new_pass);

        $updateUser = "UPDATE `users` SET
            `username` = :username,
            `password` = :hashpass,
            `role` =  :role
            WHERE `user_id` = :user_id
        ";

        $userupdateStatement = $pdo->prepare($updateUser);
        $userupdateStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $userupdateStatement->bindParam(':username', $username);
        $userupdateStatement->bindParam(':hashpass', $user_new_hashpass);
        $userupdateStatement->bindParam(':role', $role);

        $userupdateStatement->execute();

        $_SESSION['success'] = "{$role} Account Updated Successfully.";
        header("location: ../");
    } else {
        $old_pass = htmlspecialchars($_POST['old_pass']);
        $updateUser2 = "UPDATE `users` SET
            `username` = :username,
            `password` = :password,
            `role` =  :role
            WHERE `user_id` = :user_id
        ";

        $userStatement2 = $pdo->prepare($updateUser2);
        $userStatement2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $userStatement2->bindParam(':username', $username);
        $userStatement2->bindParam(':password', $old_pass);
        $userStatement2->bindParam(':role', $role);

        $userStatement2->execute();

        $_SESSION['success'] = "{$role} Account Updated Successfully.";
        header("location: ../");
    }
}
