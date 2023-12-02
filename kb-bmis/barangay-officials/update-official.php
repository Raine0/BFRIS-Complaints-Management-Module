<?php
ob_start();
$headerTitle = 'Update Official';
$page = 'Barangay Officials';

require_once "../../includes/header.php";
require "../../includes/preloader.php";
require "../../includes/modal-cancel.php";

$role = $_SESSION['role'];
$username = $_SESSION['username'];

if (filter_has_var(INPUT_POST, 'official_id') && filter_has_var(INPUT_POST, 'resident_id')) {
  $password = htmlspecialchars(md5($_POST['password']));

  $sanitize_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
  $official_id = filter_var($sanitize_official_id, FILTER_VALIDATE_INT);

  $sanitize_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
  $resident_id = filter_var($sanitize_resident_id, FILTER_VALIDATE_INT);
}

$userQuery = "SELECT username, password FROM user_view WHERE username = :username AND password = :password";
$userStatement = $pdo->prepare($userQuery);
$userStatement->bindParam(':username', $username);
$userStatement->bindParam(':password', $password);
$userStatement->execute();

$userCount = $userStatement->rowCount();
if ($userCount === 1) {

  $officialQuery = "SELECT * FROM official_view WHERE official_id = :official_id AND resident_id = :resident_id";

  $officialStatement = $pdo->prepare($officialQuery);
  $officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
  $officialStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
  $officialStatement->execute();

  $officialCount = $officialStatement->rowCount();

  if ($officialCount === 1) {
    $official = $officialStatement->fetch(PDO::FETCH_ASSOC);
?>
    <form action="controller/update.php" method="POST" enctype="multipart/form-data" data-parsley-validate="">
      <main>
        <div class="content">
          <div class="card">
            <a href="#" class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
              <i class='bx bx-left-arrow-circle' data-modal-id="modal-cancel"></i>
              Back
            </a>
            <div class="card__body">
              <div class="card__body-content">

                <div class="profile__img profile__img--edit-resident">
                  <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
                  <a href="#" class="button button--md button--icon button--icon-sm modal-trigger" data-modal-id="modal-change-picture"></a>
                </div>

                <div class="profile__name profile__name--viewprofile">
                  <?php echo $official['last_name'] ?>,
                  <?php echo $official['first_name'] ?>
                  <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                  <?php echo $official['suffix'] ?>
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
                    <input name="resident_id" hidden value="<?php echo $official['resident_id'] ?>">
                    <input hidden name="official_id" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['official_id'] ?>">

                    <input hidden name="term" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['term'] ?>">

                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="official-position">Position</label>
                        <div class="input__inner">
                          <div class="select__wrapper">
                            <select name="off_position" id="" class="select select--resident-profile input-viewprofile" required>
                              <option hidden value="<?php echo $official['off_position'] ?>" selected><?php echo $official['off_position'] ?></option>
                              <option value="Barangay Chairman">Barangay Chairman</option>
                              <option value="Barangay Councilor">Barangay Councilor</option>
                              <option value="Barangay Secretary">Barangay Secretary</option>
                              <option value="Barangay Treasurer">Barangay Treasurer</option>
                              <option value="Barangay Clerk">Barangay Clerk</option>
                              <option value="Barangay Kagawad">Barangay Kagawad</option>
                              <option value="SK Chairperson">SK Chairperson</option>
                              <option value="SK Councilor">SK Councilor</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="official-remarks">Current Term</label>
                        <div class="input__inner">
                          <input readonly name="term" type="text" class="input--light300 input-viewprofile" value="<?php echo $official['term'] ?>">
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
                            <input disabled type="checkbox" checked name="first_term" id="second_term" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="1st Term">
                            <input hidden type="checkbox" checked name="first_term" class="toggleswitch toggleswitch--resident-profile" value="2nd Term">
                            <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                            <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="resident-birthday">First Term</label>
                        <div class="input__inner">
                          <input name="first_start" type="date" class="input--light300 input-viewprofile" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $official['first_term_start'] ?>" required>
                        </div>
                      </div>
                    </div>

                    <?php
                    if ($official['term'] == "1st Term") {

                    ?>
                  </section>

                  <br>

                  <section class="profile-info__basic-info">
                    <!-- 2nd term -->
                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="second_term">Second Term?</label>
                        <div class="input__inner">
                          <div class="toggleswitch__wrapper">
                            <input type="checkbox" name="second_term" id="second_term" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="2nd Term">
                            <label class="toggleswitch__indicator toggleswitch__indicator--off ">No</label>
                            <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="second_start">Start of Second Term</label>
                        <div class="input__inner">
                          <input type="date" id="second_start" name="second_start" class="input--light300" min="<?php echo $official['first_term_start'] ?>" max="<?php echo date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="resident-booster1dosedate">End of First Term</label>
                        <div class="input__inner">
                          <input type="date" name="first_end" class="input--light300" min="<?php echo $official['first_term_start'] ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $official['first_term_end'] ?>" required>
                        </div>
                      </div>
                    </div>
                  </section>

                  <br>

                  <section class="profile-info__basic-info">
                    <!-- 2nd term fixed-->
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
                        <label for="resident-booster1dosedate">Start of Second Term</label>
                        <div class="input__inner">
                          <input type="date" name="second_start" id="second_start" class="input--light300" min="<?php echo $official['first_term_end'] ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $official['second_term_start'] ?>" required>
                        </div>
                      </div>
                    </div>

                  <?php } ?>

                  <?php
                  if ($official['term'] == "2nd Term") {

                  ?>
                  </section>

                  <br>

                  <section class="profile-info__basic-info">
                    <!-- 3rd term -->
                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="third_term">Third Term?</label>
                        <div class="input__inner">
                          <div class="toggleswitch__wrapper">
                            <input type="checkbox" name="third_term" id="third_term" class="toggleswitch toggleswitch--resident-profile" value="3rd Term">
                            <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                            <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="profile-info__container">
                        <div class="input__wrapper">
                          <label for="resident-booster1dosedate">End Second Term</label>
                          <div class="input__inner">
                            <input type="date" id="booster1-date" name="2nd-end" class="input--light300" value="<?php echo $official['second_term_end'] ?>">
                          </div>
                        </div>
                      </div> -->

                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="resident-booster1dosedate">Start of Third Term</label>
                        <div class="input__inner">
                          <input type="date" id="third_start" name="third_start" class="input--light300" min="<?php echo $official['second_term_start'] ?>" max="<?php echo date('Y-m-d'); ?>">
                        </div>
                      </div>
                    </div>
                  <?php } else if ($official['term'] == "3rd Term") { ?>
                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="resident-booster1dosedate">End of Second Term</label>
                        <div class="input__inner">
                          <input type="date" id="second_end" name="second_end" class="input--light300" value="<?php echo $official['second_term_end'] ?>" required>

                          <!-- <input hidden type="date" id="second_end" name="second_end" class="input--light300" value="<?php echo $official['second_term_end'] ?>" required> -->
                        </div>
                      </div>
                    </div>
                  </section>

                  <br>

                  <section class="profile-info__basic-info">
                    <!-- 3rd term -->
                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="resident-vaccinated">Third Term?</label>
                        <div class="input__inner">
                          <div class="toggleswitch__wrapper">
                            <input disabled checked type="checkbox" name="third_term" id="third_term" class="toggleswitch toggleswitch--resident-profile" value="3rd Term">
                            <input hidden checked type="checkbox" name="third_term" id="third_term" class="toggleswitch toggleswitch--resident-profile" value="3rd Term">
                            <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                            <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="profile-info__container">
                      <div class="input__wrapper">
                        <label for="resident-booster1dosedate">Start of Third Term</label>
                        <div class="input__inner">
                          <input type="date" id="third_start" name="third_start" class="input--light300" min="<?php echo $official['second_term_start'] ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $official['third_term_start'] ?>" required>
                        </div>
                      </div>
                    </div>

                  <?php } ?>

                  </section>
                  <div class="pagination__buttons">
                    <span class="pagination__button next" data-current-tab="basicInfoTab" data-next-tab="emergencyTab">Next<i class='bx bx-chevron-right'></i></span>
                  </div>
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

            <div class="card__footer">
              <div class="card__footer-content">
                <div class="card__footer-content--right">
                  <button class="button button--primary button--md" name="btn_save">SAVE</button>
                  <a href="#" class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </form>

<?php }
} else {
  $_SESSION['error'] = "Incorrect password.";
  header("location:view-official.php?official_id=$official_id&resident_id=$resident_id");
}

ob_end_flush();
?>

</body>

</html>