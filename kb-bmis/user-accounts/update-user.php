<?php
ob_start();
$headerTitle = 'User Profile';
$page = 'User Accounts';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_POST, 'user_id') && filter_has_var(INPUT_POST, 'role')) {

    $santize_user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_var($santize_user_id, FILTER_VALIDATE_INT);
    $postPassword = htmlspecialchars(md5($_POST['password']));
    $role = htmlspecialchars($_POST['role']);
}

$userCheckQuery = "SELECT password FROM user_view WHERE password = :password";
$userCheckStatement = $pdo->prepare($userCheckQuery);
$userCheckStatement->bindParam(':password', $postPassword);
$userCheckStatement->execute();

$userCheckCount = $userCheckStatement->rowCount();
if ($userCheckCount !== 1) {
    $_SESSION['error'] = "Incorrect Password";
    header("location: view-user.php?user_id=$user_id&role=$role");
    exit();
}


$userQuery = "SELECT * FROM user_view WHERE user_id = :user_id AND role = :role";

$userStatement = $pdo->prepare($userQuery);
$userStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$userStatement->bindParam(':role', $role, PDO::PARAM_INT);
$userStatement->execute();

$userCount = $userStatement->rowCount();

if ($userCount === 1) {
    $user = $userStatement->fetch(PDO::FETCH_ASSOC);
?>
    <form id="add_residents" action="controller/update.php" method="POST" enctype="multipart/form-data" data-parsley-validate="">
        <main>
            <div class="content">
                <div class="card">
                    <a href="view-user.php?user_id=<?php echo $user['user_id'] ?>&role=<?php echo $user['role'] ?>" class="button button--md back-btn">
                        <i class='bx bx-left-arrow-circle'></i>
                        Back
                    </a>

                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--viewprofile">
                                <?php if (is_null($user['img_url'])) : ?>
                                    <img src="../residents/images/default-img.svg ?>" alt="">
                                <?php else : ?>
                                    <img src="../residents/images/<?php echo $user["img_url"]; ?>" alt="">
                                <?php endif; ?>
                            </div>

                            <?php if (is_null($user['last_name']) && is_null($user['first_name'])) : ?>
                                <div class="profile__name profile__name--viewprofile">
                                    <?php echo $user['role'] ?>
                                </div>
                            <?php else : ?>
                                <div class="profile__name profile__name--viewprofile">
                                    <?php echo $user['last_name'] ?>,
                                    <?php echo $user['first_name'] ?>
                                    <?php echo $user['mid_name'] ? mb_substr($user['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                    <?php echo $user['suffix'] ?>
                                </div>
                            <?php endif; ?>

                            <br>

                            <div class="profile-info__content viewprofile" style="display: block;">
                                <section class="profile-info__basic-info">

                                    <?php if (!is_null($user['off_position'])) : ?>
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="clerk-position">Position</label>
                                                <div class="input__inner">
                                                    <input disabled name="off_position" type="text" class="input--light300 input-viewprofile" value="<?php echo $user['off_position'] ?> ">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="clerk-role">Role</label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="role" id="clerk-role" class="select select--resident-profile input-viewprofile" required>
                                                        <option hidden value="<?php echo  $user['role'] ?>" selected><?php echo $user['role'] ?></option>
                                                        <?php if ($user['off_position'] !== 'Barangay Clerk') : ?>
                                                            <option value="Barangay Chairman">Barangay Chairman</option>
                                                            <option value="Barangay Secretary">Barangay Secretary</option>
                                                        <?php elseif ($user['off_position'] === 'Barangay Clerk') : ?>
                                                            <option value="Barangay Clerk - Resident Admin">Barangay Clerk - Resident Admin</option>
                                                            <option value="Barangay Clerk - Resident Encoder">Barangay Clerk - Resident Encoder</option>
                                                            <option value="Barangay Clerk - Generate Clearance">Barangay Clerk - Generate Clearance</option>
                                                            <option value="Barangay Clerk - Complaint Admin">Barangay Clerk - Complaint Admin</option>
                                                            <option value="Barangay Clerk - Complaint Encoder">Barangay Clerk - Complaint Encoder</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="clerk-username">Username</label>
                                            <div class="input__inner">
                                                <input name="username" type="text" id="clerk-username" class="input--light300 input-viewprofile" value="<?php echo $user['username'] ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="password">New Password</label>
                                            <div class="input__inner">

                                                <input name="new_pass" type="password" class="input--light300 input-viewprofile" id="password">

                                                <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('password', this)"> </i>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

                <input hidden name="position" type="text" class="input--light300 input-viewprofile" value="<?php echo $user['off_position'] ?>">

                <input hidden name="user_id" type="text" class="input--light300 input-viewprofile" value="<?php echo $user['user_id'] ?>">

                <input hidden name="resident_id" type="text" class="input--light300 input-viewprofile" value="<?php echo $user['resident_id'] ?>">

                <input hidden name="official_id" type="text" class="input--light300 input-viewprofile" value="<?php echo $user['official_id'] ?>">

                <input type="text" name="old_pass" value="<?php echo $user['password'] ?>" class="input--light300 input-viewprofile" hidden>

                <div class="card__footer">
                    <div class="card__footer-content">
                        <div class="card__footer-content--right">
                            <button class="button button--primary button--md" name="btn_update">SAVE</button>
                            <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    </form>

    <?php require "../../includes/modal-cancel.php"; ?>


<?php
}
?>

</body>

</html>