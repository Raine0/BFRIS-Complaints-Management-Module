<?php
session_start();
include "db_conn.php";


if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $hashpass = validate(md5($_POST['password']));

    if (empty($username)) {
        header("Location: index.php?error=Username is required.");
        exit();
    } else if (empty($hashpass)) {
        header("Location: index.php?error=Password is required.");
        exit();
    } else {
        $sql = "SELECT * FROM user_view WHERE username=:username AND password=:hashpass";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':hashpass', $hashpass);
        $statement->execute();
        $count = $statement->rowCount();
        if ($count === 1) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if ($user['username'] === $username && $user['password'] === $hashpass) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['resident_id'] = $user['resident_id'];
                $_SESSION['official_id'] = $user['official_id'];
                $_SESSION['role'] = $user['role'];

                if (is_null($user['resident_id']) || is_null($user['official_id'])) {
                    $_SESSION['success'] = "Welcome $user[role]!";
                    header("Location: kb-bmis/dashboard/");
                    exit();
                } else {
                    $sql2 = "SELECT * FROM user_view WHERE resident_id = :resident_id AND official_id = :official_id AND user_id = :user_id";

                    $statement2 = $pdo->prepare($sql2);
                    $statement2->bindParam(':resident_id', $user['resident_id'], PDO::PARAM_INT);
                    $statement2->bindParam(':official_id', $user['official_id'], PDO::PARAM_INT);
                    $statement2->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
                    $statement2->execute();
                    $count = $statement2->rowCount();
                    if ($count === 1) {
                        $user2 = $statement2->fetch(PDO::PARAM_INT);

                        $_SESSION['success'] = "Welcome $user2[off_position] $user2[last_name]!";
                        header("Location: kb-bmis/dashboard/");
                        exit();
                    }
                }
            }
        } else {
            header("Location: index.php?error=Incorrect username or password.");
            exit();
        }
    }
}
