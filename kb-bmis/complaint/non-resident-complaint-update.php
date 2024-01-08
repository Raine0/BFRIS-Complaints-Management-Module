<?php
$page = 'Complaints';
$headerTitle = 'Update Complaint';

require "../../includes/header.php";
require "../../includes/preloader.php";
require "../../includes/modal-cancel.php";

if (filter_has_var(INPUT_GET, 'case_no')) {

    //Complaint
    $clean_case_no = filter_var($_GET['case_no'], FILTER_SANITIZE_NUMBER_INT);
    $case_no = filter_var($clean_case_no, FILTER_VALIDATE_INT);

    $complaintQuery = "SELECT * from non_resident_complaint_view WHERE case_no = :case_no";

    $complaintStatement = $pdo->prepare($complaintQuery);
    $complaintStatement->bindParam(':case_no', $case_no);
    $complaintStatement->execute();

    $complaintCount = $complaintStatement->rowCount();

    if (!$complaintCount === 1) {
        $_SESSION['error'] = "Complaint Record Not Found";
        header("location: ./../non-resident-complaint-list.php?case_no=$case_no");
        exit();
    }
    $complaint = $complaintStatement->fetch(PDO::FETCH_ASSOC);

    $nonresidentQuery = "SELECT * FROM non_resident WHERE non_resident_id = :non_resident_id";
    $nonresidentStatement = $pdo->prepare($nonresidentQuery);
    $nonresidentStatement->bindParam(':non_resident_id', $complaint['complainant_non_resident_id'], PDO::PARAM_INT);
    $nonresidentStatement->execute();

    $nonresidentCount = $nonresidentStatement->rowCount();
    if (!$nonresidentCount === 1) {
        $_SESSION['error'] = "Complainant Record Not Found";
        header("location: ./../non-resident-complaint-list.php?case_no=$case_no");
        exit();
    }

    $nonresident = $nonresidentStatement->fetch(PDO::FETCH_ASSOC);

    // Fetch the current complaint status from the database
    $complaint_status = $complaint['complaint_status'];
}
?>

<main>
    <div class="content">
        <section class="residents">
            <form id="form" method="POST" action="./controller/non-resident-complaint-update.php" enctype="multipart/form-data" data-parsley-validate="">
                <div>
                    <div class="card">
                        <a class="button button--md back-btn">
                            <?php require '../../includes/back-button.php'; ?>
                        </a>

                        <div class="card__body">
                            <div class="card__body-content">

                                <div class="profile__img profile__img--viewprofile">
                                    <img src="./../residents/images/<?php echo $complaint["respondent_image"]; ?>" alt="">
                                </div>

                                <div class="profile__name profile__name--viewprofile">
                                    <?php echo $complaint['respondent_name'] ?>
                                </div>

                                <ul class="profile-info__list">
                                    <li class="profile-info__item profile-info__item--active basicInfoTab">
                                        <span>
                                            Basic Information
                                        </span>
                                    </li>

                                    <li class="profile-info__item statementTab">
                                        <span>
                                            Statement
                                        </span>
                                    </li>

                                </ul>

                                <div class="profile-info__content basicInfoTab" style="display: block;">
                                    <div class="profile-info__sub-section">
                                        Complainant
                                    </div>
                                    <br>

                                    <section class="profile-info__basic-info">
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="first_name">First Name <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="first_name" id="first_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $nonresident['first_name'] ?>" required autofocus>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="mid_name">Middle Name</label>
                                                <div class="input__inner">
                                                    <input type="text" name="mid_name" id="mid_name" class="input--light300" title="Avoid inputting whitespaces." value="<?php echo $nonresident['mid_name'] ?>" pattern="[a-zA-z -ñÑ]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed. Avoid inputting whitespaces.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="last_name">Last Name <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="last_name" id="last_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $nonresident['last_name'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="suffix">Suffix <small style="font-style: italic"> (i.e. Sr., Jr., II, III) </small></label>
                                                <div class="input__inner">
                                                    <input type="text" name="suffix" id="suffix" class="input--light300" title="Avoid inputting whitespaces." value="<?php echo $nonresident['suffix'] ?>" pattern="[a-zA-z .ñÑ]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed. Avoid inputting whitespaces.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')" maxlength="7">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="purok">Purok</label>
                                                <div class="input__inner">
                                                    <input type="text" name="purok" id="purok" title="Special Characters are not allowed." class="input--light300" placeholder="Purok" value="<?php echo $nonresident['purok'] ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="barangay">Barangay<strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="barangay" id="barangay" title="Special Characters are not allowed." class="input--light300" placeholder="Barangay" value="<?php echo $nonresident['barangay'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="city">City<strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="city" id="city" title="Special Characters are not allowed." class="input--light300" placeholder="City" value="<?php echo $nonresident['city'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="province">Province<strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="province" id="province" title="Special Characters are not allowed." class="input--light300" placeholder="Province" value="<?php echo $nonresident['province'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <br>
                                    <div class="profile-info__sub-section">
                                        Respondent
                                    </div>
                                    <br>

                                    <section class="profile-info__basic-info">
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="respondent">Respondent's Name</label>
                                                <div class="input__inner">
                                                    <input type="text" name="respondent" id="respondent" class="input--light300 modal-trigger" data-modal-id="modal-update-respondent" value="<?php echo $complaint['respondent_name'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="respondent-address">Address</label>
                                                <div class="input__inner">
                                                    <input type="text" name="respondent_address" id="respondent-address" class="input--light300 input-viewprofile" value="<?php echo $complaint['respondent_address'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="respondent_resident_id" id="respondent-resident-id" value="">
                                    </section>

                                    <br>
                                    <div class="profile-info__sub-section">
                                        Mediator
                                    </div>
                                    <br>

                                    <section class="profile-info__basic-info">
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="mediator">Mediator's Name</label>
                                                <div class="input__inner">
                                                    <input type="text" name="mediator" id="mediator" class="input--light300 modal-trigger" data-modal-id="modal-update-mediator" value="<?php echo $complaint['mediator_name'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="off_position">Position</label>
                                                <div class="input__inner">
                                                    <input type="text" name="off_position" id="off_position" class="input--light300" value="<?php echo $complaint['off_position'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="mediator_official_id" id="official-id" value="">
                                    </section>

                                    <br>
                                    <div class="profile-info__sub-section">
                                        Complaint Information
                                    </div>
                                    <br>

                                    <section class="profile-info__basic-info">
                                        <div class="certificates-info__container">
                                            <div class="input__wrapper">
                                                <label>O.R No. <small style="font-style: italic">(i.e. 2342343A) </small> <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="receipt_number" class="input--light300 input-viewprofile" maxlength="8" value="<?php echo $complaint['or_no'] ?>" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="for">FOR <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="for" id="for" class="input--light300" value="<?php echo $complaint['reason'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Adjust time -->
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label>Date of Hearing <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input name="date_of_hearing" type="date" class="input--light300 input-viewprofile" value="<?php echo $complaint['date_of_hearing'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label>Time of Hearing <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input name="time_of_hearing" type="time" class="input--light300 input-viewprofile" value="<?php echo $complaint['time_of_hearing'] ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="status">Status <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="status" id="status" class="select select--resident-profile" required>
                                                            <option disabled hidden value="">Select</option>
                                                            <?php
                                                            $statuses = array(
                                                                "1st Mediation",
                                                                "2nd Mediation",
                                                                "3rd Mediation",
                                                                "1st Conciliation",
                                                                "2nd Conciliation",
                                                                "3rd Conciliation",
                                                                "Certification of File Action",
                                                                "Settled Conciliation",
                                                                "Settled Mediation",
                                                                "Case Dissmissed/Withdraw"
                                                            );

                                                            foreach ($statuses as $status) {
                                                                $selected = ($complaint_status == $status) ? 'selected' : '';
                                                                echo "<option value=\"$status\" $selected>$status</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <!-- Debugging information -->
                                                    <p>Current Status: <?php echo $complaint_status; ?></p>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="action-taken">Action Taken</label>
                                                <div class="input__inner">
                                                    <textarea name="action_taken" id="action-taken" class="input--light300" value="<?php echo $complaint['action_taken'] ?>" required><?php echo $complaint['action_taken'] ?>
                                                </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <div class="pagination__buttons">
                                        <span class='pagination__button next' data-current-tab="basicInfoTab" data-next-tab="statementTab">Next<i class='bx bx-chevron-right'></i></span>
                                    </div>
                                </div>

                                <div class="profile-info__content statementTab">
                                    <section class="profile-info__basic-info">
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="description">I/WE hereby complaint against the named respondents for violating my/our rights and interest in the following manner.</label>
                                                <div class="input__inner">
                                                    <textarea name="description" id="description" class="input--light300" value="<?php echo $complaint['complaint_description'] ?>"><?php echo $complaint['complaint_description'] ?>
                                                </textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="grant">THEREFORE, I/WE pray that the following reliefs be granted on me/us in accordance with law and/or equity.</label>
                                                <div class="input__inner">
                                                    <textarea name="grant" id="grant" class="input--light300" disabled>
                                            </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <div class="pagination__buttons">
                                        <span class='pagination__button prev' data-current-tab="statementTab" data-next-tab="basicInfoTab"><i class='bx bx-chevron-left'></i>Prev</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="case_no" value="<?php echo $complaint['case_no'] ?>">
                        <input type="hidden" name="respondent_id" value="<?php echo $complaint['respondent_id'] ?>">
                        <input type="hidden" name="mediator_id" value="<?php echo $complaint['mediator_id'] ?>">
                        <input type="hidden" name="non_resident_id" value="<?php echo $nonresident['non_resident_id'] ?>">

                        <div class="card__footer residentProfileFooter">
                            <div class="card__footer-content">
                                <div class="card__footer-content--right">
                                    <button type="submit" id="submit" class="button button--primary button--md" name="btn_save">SAVE</button>
                                    <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>
<?php require './modal/update-respondent.php'; ?>
<?php require './modal/update-mediator.php'; ?>

</body>

</html>