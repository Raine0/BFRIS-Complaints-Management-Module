<?php
$headerTitle = 'View Official';
$page = 'Barangay Officials';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'official_id') && filter_has_var(INPUT_GET, 'resident_id')) {
  $sanitize_official_id = filter_var($_GET['official_id'], FILTER_SANITIZE_NUMBER_INT);
  $official_id = filter_var($sanitize_official_id, FILTER_VALIDATE_INT);

  $sanitize_resident_id = filter_var($_GET['resident_id'], FILTER_SANITIZE_NUMBER_INT);
  $resident_id = filter_var($sanitize_resident_id, FILTER_VALIDATE_INT);
}

$officialQuery = "SELECT * FROM official_view WHERE official_id = :official_id AND resident_id = :resident_id";

$officialStatement = $pdo->prepare($officialQuery);
$officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
$officialStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
$officialStatement->execute();

$rowCount = $officialStatement->rowCount();
if ($rowCount === 1) {
  $official = $officialStatement->fetch(PDO::FETCH_ASSOC);
?>
  <main>
    <div class="content">
      <div class="card">
        <a class="button button--md back-btn">
          <?php require "../../includes/back-button.php"; ?>
        </a>

        <div class="info">
          <h4><strong>Created By:</strong></h4>
          <p><?php echo $official['created_by']; ?></p>
          <h4><strong>Date Created:</strong></h4>
          <p><?php echo date('m-d-Y h:i:s a ', strtotime($official['date_created'])); ?></p>
          <?php if ($official['updated_by'] && $official['date_updated']) : ?>
            <h4><strong>Updated By:</strong></h4>
            <p><?php echo $official['updated_by']; ?></p>
            <h4><strong>Date Updated:</strong></h4>
            <p><?php echo date('m-d-Y h:i:s a ', strtotime($official['date_updated'])); ?></p>
          <?php endif; ?>

          <?php if ($official['restored_by'] && $official['date_restored']) : ?>
            <h4><strong>Restored By:</strong></h4>
            <p><?php echo $official['restored_by']; ?></p>
            <h4><strong>Date Restored:</strong></h4>
            <p><?php echo date('m-d-Y h:i:s a ', strtotime($official['date_restored'])); ?></p>
          <?php endif; ?>

          <a class="button button--info button--md" id="resident-history">
            <i class='bx bxs-book-bookmark'></i>
            HISTORY
          </a>

          <div class="dropdown dropdown--history dropdown">
            <ul>
              <li class="dropdown__item">
                <a class="modal-trigger" data-modal-id="modal-brgy-clearance-history">
                  <i class='bx bxs-file-blank' data-modal-id="modal-brgy-clearance-history"></i>
                  Barangay Clearance History
                </a>
              </li>

              <li class="dropdown__item">
                <a class="modal-trigger" data-modal-id="modal-good-moral-history">
                  <i class='bx bxs-file-blank' data-modal-id="modal-good-moral-history"></i>
                  Good Moral Clearance History
                </a>
              </li>

              <li class="dropdown__item">
                <a class="modal-trigger" data-modal-id="modal-complaint-history">
                  <i class='bx bxs-notepad' data-modal-id="modal-complaint-history"></i>
                  Complaint History
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="card__body">
          <div class="card__body-content">
            <div class="profile__img profile__img--viewprofile">
              <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
            </div>

            <div class="profile__name profile__name--viewprofile">
              <?php echo $official['last_name'] ?>,
              <?php echo $official['first_name'] ?>
              <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
              <?php echo $official['suffix'] ?>
            </div>

            <div class="row">
              <a class="button button--primary button--sm modal-trigger" data-modal-id="modal-edit-<?php echo $official['official_id'] ?>">
                <i class='bx bxs-edit'></i>
                Edit Profile
              </a>
              <a class="button button--dark button--sm modal-trigger" data-modal-id="modal-delete">
                <i class='bx bxs-trash' data-modal-id="modal-delete"></i>
                End Term</a>
            </div>

            <ul class="profile-info__list">
              <li class="profile-info__item profile-info__item--active basicInfoTab">
                <span>
                  Basic Information
                </span>
              </li>

              <li class="profile-info__item emergencyTab">
                <span>
                  For Emergency
                </span>
              </li>

            </ul>

            <div class="profile-info__content basicInfoTab" style="display: block;">
              <section class="profile-info__basic-info">
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="official-position">Position</label>
                    <div class="input__inner">
                      <input disabled name="off_position" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['off_position'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="official-remarks">Current Term</label>
                    <div class="input__inner">
                      <input disabled name="term" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['term'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-contactnumber">Phone Number</label>
                    <div class="input__inner">
                      <input disabled name="phone_number" type="tel" class="input--light300 input-viewprofile" value="<?php echo $official['phone_number'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-email">Email Address</label>
                    <div class="input__inner">
                      <input disabled name="email" type="email" class="input--light300 input-viewprofile" value="<?php echo $official['email'] ?>">
                    </div>
                  </div>
                </div>
              </section>

              <br>

              <section class="profile-info__basic-info">
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-vaccinated">First Term?</label>
                    <div class="input__inner">
                      <div class="toggleswitch__wrapper">
                        <input disabled type="checkbox" checked name="first_term" id="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <input hidden type="checkbox" checked name="first_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                        <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-birthday">Start of First Term</label>
                    <div class="input__inner">
                      <input disabled name="term_start" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['first_term_start'] ?>">
                    </div>
                  </div>
                </div>

                <?php
                if ($official['term'] == "2nd Term") {

                ?>
                  <div class="profile-info__container">
                    <div class="input__wrapper">
                      <label for="resident-birthday">End of First Term</label>
                      <div class="input__inner">
                        <input disabled name="term_start" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['first_term_end'] ?>">
                      </div>
                    </div>
                  </div>
              </section>

              <br>

              <section class="profile-info__basic-info">
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-vaccinated">Second Term?</label>
                    <div class="input__inner">
                      <div class="toggleswitch__wrapper">
                        <input disabled type="checkbox" checked name="second_term" id="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <input hidden type="checkbox" checked name="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                        <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-birthday">Start of Second Term</label>
                    <div class="input__inner">
                      <input disabled name="term_start" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['second_term_start'] ?>">
                    </div>
                  </div>
                </div>
              <?php } ?>
              <?php
              if ($official['term'] == "3rd Term") {

              ?>
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-birthday">End of First Term</label>
                    <div class="input__inner">
                      <input disabled name="term_start" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['first_term_end'] ?>">
                    </div>
                  </div>
                </div>
              </section>

              <br>

              <section class="profile-info__basic-info">
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-vaccinated">Second Term?</label>
                    <div class="input__inner">
                      <div class="toggleswitch__wrapper">
                        <input disabled type="checkbox" checked name="second_term" id="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <input hidden type="checkbox" checked name="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                        <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-birthday">Start of Second Term</label>
                    <div class="input__inner">
                      <input disabled name="second_start" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['second_term_start'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-birthday">End of Second Term</label>
                    <div class="input__inner">
                      <input disabled name="secon_end" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['second_term_end'] ?>">
                    </div>
                  </div>
                </div>
              </section>

              <br>

              <section class="profile-info__basic-info">
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-vaccinated">Third Term?</label>
                    <div class="input__inner">
                      <div class="toggleswitch__wrapper">
                        <input disabled type="checkbox" checked name="second_term" id="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <input hidden type="checkbox" checked name="second_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                        <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                        <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                      </div>
                    </div>
                  </div>
                </div>

                <section class="profile-info__basic-info">
                  <div class="profile-info__container">
                    <div class="input__wrapper">
                      <label for="resident-birthday">Start of Third Term</label>
                      <div class="input__inner">
                        <input disabled name="term_start" type="date" class="input--light300 input-viewprofile" value="<?php echo $official['third_term_start'] ?>">
                      </div>
                    </div>
                  </div>
                <?php } ?>
                </section>

            </div>
            <div class="pagination__buttons">
              <span class="pagination__button next" data-current-tab="basicInfoTab" data-next-tab="emergencyTab">Next<i class='bx bx-chevron-right'></i></span>
            </div>

            <div class="profile-info__content emergencyTab">
              <section class="profile-info__emergency">
                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-emergencyperson">Emergency Contact Person</label>
                    <div class="input__inner">
                      <input disabled name="emergency_person" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['emergency_person'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container viewprofile">
                  <div class="input__wrapper">
                    <label for="resident-emergencyrelationship">Relationship</label>
                    <div class="input__inner">
                      <input disabled name="relationship" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['relationship'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-emergencyaddress">Address</label>
                    <div class="input__inner">
                      <input disabled name="emergency_address" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['emergency_address'] ?>">
                    </div>
                  </div>
                </div>

                <div class="profile-info__container">
                  <div class="input__wrapper">
                    <label for="resident-emergencycontact">Contact Number</label>
                    <div class="input__inner">
                      <input disabled name="emergency_contact" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['emergency_contact'] ?>">
                    </div>
                  </div>
                </div>
              </section>

              <div class="pagination__buttons">
                <span class="pagination__button prev" data-current-tab="emergencyTab" data-next-tab="basicInfoTab"><i class='bx bx-chevron-left'></i>Prev</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php

  require "modal/archive-official.php";
  require "modal/edit-official.php";
  require './modal/brgy-clearance-history.php';
  require './modal/good-moral-history.php';
  require './modal/complaint-history.php';

  ?>
<?php } ?>



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

</body>


</html>