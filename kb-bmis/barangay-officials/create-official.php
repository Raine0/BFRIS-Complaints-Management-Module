<?php
$headerTitle = 'Add New Official';
$page = 'Barangay Officials';

require_once "../../includes/header.php";
require "../../includes/preloader.php";
require "../../includes/modal-cancel.php";


if (filter_has_var(INPUT_GET, 'resident_id')) {
    $sanitize_id = filter_var($_GET['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($sanitize_id, FILTER_SANITIZE_NUMBER_INT);
}

$residentQuery =  "SELECT * FROM resident WHERE resident_id= :resident_id";
$residentStatement = $pdo->prepare($residentQuery);
$residentStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
$residentStatement->execute();
$countResident = $residentStatement->rowCount();

if ($countResident === 1) {
    $resident = $residentStatement->fetch(PDO::FETCH_ASSOC);

?>
    <form action="controller/create.php" method="POST" enctype="multipart/form-data" data-parsley-validate="">
        <main>
            <div class="content">
                <div class="card">
                    <a href="#" class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
                        <i class='bx bx-left-arrow-circle' data-modal-id="modal-cancel"></i>
                        Back
                    </a>

                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--viewprofile">
                                <img src="../residents/images/<?php echo $resident['img_url'] ?>" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $resident['last_name'] ?>,
                                <?php echo $resident['first_name'] ?>
                                <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                <?php echo $resident['suffix'] ?>
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
                                    <input name="resident_id" type="text" value="<?php echo $resident_id ?>" hidden>

                                    <!-- <input name="off_name" type="text" value="<?php echo $resident["last_name"] . ", " . $resident["first_name"] .  " " . $resident["suffix"];  ?>" hidden> -->


                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="official-position">Position</label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="off_position" id="" class="select select--resident-profile input-viewprofile" required>
                                                        <option hidden disabled value="" selected>Select</option>
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
                                            <label for="resident-birthday">Start of Term</label>
                                            <div class="input__inner">
                                                <input name="term_start" type="date" class="input--light300 input-viewprofile" max="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <div class="pagination__buttons">
                                    <span class="pagination__button next" data-current-tab="basicInfoTab" data-next-tab="emergencyTab">Next<i class='bx bx-chevron-right'></i></span>
                                </div>
                            </div>

                            <div class="profile-info__content emergencyTab">
                                <section class="profile-info__emergency">

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="resident-emergencyperson">Emergency Person</label>
                                            <div class="input__inner">
                                                <input disabled name="emergency_person" type="text" class="input--light300 input-viewprofile" value="<?php echo $resident['emergency_person'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="resident-emergencyrelationship">Relationship</label>
                                            <div class="input__inner">
                                                <input disabled name="relationship" type="text" class="input--light300 input-viewprofile" value="<?php echo $resident['relationship'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="resident-emergencyaddress">Emergency Address</label>
                                            <div class="input__inner">
                                                <input disabled name="emergency_address" type="text" class="input--light300 input-viewprofile" value="<?php echo $resident['emergency_address'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="resident-emergencycontact">Emergency Contact</label>
                                            <div class="input__inner">
                                                <input disabled name="emergency_contact" type="text" class="input--light300 input-viewprofile" value="<?php echo $resident['emergency_contact'] ?>">
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
                                <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </form>

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