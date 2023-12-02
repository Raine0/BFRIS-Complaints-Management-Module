<?php

$page = 'Barangay Officials';
$headerTitle = 'Barangay Officials';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
require "modal/add-official.php";

$user_role = $_SESSION['role'];
?>

<main>
  <div class="content">
    <section class="brgy-officials">
      <table id="table">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>
              <div class="residents__header-actions">
                <button href="#" class="button button--md button--primary modal-trigger" data-modal-id="modal-newofficial">
                  <i class='bx bx-user-plus bx-sm' data-modal-id="modal-newofficial"></i>
                  ADD NEW OFFICIAL
                </button>
              </div>
            </th>
          </tr>
        </thead>

        <tbody>
          <?php
          $officialQuery = "SELECT * FROM official_view";

          $officialStatement = $pdo->query($officialQuery);
          $officials = $officialStatement->fetchAll(PDO::FETCH_ASSOC);

          foreach ($officials as $official) {
          ?>
            <tr>
              <td>
                <div class="table__row-img">
                  <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
                </div>
              </td>
              <td>
                <a href="view-official.php?official_id=<?php echo $official['official_id'] ?>&resident_id=<?php echo $official['resident_id'] ?>">
                  <div class="table__row-text">
                    <div class="table__row-name">
                      <?php echo $official['last_name'] ?>,
                      <?php echo $official['first_name'] ?>
                      <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                      <?php echo $official['suffix'] ?>
                    </div>
                    <div class="table__row-sub">
                      <div><?php echo $official['off_position'] ?></div>
                    </div>
                  </div>
                </a>
              </td>
              <td>
                <div class="table__action-buttons">
                  <a class="button button--primary button--sm modal-trigger" data-modal-id="modal-edit-<?php echo $official['official_id'] ?>">
                    <i class='bx bxs-edit'></i>
                    Edit Profile
                  </a>
                  <a href="view-official.php?official_id=<?php echo $official['official_id'] ?>&resident_id=<?php echo $official['resident_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                    VIEW PROFILE
                  </a>
                </div>
              </td>
            </tr>
            <?php require "modal/edit-official.php"; ?>

          <?php } ?>
        </tbody>
      </table>
      <!-- brgy officials end -->
    </section>
    <!-- officials end -->
  </div>
</main>

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

</body>

</html>