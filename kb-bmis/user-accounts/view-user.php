<?php

$headerTitle = 'User Profile';
$page = 'User Accounts';
require_once "../../includes/header.php";
require "../../includes/preloader.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../");
  exit();
}
$user_role = $_SESSION['role'];


if (filter_has_var(INPUT_GET, 'user_id') || filter_has_var(INPUT_GET, 'role')) {

  $santize_user_id = filter_var($_GET['user_id'], FILTER_SANITIZE_NUMBER_INT);
  $user_id = filter_var($santize_user_id, FILTER_VALIDATE_INT);

  $role = htmlspecialchars($_GET['role']);
}


?>

<main>
  <div class="content">
    <div class="card">
      <?php
      $userQuery = "SELECT * FROM user_view WHERE user_id = :user_id AND role = :role";

      $userStatement = $pdo->prepare($userQuery);
      $userStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $userStatement->bindParam(':role', $role, PDO::PARAM_INT);
      $userStatement->execute();

      $userCount = $userStatement->rowCount();
      if ($userCount === 1) {
        $user = $userStatement->fetch(PDO::FETCH_ASSOC);

      ?>

        <?php if ($user_role != 'Administrator') { ?>
          <a href="../dashboard/" class="button button--md back-btn">
            <i class='bx bx-left-arrow-circle'></i>
            Back
          </a>
        <?php } ?>

        <?php if ($user_role == 'Administrator') { ?>
          <a href="./" class="button button--md back-btn">
            <i class='bx bx-left-arrow-circle'></i>
            Back
          </a>
        <?php } ?>

        <div class="card__body">
          <div class="card__body-content">
            <div class="profile__img profile__img--viewprofile">
              <?php if (is_null($user['img_url'])) : ?>
                <img src="../residents/images/default-img.svg" alt="">
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

            <div class="row">
              <?php if ($user_role == "Administrator") { ?>
                <a class="button button--primary button--sm modal-trigger" data-modal-id="modal-edituser-<?php echo $user['user_id'] ?>">
                  <i class='bx bxs-edit' data-modal-id="modal-edituser-<?php echo $user['user_id'] ?>"></i>
                  Edit Profile
                </a>

                <a class="button button--dark button--sm modal-trigger" data-modal-id="modal-delete">
                  <i class='bx bxs-trash' data-modal-id="modal-delete"></i>
                  Delete
                </a>
              <?php } ?>
            </div>

            <br>

            <div class="profile-info__content viewprofile" style="display: block">
              <section class="profile-info__basic-info">

                <?php if (!is_null($user['off_position'])) : ?>
                  <div class="profile-info__container">
                    <div class="input__wrapper">
                      <label for="official-position">Position</label>
                      <div class="input__inner">
                        <input disabled name="position" id="official-position" class="input--light300 input-viewprofile" value="<?php echo $user['off_position'] ?>" disabled>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="official-role">Role</label>
                    <div class="input__inner">
                      <input disabled name="role" id="official-role" class="input--light300 input-viewprofile" value="<?php echo $user['role'] ?>" disabled>
                    </div>
                  </div>
                </div>


                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-username">Username</label>
                    <div class="input__inner">
                      <input disabled name="date_of_birth" type="text" id="resident-username" class="input--light300 input-viewprofile" value="<?php echo $user['username'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-password">Password</label>
                    <div class="input__inner">
                      <input disabled name="house_number" id="resident-password" type="password" class="input--light300 input-viewprofile" value="<?php echo $user['password'] ?>">
                      <!-- <i class="fa fa-eye showpwd" style="margin: 15px 0px 0px -30px; cursor: pointer;" onClick="showPwd('passwd', this)"> </i> -->
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>

        <?php
        require "modal/delete-user.php";
        require "modal/edit-user.php";
        ?>

      <?php } ?>
    </div>
  </div>

  <!-- ALERT -->
  <?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert--danger">
      <i class='bx bxs-error alert__icon'></i>
      <div class="alert__message">
        <?php
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        echo $error;
        ?>
      </div>
    </div>
  <?php } ?>
</main>

</body>


</html>