<?php
$headerTitle = 'Update Resident Profile';
$page = 'Residents';
require "../../includes/header.php";
require "../../includes/preloader.php";
require "../../includes/modal-cancel.php";

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
            <section class="residents">
                <form id="form" action="controller/update.php" method="POST" enctype="multipart/form-data">

                    <div class="card">
                        <a class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
                            <i class='bx bx-left-arrow-circle' data-modal-id="modal-cancel"></i>
                            Back
                        </a>

                        <div class="card__body">
                            <div class="card__body-content">
                                <div class="profile__img">
                                    <div id="profile">
                                        <img src="images/<?php echo $resident['img_url'] ?>" alt="">
                                    </div>
                                    <div id="results"></div>
                                    <input type="hidden" name="orig_img" value="<?php echo $resident['img_url']; ?>">
                                </div>


                                <div class="profile__img--buttons">
                                    <div class="profile-info__container" style="width: 75%;">
                                        <div class="input__wrapper" style="margin-bottom: 0;">
                                            <div class="input__inner">
                                                <input type="file" name="upload" class="input--light300 uploadInput" style="padding: 8px; font-size: 12px;">
                                            </div>

                                        </div>
                                    </div>

                                    <a class="button--icon button--icon-sm button--light modal-trigger cameraBtn" data-modal-id="modal-camera" onclick="open_cam();" style="white-space: nowrap;">
                                        <i class='bx bx-camera' data-modal-id="modal-camera"></i>
                                    </a>


                                </div>
                                <?php
                                if (isset($_SESSION['error'])) {
                                    echo "<small style='color:red'>" . $_SESSION['error'] . "</small><br>";
                                    unset($_SESSION['error']); // clear the error message from the session
                                }
                                ?>
                                <small style="text-indent:10px; font-style: italic">
                                    Note: The maximum file size allowed is 1MB. <br>
                                    Only JPEG, JPG, and PNG formats are accepted.
                                </small>


                                <div class="profile__name profile__name--viewprofile" style="margin-top: 10px;">
                                    <?php echo $resident['last_name'] ?>,
                                    <?php echo $resident['first_name'] ?>
                                    <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                    <?php echo $resident['suffix'] ?>
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
                                        <input type="text" hidden name="resident_id" class="input--light300" value="<?php echo $resident['resident_id'] ?>">
                                        <input type="text" hidden name="created_by" class="input--light300" value="<?php echo $resident['created_by'] ?>">
                                        <input type="date" hidden name="date_created" class="input--light300" value="<?php echo $resident['date_created'] ?>">

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="first_name">First Name <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="first_name" id="first_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['first_name'] ?>" required autofocus>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="mid_name">Middle Name</label>
                                                <div class="input__inner">
                                                    <input type="text" name="mid_name" id="mid_name" title="Avoid inputting whitespaces." class="input--light300" value="<?php echo $resident['mid_name'] ?>" pattern="[a-zA-z -ñÑ]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="last_name">Last Name <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="last_name" id="last_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['last_name'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="suffix">Suffix <small style="font-style: italic"> (i.e. Sr., Jr., II, III) </small></label>
                                                <div class="input__inner">
                                                    <input type="text" name="suffix" id="suffix" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['suffix'] ?>" pattern="[a-zA-Z. ]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed. Avoid inputting whitespaces.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')" maxlength="7">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="sex">Gender <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="sex" id="sex" class="select select--resident-profile" required>
                                                            <option selected hidden value="<?php echo $resident['sex'] ?>">
                                                                <?php echo $resident['sex'] ?></option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Prefer not to say">Prefer not to say</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="date_of_birth">Date of Birth <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="date" name="date_of_birth" id=" date_of_birth" class="input--light300 dob" value="<?php echo $resident['date_of_birth'] ?>" max="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="age">Age</label>
                                                <div class="input__inner">
                                                    <input type="number" name="age" id="age" class="input--light300 input-viewprofile dob" value="<?php echo calculate_age($resident['date_of_birth']) ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="place_of_birth">Place of Birth <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="place_of_birth" id="place_of_birth" title="Numbers and Special Characters are not" class=" input--light300" value="<?php echo $resident['place_of_birth'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="civil_status">Civil Status <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="civil_status" id="civil_status" class="select select--resident-profile" onchange="showInput('civil_status', 'other_civil_status', 'other-civil-status')" required>
                                                            <option selected hidden value="<?php echo $resident['civil_status'] ?>"><?php echo $resident['civil_status'] ?></option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Divorced">Divorced</option>
                                                            <option value="Legally Separated">Legally Separated</option>
                                                            <option value="Annulled">Annulled</option>
                                                            <option value="Nullified">Nullified</option>
                                                            <option value="Undisclosed">Undisclosed</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container" id="other_civil_status" style="display:none">
                                            <div class="input__wrapper">
                                                <label for="other-civil-status">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="other_civil_status" id="other-civil-status" title="Numbers and Special Characters are not allowed." class="input--light300">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="nationality">Nationality <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="nationality" id="nationality" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['nationality'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="occupation">Occupation</label>
                                                <div class="input__inner">
                                                    <input type="text" name="occupation" id="occupation" title="Avoid inputting whitespaces." class="input--light300" value="<?php echo $resident['occupation'] ?>" pattern="[a-zA-Z ,ñÑ]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed. Avoid inputting whitespaces.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="religion">Religion</label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="religion" id="religion" class="select select--resident-profile" onchange="showInput('religion', 'other_religion', 'other-religion')">
                                                            <option value="<?php echo $resident['religion'] ?>" selected hidden>
                                                                <?php echo $resident['religion'] ?: "Select";
                                                                ?></option>
                                                            <option value="Roman catholic">Roman Catholic</option>
                                                            <option value="Protestantism">Protestantism</option>
                                                            <option value="Iglesia ni cristo">Iglesia ni Cristo</option>
                                                            <option value="Islam">Islam</option>
                                                            <option value="Buddhism">Buddhism</option>
                                                            <option value="Hinduism">Hinduism</option>
                                                            <option value="Sikhism">Sikhism</option>
                                                            <option value="Judaism">Judaism</option>
                                                            <option value="Atheism">Atheism</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container" id="other_religion" style="display:none">
                                            <div class="input__wrapper">
                                                <label for="other_religions">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="other_religion" id="other-religion" title="Numbers and Special Characters are not allowed." class="input--light300">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="blood_type">Blood Type</label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="blood_type" id="blood_type" class="select select--resident-profile">
                                                            <option selected hidden value="<?php echo $resident['blood_type']; ?>">
                                                                <?php $resident['blood_type'] ?: "Select";
                                                                ?></option>
                                                            <option value="A">A</option>
                                                            <option value="A+">A+</option>
                                                            <option value="A-">A-</option>
                                                            <option value="B">B</option>
                                                            <option value="B+">B+</option>
                                                            <option value="B-">B-</option>
                                                            <option value="O">O</option>
                                                            <option value="O+">O+</option>
                                                            <option value="O-">O-</option>
                                                            <option value="AB">AB</option>
                                                            <option value="AB+">AB+</option>
                                                            <option value="AB-">AB-</option>
                                                            <option value="RH-NULL">RH-NULL</option>
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
                                                                } ?> name="fourps_status" type="checkbox" id="fourps_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="4Ps">
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
                                                                } ?> name="disability_status" id="disability_status" type="checkbox" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Person With Disability">
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
                                                        <select name="type_disability" id="type_disability" class="select select--resident-profile" onchange="showInput('type_disability', 'other_disability', 'other-disability')">
                                                            <option value="<?php echo $resident['type_disability']; ?>" hidden selected>
                                                                <?php echo $resident['type_disability'] ?: "Select";
                                                                ?>
                                                            </option>
                                                            <option value="Psychosocial Disability">Psychosocial
                                                                Disability</option>
                                                            <option value="Mental Disability">Mental Disability</option>
                                                            <option value="Chronic Illness">Chronic Illness</option>
                                                            <option value="Learning Disability">Learning Disability
                                                            </option>
                                                            <option value="Visual Disability">Visual Disability</option>
                                                            <option value="Orthopedic Disability">Orthopedic Disability
                                                            </option>
                                                            <option value="Communication Disability">Communication
                                                                Disability</option>
                                                            <option value="Multiple Disabilities">Multiple Disabilities
                                                            </option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container" id="other_disability" style="display:none">
                                            <div class="input__wrapper">
                                                <label for="other-disability">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="other_disability" id="other-disability" title="Numbers and Special Characters are not allowed." class="input--light300">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="alien_status">Changed Residency? </label>
                                                <div class="input__inner">
                                                    <div class="toggleswitch__wrapper">
                                                        <input <?php if ($resident['alien_status'] == "") {
                                                                    echo "unchecked";
                                                                } elseif ($resident['alien_status'] == "Changed Residency") {
                                                                    echo "checked";
                                                                } ?> name="alien_status" type="checkbox" id="alien_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Changed Residency">
                                                        <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                        <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="deceased_status">Deceased?</label>
                                                <div class="input__inner">
                                                    <div class="toggleswitch__wrapper">
                                                        <input <?php if ($resident['deceased_status'] == "") {
                                                                    echo "unchecked";
                                                                } elseif ($resident['deceased_status'] == "Deceased") {
                                                                    echo "checked";
                                                                } ?> name="deceased_status" type="checkbox" id="deceased_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Deceased">
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
                                                    <input type="date" id="date_of_death" name="date_of_death" class="input--light300" value="<?php echo $resident['date_of_death'] ?>" <?php if ($resident['deceased_status'] == "") {
                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                        } elseif ($resident['deceased_status'] == "Deceased") {
                                                                                                                                                                                            echo "required";
                                                                                                                                                                                        } ?> max="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <br>

                                    <section class="profile-info__basic-info">
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="educational_attainment">Educational Attainment <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="educational_attainment" id="educational_attainment" class="select select--resident-profile" onchange="showInput('educational_attainment', 'other_educational_attainment', 'other-educational-attainment')" required>
                                                            <option selected value="<?php echo $resident['educational_attainment'] ?>" hidden><?php echo $resident['educational_attainment'] ?></option>
                                                            <option value="No Grade Completed">No Grade Completed</option>
                                                            <option value="Elementary Undergraduate">Elementary
                                                                Undergraduate</option>
                                                            <option value="Elementary Graduate">Elementary Graduate</option>
                                                            <option value="Highschool Undergraduate">Highschool
                                                                Undergraduate</option>
                                                            <option value="Highschool Graduate">Highschool Graduate</option>
                                                            <option value="College Undergraduate">College Undergraduate
                                                            </option>
                                                            <option value="Vocational Certification">Vocational Certification
                                                            </option>
                                                            <option value="College Graduate">College Graduate</option>
                                                            <option value="Post Baccalaureate">Post Baccalaureate</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container" id="other_educational_attainment" style="display:none">
                                            <div class="input__wrapper">
                                                <label for="other_educational_attainment">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="other_educational_attainment" id="other-educational-attainment" title="Numbers and Special Characters are not allowed." class="input--light300">
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
                                                <label for="purok">Purok Name / Zone No. <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="purok" id="purok" class="select select--resident-profile" required>
                                                            <option selected hidden value="<?php echo $resident['purok'] ?>">
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
                                                            <option value="Purok 16">Purok 16</option>
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
                                                <label for="street">Street / Block <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="street" id="street" title="Special Characters are not allowed." class="input--light300" value="<?php echo $resident['street'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="lot_number">Lot No. / Street No. / Unit No.</label>
                                                <div class="input__inner">
                                                    <input type="text" name="lot_number" id="lot_number" title="Special Characters are not allowed." class="input--light300" pattern="[a-zA-Z0-9 -]+" value="<?php echo $resident['lot_number'] ?>" placeholder="Lot">
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
                                                <label for="phone_number">Phone Number <small style="font-style: italic">(i.e. 09234557345)</small> <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="phone_number" id="phone_number" title="Characters are not allowed." class="input--light300" value="<?php echo $resident['phone_number'] ?>" placeholder="09XXXXXXXXX" maxlength="11" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="tel_number">Tel. Number <small style="font-style: italic">(i.e. 083-552-5555)</small></label>
                                                <div class="input__inner">
                                                    <input type="text" name="tel_number" id="tel_number" title="Characters are not allowed." class="input--light300" title="Characters are not allowed. Please input 10 digit number. Format: 083-552-5555" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" value="<?php echo $resident['tel_number'] ?>" oninvalid="this.setCustomValidity('Characters are not allowed. Please input 10 digit number. Format: 083-552-5555')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="email">Email Address <small style="font-style: italic">(i.e. myemail@gmail.com)</small></label>
                                                <div class="input__inner">
                                                    <input type="email" name="email" id="email" title="i.e. myemail@gmail.com" class="input--light300" title="i.e. examplegmail@gmail.com" pattern="[A-Za-z0-9-._]+@[A-Za-z0-9.-_]+\.[a-zA-Z]{2,}" value="<?php echo $resident['email'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <input <?php if ($resident['senior_status'] == "") {
                                                    echo "unchecked";
                                                } elseif ($resident['senior_status'] == "Senior Citizen") {
                                                    echo "checked";
                                                } ?> hidden name="senior_status" type="checkbox" id="senior_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile scToggle" value="Senior Citizen">
                                    </section>

                                    <div class="pagination__buttons">
                                        <span class="pagination__button next" data-current-tab="basicInfoTab" data-next-tab="votingTab">Next<i class='bx bx-chevron-right'></i></span>
                                    </div>

                                </div>

                                <div class=" profile-info__content votingTab">
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
                                                                } ?> name="voter_status" type="checkbox" id="voter_status" class="toggleswitch toggleswitch--resident-profile input-viewprofile regVoterToggle" value="Registered Voter">
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
                                                    <input type="text" id="voter_id" name="voter_id" title="Special Characters are not allowed." class="input--light300" value="<?php echo $resident['voter_id'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="precinct_number">Precinct Number</label>
                                                <div class="input__inner">
                                                    <input type="text" id="precinct_number" name="precinct_number" title="Special Characters are not allowed." class="input--light300" value="<?php echo $resident['precinct_number'] ?>">
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
                                                                } elseif ($resident['vaccine_status'] == "Vaccinated") {
                                                                    echo "checked";
                                                                } ?> name="vaccine_status" id="vaccine_status" type="checkbox" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Vaccinated">
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
                                                        <select name="vaccine_1" id="vaccine_1" class="select select--resident-profile" required>
                                                            <option selected value="<?php echo $resident['vaccine_1'] ?>" hidden>
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
                                                <label for="vaccine_date_1">First Dose Date <small style="font-style: italic"> (DD - MM - YYYY) </small></strong></label>
                                                <div class="input__inner">
                                                    <input type="date" id="vaccine_date_1" name="vaccine_date_1" class="input--light300" value="<?php echo $resident['vaccine_date_1'] ?>" min="2019-12-31" max="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="vaccine_2">Second Dose Vaccine</label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="vaccine_2" id="vaccine_2" class="select select--resident-profile">
                                                            <option selected value="<?php echo $resident['vaccine_2'] ?>" hidden>
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
                                                    <input type="date" id="vaccine_date_2" name="vaccine_date_2" class="input--light300" value="<?php echo $resident['vaccine_date_2'] ?>" min="<?php echo $resident['vaccine_date_1'] ?>" max="<?php echo date('Y-m-d'); ?>">
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
                                                        <?php if ($resident['booster_status'] == "") { ?>
                                                            <input name="booster_status" id="booster_status" type="checkbox" unchecked class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Boostered">
                                                            <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                            <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                                        <?php } ?>

                                                        <?php if ($resident['booster_status'] == "Boostered") { ?>
                                                            <input name="booster_status" id="booster_stat" type="checkbox" checked id="" class="toggleswitch toggleswitch--resident-profile input-viewprofile" value="Boostered">
                                                            <label class="toggleswitch__indicator toggleswitch__indicator--off">No</label>
                                                            <label class="toggleswitch__indicator toggleswitch__indicator--on">Yes</label>
                                                        <?php } ?>
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
                                                        <select name="booster_1" id="booster_1" class="select select--resident-profile" required>
                                                            <option selected value="<?php echo $resident['booster_1'] ?>" hidden>
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
                                                    <input type="date" id="booster_date_1" name="booster_date_1" class="input--light300" value="<?php echo $resident['booster_date_1'] ?>" min="2019-12-31" max="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="booster_2">Second Dose Vaccine</label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="booster_2" id="booster_2" class="select select--resident-profile">
                                                            <option selected value="<?php echo $resident['booster_2'] ?>" hidden>
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
                                                    <input type="date" id="booster_date_2" name="booster_date_2" class="input--light300" value="<?php echo $resident['booster_date_2'] ?>" min="<?php echo $resident['booster_date_1'] ?>" max="<?php echo date('Y-m-d'); ?>">
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
                                                <label for="emergency-person">Emergency Contact Person <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="emergency_person" id="emergency-person" title="Numbers and Special Characters are not allowed." class="input--light300" placeholder="Enter Full Name" value="<?php echo $resident['emergency_person'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="relationship">Relationship</label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="relationship" id="relationship" class="select select--resident-profile" onchange="showInput('relationship', 'other_relationship', 'other-relationship')">
                                                            <option selected hidden value="<?php echo $resident['relationship'] ?>"><?php echo $resident['relationship'] ?: 'Select' ?></option>
                                                            <option value="Mother">Mother</option>
                                                            <option value="Father">Father</option>
                                                            <option value="Grandmother">Grandmother</option>
                                                            <option value="Grandfather">Grandfather</option>
                                                            <option value="Sibling">Sibling</option>
                                                            <option value="Spouse">Spouse</option>
                                                            <option value="Child">Child</option>
                                                            <option value="Aunt">Aunt</option>
                                                            <option value="Uncle">Uncle</option>
                                                            <option value="Cousin">Cousin</option>
                                                            <option value="Friend">Friend</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container" id="other_relationship" style="display:none">
                                            <div class="input__wrapper">
                                                <label for="other-relationship">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="other_relationship" id="other-relationship" title="Numbers and Special Characters are not allowed." class="input--light300">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="emergency_address">Address <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="emergency_address" id="emergency-address" title="Special Characters are not allowed." class="input--light300" value="<?php echo $resident['emergency_address'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="emergency_contact">Contact Number <small style="font-style: italic">(i.e. 09234557345)</small> <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="emergency_contact" id="emergency-contact" title="Characters are not allowed" class="input--light300" placeholder="09XXXXXXXXX" maxlength="11" value="<?php echo $resident['emergency_contact'] ?>" required>
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

                        <div class="card__footer residentProfileFooter">
                            <div class="card__footer-content">
                                <div class="card__footer-content--right">
                                    <button type="submit" name="submit" class="button button--primary button--md">SAVE</button>
                                    <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal__wrapper" id="modal-change-image">
                        <section class="modal__window modal__window--sm">
                            <header class="modal__header">
                                <button type="button" class="modal__close close" aria-label="Close modal window" onClick="exit_webcam();">
                                    <i class='bx bx-x'></i>
                                </button>
                            </header>

                            <div class="modal__body">
                                <div class="input__wrapper" style="margin-bottom: 10px;">
                                    <div class="input__inner">
                                        <input type="file" class="input--light300">
                                    </div>
                                </div>
                                or

                                <a class="button button--md button--light modal-trigger" style="margin-top: 10px;" data-modal-id="modal-camera" onclick="open_cam()">Open Camera</a>
                            </div>

                            <footer class="modal__footer">
                                <input type="button" value="Cancel" class="button button--dark button--md close" onClick="exit_webcam()" />
                            </footer>

                        </section>
                    </div>

                    <div class="modal__wrapper" id="modal-camera">
                        <section class="modal__window modal__window--md">
                            <header class="modal__header">
                                <h3>Camera</h3>
                                <button type="button" class="modal__close close" aria-label="Close modal window" onClick="exit_webcam()">
                                    <i class='bx bx-x'></i>
                                </button>
                            </header>

                            <div class="modal__body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="my_camera"></div>
                                        <br />
                                        <input type="hidden" name="image" class="image-tag">
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-12 text-center">
                                        <br />
                                    </div>
                                </div>
                            </div>

                            <footer class="modal__footer">
                                <input type="button" value="Capture" class="button button--primary button--md close" onClick="take_snapshot();" />
                                <input type="button" value="Cancel" class="button button--dark button--md close" onClick="exit_webcam();" />
                            </footer>
                        </section>
                    </div>
                </form>
            </section>
        </div>
    </main>

<?php }
?>
<?php if (isset($_SESSION['duplicate'])) { ?>
    <!-- ALERT -->
    <div class="alert alert--danger">
        <i class='bx bxs-error alert__icon'></i>
        <div class="alert__message">
            <?php
            $error = $_SESSION['duplicate'];
            unset($_SESSION['duplicate']);
            echo $error;
            ?>
        </div>
    </div>
<?php } ?>

</body>

</html>