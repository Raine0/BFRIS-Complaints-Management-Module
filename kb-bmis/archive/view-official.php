<?php
$headerTitle = 'Officials Archive';
$page = 'Archive';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'official_archive_id')) {

    $sanitize_official_archive_id = filter_var($_GET['official_archive_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_archive_id = filter_var($sanitize_official_archive_id, FILTER_VALIDATE_INT);
}

$officialQuery =
    "SELECT official_archive.*, 
    COALESCE(resident.first_name, resident_archive.first_name) AS first_name, 
    COALESCE(resident.mid_name, resident_archive.mid_name) AS  mid_name, 
    COALESCE(resident.last_name, resident_archive.last_name) AS last_name, 
    COALESCE(resident.suffix, resident_archive.suffix) AS suffix,
    COALESCE(resident.img_url, resident_archive.img_url) AS img_url,
    COALESCE(resident.phone_number, resident_archive.phone_number) AS phone_number,
    COALESCE(resident.email, resident_archive.email) AS email,
    COALESCE(resident.emergency_person, resident_archive.emergency_person) AS emergency_person,
    COALESCE(resident.relationship, resident_archive.relationship) AS relationship,
    COALESCE(resident.emergency_address, resident_archive.emergency_address) AS emergency_address,
    COALESCE(resident.emergency_contact, resident_archive.emergency_contact) AS emergency_contact
    FROM official_archive
    LEFT JOIN resident 
    ON official_archive.resident_id = resident.resident_id 
    LEFT JOIN resident_archive
    ON official_archive.resident_id = resident_archive.resident_id 
    WHERE official_archive.official_archive_id = :official_archive_id
";

$officialStatement = $pdo->prepare($officialQuery);
$officialStatement->bindParam(':official_archive_id', $official_archive_id, PDO::PARAM_INT);

if ($officialStatement->execute()) {

    $officialCount = $officialStatement->rowCount();
    if ($officialCount === 1) {

        $official = $officialStatement->fetch(PDO::FETCH_ASSOC);

?>
        <main>
            <div class="content">
                <div class="card">
                    <a href="official-archive.php" class="button button--md back-btn">
                        <i class='bx bx-left-arrow-circle'></i>
                        Back
                    </a>

                    <div class="info">
                        <h4><strong>Created By:</strong></h4>
                        <p><?php echo $official['created_by']; ?></p>
                        <h4><strong>Date Created:</strong></h4>
                        <p><?php echo date('m-d-Y h:i:s a ', strtotime($official['date_created'])); ?></p>
                        <h4><strong>Archived By:</strong></h4>
                        <p><?php echo $official['archived_by']; ?></p>
                        <h4><strong>Date Archived:</strong></h4>
                        <p><?php echo date('m-d-Y h:i:s a ', strtotime($official['date_archived'])); ?></p>
                        <h4><strong>Remarks:</strong></h4>
                        <p><?php echo $official['remarks']; ?></p>
                    </div>


                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--viewprofile">
                                <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $official['last_name'] ?>,
                                <?php echo $official['first_name'] ?>
                                <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                <?php echo $official['suffix'] ?>
                            </div>

                            <div class="row">
                                <a href="#" class="button button--primary button--sm modal-trigger" data-modal-id="modal-restore">
                                    <i class='bx bxs-edit' data-modal-id="modal-restore"></i>
                                    Restore</a>
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
                                                <div class="select__wrapper">
                                                    <select disabled name="off_position" name="civil_status" id="" class="select select--resident-profile input-viewprofile">
                                                        <option value="<?php echo $official['off_position'] ?>" selected disabled><?php echo $official['off_position'] ?></option>
                                                        <option value="Barangay Chairman">Barangay Chairman</option>
                                                        <option value="Barangay Councilor">Barangay Councilor</option>
                                                        <option value="Barangay Secretary">Barangay Secretary</option>
                                                        <option value="Barangay Treasurer">Barangay Treasurer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="official-remarks">Current Term</label>
                                            <div class="input__inner">
                                                <input disabled name="term" type="textarea" class="input--light300 input-viewprofile" value="<?php echo $official['term'] ?>">
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
                </div>

            </div>
        </main>

        <?php require "modal/official-restore-modal.php"; ?>
<?php }
} ?>

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