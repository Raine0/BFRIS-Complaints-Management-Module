<?php
$headerTitle = 'Resident Profile';
$page = 'Residents';
require_once "../../includes/header.php";
require "../../includes/preloader.php";


if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['role'];
}


if (filter_has_var(INPUT_GET, 'resident_id')) {
    $sanitize_id = filter_var($_GET['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);
}


$query = "SELECT * FROM resident WHERE resident_id = :resident_id";
$statement = $pdo->prepare($query);
$statement->bindParam(':resident_id', $resident_id);
$statement->execute();

$count = $statement->rowCount();

if ($count === 1) {
    $resident = $statement->fetch(PDO::FETCH_ASSOC);
?>
    <main>
        <div class="content">
            <div class="card">
                <a class="button button--md back-btn">
                    <?php require "../../includes/back-button.php"; ?>
                </a>

                <div class="info">
                    <h4><strong>Created By:</strong></h4>
                    <p><?php echo $resident['created_by']; ?></p>
                    <h4><strong>Date Created:</strong></h4>
                    <p><?php echo date('m-d-Y h:i:s a ', strtotime($resident['date_created'])); ?></p>
                    <?php if ($resident['updated_by'] != null) : ?>
                        <h4><strong>Updated By:</strong></h4>
                        <p><?php echo $resident['updated_by']; ?></p>
                        <h4><strong>Date Updated:</strong></h4>
                        <p><?php echo date('m-d-Y h:i:s a ', strtotime($resident['date_updated'])); ?></p>
                    <?php endif; ?>

                    <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>
                        <a class="button button--info button--md" id="resident-history">
                            <i class='bx bxs-book-bookmark'></i>
                            HISTORY
                        </a>
                    <?php endif; ?>

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
                            <img src="images/<?php echo $resident["img_url"]; ?>" alt="">
                        </div>

                        <div class="profile__name profile__name--viewprofile">
                            <?php echo $resident['last_name'] ?>,
                            <?php echo $resident['first_name'] ?>
                            <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                            <?php echo $resident['suffix'] ?>
                        </div>

                        <div class="row">
                            <div class="action__cert">
                                <?php if ($user_role == 'Barangay Clerk - Admin' || $user_role == 'Barangay Secretary' || $user_role == 'Administrator') { ?>
                                    <button class="button button--info button--sm dropdownBtn" id="action-cert">
                                        <i class='bx bxs-file-blank'></i>
                                        GENERATE CLEARANCE
                                    </button>
                                <?php } ?>
                                <div class="dropdown dropdown--cert dropdownContent">
                                    <ul>
                                        <li class="dropdown__item">
                                            <a href="../certificates/brgy-clearance-create.php?resident_id=<?php echo $resident['resident_id'] ?>" class="link-brgycert">
                                                <i class='bx bxs-file'></i>
                                                Barangay Clearance
                                            </a>
                                        </li>
                                        <li class="dropdown__item">
                                            <a href="../certificates/good-moral-create.php?resident_id=<?php echo $resident['resident_id'] ?>" class="link-brgycert">
                                                <i class='bx bxs-file'></i>
                                                Good Moral Certificate
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <?php if ($user_role == 'Barangay Clerk - Resident Admin' || $user_role == 'Barangay Secretary' || $user_role == 'Administrator') {  ?>
                                <a class="button button--green button--sm modal-trigger" data-modal-id="modal-delete">
                                    <i class='bx bxs-trash' data-modal-id="modal-delete"></i>
                                    Archive
                                </a>
                            <?php } ?>

                            <?php if ($user_role == 'Barangay Clerk - Resident Encoder' || $user_role == 'Barangay Clerk - Resident Admin' || $user_role == 'Barangay Secretary' || $user_role == 'Administrator') {  ?>
                                <a href="update-resident.php?resident_id=<?php echo $resident["resident_id"]; ?>" class="button button--primary button--sm modal-trigger">
                                    <i class='bx bxs-edit'></i>
                                    Edit Profile
                                </a>
                            <?php } ?>

                        </div>

                        <ul class="profile-info__list">
                            <li class="profile-info__item profile-info__item--active basicInfoTab">
                                <span>
                                    Basic Information
                                </span>
                            </li>

                            <li class="profile-info__item votingTab">
                                <span>
                                    Voter's Information
                                </span>
                            </li>

                            <li class="profile-info__item vaccineTab">
                                <span>
                                    COVID-19 Vaccination
                                </span>
                            </li>

                            <li class="profile-info__item emergencyTab">
                                <span>
                                    Emergency Contact
                                </span>
                            </li>
                        </ul>

                        <div class="profile-info__content basicInfoTab" style="display: block;">

                            <br>
                            <div class="profile-info__sub-section">
                                Personal Information
                            </div>
                            <br>

                            <section class="profile-info__basic-info">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="first_name">First Name</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="first_name" id="first_name" class="input--light300 input-viewprofile" value="<?php echo $resident['first_name'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="mid_name">Middle Name</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="mid_name" id="mid_name" class="input--light300 input-viewprofile" value="<?php echo $resident['mid_name'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="last_name">Last Name</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="last_name" id="last_name" class="input--light300 input-viewprofile" value="<?php echo $resident['last_name'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="suffix">Suffix</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="suffix" id="suffix" class="input--light300 input-viewprofile" value="<?php if ($resident['suffix']) {
                                                                                                                                                        echo $resident['suffix'];
                                                                                                                                                    } else {
                                                                                                                                                        echo "None";
                                                                                                                                                    } ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="sex">Gender</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="sex" id="sex" class="select select--resident-profile input-viewprofile input-viewprofile">
                                                    <option value="<?php echo $resident['sex'] ?>" selected>
                                                        <?php echo $resident['sex'] ?></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="date_of_birth">Date of Birth </label>
                                        <div class="input__inner">
                                            <input disabled type="date" name="date_of_birth" id="date_of_birth" class="input--light300 input-viewprofile dob" value="<?php echo $resident['date_of_birth'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="age">Age</label>
                                        <div class="input__inner">
                                            <input disabled type="number" name="age" id="age" class="input--light300 input-viewprofile dob" value="<?php echo calculate_age($resident['date_of_birth']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="place_of_birth">Place of Birth</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="place_of_birth" id="place_of_birth" class="input--light300 input-viewprofile" value="<?php echo $resident['place_of_birth'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="civil_status">Civil Status</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="civil_status" id="civil_status" class="select select--resident-profile input-viewprofile">
                                                    <option value="<?php echo $resident['civil_status'] ?>" selected disabled>
                                                        <?php echo $resident['civil_status'] ?></option>
                                                    <option value="single">Single</option>
                                                    <option value="married">Married</option>
                                                    <option value="divorced">Divorced</option>
                                                    <option value="separated">Separated</option>
                                                    <option value="widowed">Widowed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="nationality">Nationality</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="nationality" id="nationality" class="input--light300 input-viewprofile" value="<?php echo $resident['nationality'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="occupation">Occupation</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="occupation" id="occupation" class="input--light300 input-viewprofile" value="<?php echo $resident['occupation'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="religion">Religion</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="religion" id="religion" class="input--light300 input-viewprofile" value="<?php echo $resident['religion'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="blood_type">Blood Type</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="blood_type" id="blood_type" class="select select--resident-profile input-viewprofile">
                                                    <option value="<?php echo $resident['blood_type'] ?>" selected disabled>
                                                        <?php echo $resident['blood_type'] ?></option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="fourps_status">4Ps?</label>
                                        <div class="input__inner">
                                            <div class="toggleswitch__wrapper">

                                                <input <?php if ($resident['fourps_status'] == "") {
                                                            echo "unchecked";
                                                        } elseif ($resident['fourps_status'] == "4Ps") {
                                                            echo "checked";
                                                        } ?> disabled name="fourps_status" type="checkbox" id="fourps_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="4Ps">
                                                <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="disability_status">Person with Disability?</label>
                                        <div class="input__inner">
                                            <div class="toggleswitch__wrapper">
                                                <input <?php if ($resident['disability_status'] == "None") {
                                                            echo "unchecked";
                                                        } elseif ($resident['disability_status'] == "Person With Disability") {
                                                            echo "checked";
                                                        } ?> disabled type="checkbox" name="disability_status" id="disability_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile">
                                                <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="type_disability">Type of Disability</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="type_disability" id="type_disability" class="select select--resident-profile input-viewprofile">
                                                    <option selected disabled>
                                                        <?php if (isset($resident['type_disability'])) {
                                                            echo $resident['type_disability'];
                                                        } else {
                                                            echo "None";
                                                        } ?></option>
                                                    <option value="0">Psychosocial Disability</option>
                                                    <option value="1">Mental Disability</option>
                                                    <option value="2">Chronic Illness</option>
                                                    <option value="3">Learning Disability</option>
                                                    <option value="4">Visual Disability</option>
                                                    <option value="5">Orthopedic Disability</option>
                                                    <option value="6">Communication Disability</option>
                                                    <option value="7">Multiple Disabilities</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="senior_status">Senior Citizen?</label>
                                        <div class="input__inner">
                                            <div class="toggleswitch__wrapper">
                                                <input <?php if ($resident['senior_status'] == "") {
                                                            echo "unchecked";
                                                        } elseif ($resident['senior_status'] == "Senior Citizen") {
                                                            echo "checked";
                                                        } ?> disabled type="checkbox" name="senior_status" id="senior_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Senior Citizen">
                                                <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($resident['deceased_status'] == "Deceased") { ?>
                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="deceased_status">Deceased?</label>
                                            <div class="input__inner">
                                                <div class="toggleswitch__wrapper">
                                                    <input <?php if ($resident['deceased_status'] == "") {
                                                                echo "unchecked";
                                                            } elseif ($resident['deceased_status'] == "Deceased") {
                                                                echo "checked";
                                                            } ?> disabled name="deceased_status" type="checkbox" id="deceased_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile">
                                                    <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                    <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="date_of_death">Date of Death</label>
                                            <div class="input__inner">
                                                <input disabled name="date_of_death" id="" date_of_death type="date" class="input--light300 input-viewprofile" value="<?php echo $resident['date_of_death'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </section>

                            <br>

                            <section class="profile-info__basic-info">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="educational_attainment">Educational Attainment</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="education_status" name="educational_attainment" id="educational_attainment" class="select select--resident-profile input-viewprofile" required>
                                                    <option value="<?php echo $resident['educational_attainment'] ?>" selected disabled>
                                                        <?php echo $resident['educational_attainment'] ?></option>

                                                    <option value="No Grade Completed">No Grade Completed</option>
                                                    <option value="Elementary Undergraduate">Elementary Undergraduate
                                                    </option>
                                                    <option value="Elementary Graduate">Elementary Graduate</option>
                                                    <option value="Highschool Undergraduate">Highschool Undergraduate
                                                    </option>
                                                    <option value="Highschool Graduate">Highschool Graduate</option>
                                                    <option value="College Undergraduate">College Undergraduate</option>
                                                    <option value="College Graduate">College Graduate</option>
                                                    <option value="Post Baccalaureate">Post Baccalaureate</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <br>
                            <div class="profile-info__sub-section">
                                Address
                            </div>
                            <br>

                            <section class="profile-info__basic-info">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="purok">Purok Name / Zone No. </label>
                                        <div class="input__inner">

                                            <!-- <input disabled name="purok" type="text"
                                            class="input--light300 input-viewprofile"
                                            value="<?php echo $resident['purok'] ?>"> -->

                                            <div class="select__wrapper">
                                                <select disabled name="purok" id="purok" name="civil_status" id="" class="select select--resident-profile input-viewprofile">
                                                    <option value="<?php echo $resident['purok'] ?>" selected disabled>
                                                        <?php echo $resident['purok'] ?></option>
                                                    <option value="Purok 1">Purok 1</option>
                                                    <option value="Purok 2">Purok 2</option>
                                                    <option value="Purok 3">Purok 3</option>
                                                    <option value="Purok 4">Purok 4</option>
                                                    <option value="Purok 5">Purok 5</option>
                                                    <option value="Purok 6">Purok 6</option>
                                                    <option value="Purok 7">Purok 7</option>
                                                    <option value="Purok 8">Purok 8</option>
                                                    <option value="Purok 9-A">Purok 9-A</option>
                                                    <option value="Purok 9-B">Purok 9-B</option>
                                                    <option value="Purok 10-A">Purok 10-A</option>
                                                    <option value="Purok 10-B">Purok 10-B</option>
                                                    <option value="Purok 11">Purok 11</option>
                                                    <option value="Purok Lower 11-A">Purok Lower 11-A</option>
                                                    <option value="Purok Purok Upper 11-A">Purok Upper 11-A</option>
                                                    <option value="Purok 11-B">Purok 11-B</option>
                                                    <option value="Purok 11-C">Purok 11-C</option>
                                                    <option value="Purok 12">Purok 12</option>
                                                    <option value="Purok 12-A">Purok 12-A</option>
                                                    <option value="Purok 13">Purok 13</option>
                                                    <option value="Purok 13-A">Purok 13-A</option>
                                                    <option value="Purok 13-B">Purok 13-B</option>
                                                    <option value="Purok 14">Purok 14</option>
                                                    <option value="Purok 15">Purok 15</option>
                                                    <option value="Purok Lower 16">Purok Lower 16</option>
                                                    <option value="Purok Upper 16">Purok Upper 16</option>
                                                    <option value="Purok 17-A">Purok 17-A</option>
                                                    <option value="Purok 17-B">Purok 17-B</option>
                                                    <option value="Purok 18">Purok 18</option>
                                                    <option value="Purok 19">Purok 19</option>
                                                    <option value="Purok 20">Purok 20</option>
                                                    <option value="Purok 21">Purok 21</option>
                                                    <option value="Purok 22">Purok 22</option>
                                                    <option value="Purok 23">Purok 23</option>
                                                    <option value="Purok 24">Purok 24</option>
                                                    <option value="Purok 25">Purok 25</option>
                                                    <option value="Purok 26">Purok 26</option>
                                                    <option value="Purok 27">Purok 27</option>
                                                    <option value="Purok 28">Purok 28</option>
                                                    <option value="Purok 29">Purok 29</option>
                                                    <option value="Purok 30">Purok 30</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="street">Street / Block </label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="street" id="street" class="input--light300 input-viewprofile" value="<?php echo $resident['street'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="lot_number">Lot No. / Street No. / Unit No. </label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="lot_number" id="lot_number" class="input--light300 input-viewprofile" value="<?php echo $resident['lot_number'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <br>
                            <div class="profile-info__sub-section">
                                Contact Information
                            </div>
                            <br>

                            <section class="profile-info__basic-info">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="phone_number">Phone Number</label>
                                        <div class="input__inner">
                                            <input disabled type="tel" name="phone_number" id="phone_number" class="input--light300 input-viewprofile" value="<?php echo $resident['phone_number'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="tel_number">Tel. Number</label>
                                        <div class="input__inner">
                                            <input disabled type="tel" name="tel_number" id="tel_number" class="input--light300 input-viewprofile" value="<?php echo $resident['tel_number'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="email">Email Address</label>
                                        <div class="input__inner">
                                            <input disabled type="email" name="email" id="email" class="input--light300 input-viewprofile" value="<?php echo $resident['email'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>


                            <div class="pagination__buttons">
                                <span class="pagination__button next" data-current-tab="basicInfoTab" data-next-tab="votingTab">Next<i class='bx bx-chevron-right'></i></span>
                            </div>
                        </div>

                        <div class="profile-info__content votingTab">
                            <section class="profile-info__voting">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="voter_status">Registered Voter?</label>
                                        <div class="input__inner">
                                            <div class="toggleswitch__wrapper">
                                                <input <?php if ($resident['voter_status'] == "") {
                                                            echo "unchecked";
                                                        } elseif ($resident['voter_status'] == "Registered Voter") {
                                                            echo "checked";
                                                        } ?> disabled name="voter_status" type="checkbox" id="voter_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile regVoterToggle" value="Registered Voter">
                                                <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="voter_id">Voter's ID</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="voter_id" class="input--light300 input-viewprofile" value="<?php echo $resident['voter_id'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="resident-precinctnumber">Precinct Number</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="precinct_number" id="precinct_number" class="input--light300 input-viewprofile" value="<?php echo $resident['precinct_number'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="pagination__buttons">
                                <span class="pagination__button prev" data-current-tab="votingTab" data-next-tab="basicInfoTab"><i class='bx bx-chevron-left'></i>Prev</span>
                                <span class="pagination__button next" data-current-tab="votingTab" data-next-tab="vaccineTab">Next<i class='bx bx-chevron-right'></i></span>
                            </div>
                        </div>

                        <div class="profile-info__content vaccineTab">
                            <section class="profile-info__others">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="vaccine_status">Received COVID-19 Vaccine?</label>
                                        <div class="input__inner">
                                            <div class="toggleswitch__wrapper">
                                                <input <?php if ($resident['vaccine_status'] == "") {
                                                            echo "unchecked";
                                                        } elseif ($resident['vaccine_status'] == "Vaccinated" || $resident['vaccine_status'] == "wew") {
                                                            echo "checked";
                                                        } ?> disabled name="vaccine_status" id="vaccine_status" type="checkbox" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Vaccinated">
                                                <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <br>

                            <section class="profile-info__others">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="vaccine_1">First Dose Vaccine</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="vaccine_1" id="vaccine_1" class="select select--resident-profile input-viewprofile">
                                                    <option selected disabled value="<?php echo $resident['vaccine_1'] ?>">
                                                        <?php echo $resident['vaccine_1'] ?></option>
                                                    <option value="Astrazeneca">Astrazeneca</option>
                                                    <option value="Bharat">Bharat</option>
                                                    <option value="Janssen">Janssen</option>
                                                    <option value="Moderna">Moderna</option>
                                                    <option value="Novavax">Novavax</option>
                                                    <option value="Pfizer">Pfizer</option>
                                                    <option value="Sinovac">Sinovac</option>
                                                    <option value="Sputnik">Sputnik</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="vaccine_date_1">First Dose Date <small style="font-style: italic"> (DD - MM - YYYY) </small></label>
                                        <div class="input__inner">
                                            <input disabled type="date" name="vaccine_date_1" id="vaccine_date_1" class="input--light300 input-viewprofile" value="<?php echo $resident['vaccine_date_1'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="vaccine_2">Second Dose Vaccine</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="vaccine_2" id="vaccine_2" class="select select--resident-profile input-viewprofile">
                                                    <option selected disabled value="<?php echo $resident['vaccine_2'] ?>">
                                                        <?php echo $resident['vaccine_2'] ?></option>
                                                    <option value="Astrazeneca">Astrazeneca</option>
                                                    <option value="Bharat">Bharat</option>
                                                    <option value="Janssen">Janssen</option>
                                                    <option value="Moderna">Moderna</option>
                                                    <option value="Novavax">Novavax</option>
                                                    <option value="Pfizer">Pfizer</option>
                                                    <option value="Sinovac">Sinovac</option>
                                                    <option value="Sputnik">Sputnik</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="vaccine_date_2">Second Dose Date <small style="font-style: italic"> (DD - MM - YYYY) </small></label>
                                        <div class="input__inner">
                                            <input disabled type="date" name="vaccine_date_2" id="vaccine_date_2" class="input--light300 input-viewprofile" value="<?php echo $resident['vaccine_date_2'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <br>

                            <section class="profile-info__others">
                                <!-- booster -->
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="booster_status">Received Booster Shot?</label>
                                        <div class="input__inner">
                                            <div class="toggleswitch__wrapper">
                                                <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                <?php if ($resident['booster_status'] == "Boostered") { ?>
                                                    <input disabled name="voter_status" type="checkbox" checked id="booster_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile">
                                                <?php } ?>
                                                <?php if ($resident['booster_status'] == "") { ?>
                                                    <input disabled name="voter_status" type="checkbox" unchecked id="booster_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile">
                                                <?php } ?>
                                                <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <br>

                            <section class="profile-info__others">
                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="booster_1">First Dose Vaccine</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="booster_1" id="booster_1" class="select select--resident-profile input-viewprofile">
                                                    <option selected disabled value="<?php echo $resident['booster_1'] ?>">
                                                        <?php echo $resident['booster_1'] ?></option>
                                                    <option value="Astrazeneca">Astrazeneca</option>
                                                    <option value="Bharat">Bharat</option>
                                                    <option value="Janssen">Janssen</option>
                                                    <option value="Moderna">Moderna</option>
                                                    <option value="Novavax">Novavax</option>
                                                    <option value="Pfizer">Pfizer</option>
                                                    <option value="Sinovac">Sinovac</option>
                                                    <option value="Sputnik">Sputnik</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="booster_date_1">First Dose Date <small style="font-style: italic"> (DD - MM - YYYY) </small></label>
                                        <div class="input__inner">
                                            <input disabled type="date" name="booster_date_1" id="booster_date_1" class="input--light300 input-viewprofile" value="<?php echo $resident['booster_date_1'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="booster_2">Second Dose Vaccine</label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select disabled name="booster_2" id="booster_2" class="select select--resident-profile input-viewprofile">
                                                    <option selected disabled value="<?php echo $resident['booster_2'] ?>">
                                                        <?php echo $resident['booster_2'] ?></option>
                                                    <option value="Astrazeneca">Astrazeneca</option>
                                                    <option value="Bharat">Bharat</option>
                                                    <option value="Janssen">Janssen</option>
                                                    <option value="Moderna">Moderna</option>
                                                    <option value="Novavax">Novavax</option>
                                                    <option value="Pfizer">Pfizer</option>
                                                    <option value="Sinovac">Sinovac</option>
                                                    <option value="Sputnik">Sputnik</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="booster_date_2">Second Dose Date <small style="font-style: italic"> (DD - MM - YYYY) </small></label>
                                        <div class="input__inner">
                                            <input disabled type="date" name="booster_date_2" id="booster_date_2" class="input--light300 input-viewprofile" value="<?php echo $resident['booster_date_2'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <div class="pagination__buttons">
                                <span class="pagination__button prev" data-current-tab="vaccineTab" data-next-tab="votingTab"><i class='bx bx-chevron-left'></i>Prev</span>
                                <span class="pagination__button next" data-current-tab="vaccineTab" data-next-tab="emergencyTab">Next<i class='bx bx-chevron-right'></i></span>
                            </div>
                        </div>

                        <div class="profile-info__content emergencyTab">
                            <section class="profile-info__emergency">

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="emergency_person">Emergency Contact Person</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="emergency_person" id="emergency_person" class="input--light300 input-viewprofile" value="<?php echo $resident['emergency_person'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container viewprofile">
                                    <div class="input__wrapper">
                                        <label for="relationship">Relationship</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="relationship" id="relationship" class="input--light300 input-viewprofile" value="<?php echo $resident['relationship'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="emergency_address">Address</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="emergency_address" id="emergency_address" class="input--light300 input-viewprofile" value="<?php echo $resident['emergency_address'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-info__container">
                                    <div class="input__wrapper">
                                        <label for="emergency_contact">Contact Number</label>
                                        <div class="input__inner">
                                            <input disabled type="text" name="emergency_contact" id="emergency_contact" class="input--light300 input-viewprofile" value="<?php echo $resident['emergency_contact'] ?>">
                                        </div>
                                    </div>
                                </div>

                            </section>

                            <div class="pagination__buttons">
                                <span class="pagination__button prev" data-current-tab="emergencyTab" data-next-tab="vaccineTab"><i class='bx bx-chevron-left'></i>Prev</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ALERT -->

        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert--danger" id="alert">
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

        <?php
        require "./modal/archive-confirmation.php";
        require './modal/brgy-clearance-history.php';
        require './modal/good-moral-history.php';
        require './modal/complaint-history.php';
        ?>

    </main>
<?php }

?>


</body>

</html>