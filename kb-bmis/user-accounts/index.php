<?php
$page = 'User Accounts';
$headerTitle = 'User Accounts';

require_once "../../includes/header.php";
require "../../includes/preloader.php";

?>

<?php if (isset($_SESSION['success'])) { ?>
  <!-- ALERT -->
  <div class="alert alert--success">
    <i class='bx bxs-check-square alert__icon'></i>
    <div class="alert__message">
      <?php
      $success = $_SESSION['success'];
      unset($_SESSION['success']);
      echo $success;
      ?>
    </div>
  </div>
<?php } ?>

<?php if (isset($_SESSION['error'])) { ?>
  <!-- ALERT -->
  <div class="alert alert--danger">
    <i class='bx bxs-check-square alert__icon'></i>
    <div class="alert__message">
      <?php
      $error = $_SESSION['error'];
      unset($_SESSION['error']);
      echo $error;
      ?>
    </div>
  </div>
<?php } ?>

<main>
  <div class="content">
    <section class="user">
      <table id="table" class="row-border">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>
              <div class="residents__header-actions">
                <button class="button button--md button--primary modal-trigger" data-modal-id="modal-newofficial">
                  <i class='bx bx-user-plus bx-sm' data-modal-id="modal-newofficial"></i>
                  ADD USER
                </button>
              </div>
            </th>
          </tr>
        </thead>

        <tbody>
          <?php
          $userQuery = "SELECT * from user_view";

          $userStatement = $pdo->query($userQuery);
          $rowCount = $userStatement->rowCount();

          if (!$rowCount > 0) {
            $_SESSION['error'] = "User Data Not Found";
            header("location: ./");
          }

          $users = $userStatement->fetchAll(PDO::FETCH_ASSOC);
          foreach ($users as $user) { ?>
            <tr>
              <td>
                <div class="table__row-img">
                  <?php if (is_null($user['img_url'])) : ?>
                    <img src="../residents/images/default-img.svg" alt="">
                  <?php else : ?>
                    <img src="../residents/images/<?php echo $user['img_url'] ?>" alt="">
                  <?php endif; ?>
                </div>
              </td>

              <td>
                <a href="view-user.php?user_id=<?php echo $user['user_id'] ?>&role=<?php echo $user['role'] ?>">
                  <div class="table__row-text">
                    <?php if (is_null($user['last_name']) && is_null($user['first_name'])) : ?>
                      <div class="table__row-name">
                        <?php echo $user['role'] ?>
                      </div>
                    <?php else : ?>
                      <div class="table__row-name">
                        <?php echo $user['last_name'] ?>,
                        <?php echo $user['first_name'] ?>
                        <?php echo $user['mid_name'] ? mb_substr($user['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                        <?php echo $user['suffix'] ?>
                      </div>
                    <?php endif; ?>
                    <div class="table__row-sub">
                      <div><?php echo $user['role'] ?></div>
                    </div>
                  </div>
                </a>
              </td>

              <td>
                <div class="table__action-buttons">
                  <?php if ($user_role == "Administrator") { ?>
                    <a class="button button--primary button--sm modal-trigger" data-modal-id="modal-edituser-<?php echo $user['user_id'] ?>">
                      <i class='bx bxs-edit' data-modal-id="modal-edituser-<?php echo $user['user_id'] ?>"></i>
                      EDIT PROFILE
                    </a>
                  <?php } ?>

                  <a href="view-user.php?user_id=<?php echo $user['user_id'] ?>&role=<?php echo $user['role'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                    VIEW PROFILE
                  </a>
                </div>
              </td>
            </tr>

            <?php require "modal/edit-user.php"; ?>
          <?php } ?>
        </tbody>
      </table>
    </section>
    <!-- brgy officials end -->
    <!-- card end -->
  </div>
</main>

<?php
require "modal/add-user.php";
?>


</body>

</html>