<?php
$page = 'Complaints';
$headerTitle = 'Add New Complaint';

require "../../includes/header.php";
require "../../includes/preloader.php";
require "../../includes/modal-cancel.php";

if (filter_has_var(INPUT_GET, 'complainant_id') && filter_has_var(INPUT_GET, 'respondent_id') && filter_has_var(INPUT_GET, 'mediator_id')) {

    //Complainant
    $clean_complainant_resident_id = filter_var($_GET['complainant_id'], FILTER_SANITIZE_NUMBER_INT);
    $complainant_resident_id = filter_var($clean_complainant_resident_id, FILTER_VALIDATE_INT);

    $complainantresidentQuery = "SELECT resident_id, first_name, last_name, mid_name, suffix, street, purok, lot_number FROM resident WHERE resident_id = :resident_id";
    $complainantresidentStatement = $pdo->prepare($complainantresidentQuery);
    $complainantresidentStatement->bindParam(':resident_id', $complainant_resident_id);
    $complainantresidentStatement->execute();

    $complainantresidentCount = $complainantresidentStatement->rowCount();

    if ($complainantresidentCount === 1) {
        $complainantResident = $complainantresidentStatement->fetch(PDO::FETCH_ASSOC);
    }

    //Respondent
    $clean_respondent_resident_id = filter_var($_GET['respondent_id'], FILTER_SANITIZE_NUMBER_INT);
    $respondent_resident_id = filter_var($clean_respondent_resident_id, FILTER_VALIDATE_INT);

    $respondentresidentQuery = "SELECT resident_id, first_name, last_name, mid_name, suffix, purok, street, lot_number, img_url FROM resident WHERE resident_id = :resident_id";
    $respondentresidentStatement = $pdo->prepare($respondentresidentQuery);
    $respondentresidentStatement->bindParam(':resident_id', $respondent_resident_id);
    $respondentresidentStatement->execute();

    $respondentresidentCount = $respondentresidentStatement->rowCount();

    if ($respondentresidentCount === 1) {
        $respondentResident = $respondentresidentStatement->fetch(PDO::FETCH_ASSOC);
    }

    //Mediator
    $clean_mediator_resident_id = filter_var($_GET['mediator_id'], FILTER_SANITIZE_NUMBER_INT);
    $mediator_official_id = filter_var($clean_mediator_resident_id, FILTER_VALIDATE_INT);

    $mediatorQuery = "SELECT resident_id, official_id, first_name, last_name, mid_name, suffix, off_position FROM official_view WHERE official_id = :mediator_official_id";

    $mediatorStatement = $pdo->prepare($mediatorQuery);
    $mediatorStatement->bindParam(':mediator_official_id', $mediator_official_id);
    $mediatorStatement->execute();

    if (!$mediatorStatement->rowCount() === 1) {
        header('location: ./');
        exit();
    }

    $mediator = $mediatorStatement->fetch(PDO::FETCH_ASSOC);
}
?>

<main>
    <div class="content">
        <section class="residents">
            <form id="form" method="POST" action="controller/resident-complaint-create.php" enctype="multipart/form-data" data-parsley-validate="">
                <div>
                    <div class="card">
                        <a class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
                            <i class='bx bx-left-arrow-circle' data-modal-id="modal-cancel"></i>
                            Back
                        </a>

                        <div class="card__body">
                            <div class="card__body-content">
                                <div class="profile__img profile__img--viewprofile">
                                    <img src="./../residents/images/<?php echo $respondentResident["img_url"]; ?>" alt="">
                                </div>

                                <div class="profile__name profile__name--viewprofile">
                                    <?php echo $respondentResident['last_name'] ?>,
                                    <?php echo $respondentResident['first_name'] ?>
                                    <?php echo $respondentResident['mid_name'] ? mb_substr($respondentResident['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                    <?php echo $respondentResident['suffix'] ?>
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
                                                <label for="complainant">Complainant's Name</label>
                                                <div class="input__inner">
                                                    <input type="text" name="complainant" id="complainant" class="input--light300" value="<?php echo $complainantResident['last_name'] ?>, <?php echo $complainantResident['first_name'] ?> <?php echo $complainantResident['mid_name'] ? mb_substr($complainantResident['mid_name'], 0, 1, 'UTF-8')  : '' ?> <?php echo $complainantResident['suffix'] ?>" disabled>
                                                </div>
                                                <input type="hidden" name="complainant-id" value="<?php echo $complainantResident['resident_id'] ?>">
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="complainant-address">Address</label>
                                                <div class="input__inner">
                                                    <input type="text" name="complainant_address" id="complainant-address" class="input--light300 input-viewprofile" value="<?php echo $complainantResident['purok'] ?>, <?php echo $complainantResident['street'] ?>, <?php echo $complainantResident['lot_number'] ?>" disabled>
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
                                                    <input type="text" name="respondent" id="respondent" class="input--light300" value="<?php echo $respondentResident['last_name'] ?>, <?php echo $respondentResident['first_name'] ?> <?php echo $respondentResident['mid_name'] ? mb_substr($respondentResident['mid_name'], 0, 1, 'UTF-8')  : '' ?> <?php echo $respondentResident['suffix'] ?>" disabled>
                                                </div>
                                                <input type="hidden" name="respondent-id" value="<?php echo $respondentResident['resident_id'] ?>">
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="respondent-address">Address</label>
                                                <div class="input__inner">
                                                    <input type="text" name="respondent_address" id="respondent-address" class="input--light300 input-viewprofile" value="<?php echo $respondentResident['purok'] ?>, <?php echo $respondentResident['street'] ?>, <?php echo $respondentResident['lot_number'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <input type="text" name="mediator" id="mediator" class="input--light300" value="<?php echo $mediator['last_name'] ?>, <?php echo $mediator['first_name'] ?> <?php echo $mediator['mid_name'] ? mb_substr($mediator['mid_name'], 0, 1, 'UTF-8')  : '' ?> <?php echo $mediator['suffix'] ?>" readonly>
                                                </div>
                                                <input type="hidden" name="mediator-id" value="<?php echo $mediator['official_id'] ?>">
                                                <input type="hidden" name="official-resident-id" value="<?php echo $mediator['resident_id'] ?>">
                                            </div>
                                        </div>

                                        <!-- <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="off_position">Position</label>
                                                <div class="input__inner">
                                                    <input type="text" name="off_position" id="off_position" class="input--light300" value="<?php echo $mediator['off_position'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div> -->
                                    </section>

                                    <br>
                                    <div class="profile-info__sub-section">
                                        Complaint Information
                                    </div>
                                    <br>

                                    <section class="profile-info__basic-info">
                                        <div class="certificates-info__container">
                                            <div class="input__wrapper">
                                                <label>O.R No. <small style="font-style: italic">(i.e. 2342343A) </small><strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input type="text" name="receipt_number" id="receipt-number" title="Special Characters are not allowed." class="input--light300 input-viewprofile" maxlength="8" required autofocus />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">           
                                            <div class="input__wrapper">
                                                <label for="for">FOR <strong style="color:red;">*</strong></label>
                                                <div class="input__wrapper">
                                                    <div class="select__wrapper">
                                                        <select name="for" id="for" class="select select--resident-profile" required>
                                                            <!-- <option disabled hidden>Select</option> -->
                                                            <option value="Unjust Vexation" selected>Unjust Vexation</option>
                                                            <option value="Malicious Mischief">Malicious Mischief</option>
                                                            <option value="Physical Injury">Physical Injury</option>
                                                            <option value="Demand for Payment">Demand for Payment</option>
                                                            <option value="Threat">Threat</option>
                                                            <option value="Harassment">Harassment</option>
                                                            <option value="Scandal">Scandal</option>
                                                            <option value="Oral Defamation">Oral Defamation</option>
                                                            <option value="Cyber Libel">Cyber Libel</option>
                                                            <option value="Settled Mediation">Settled Mediation</option>
                                                            <option value="Online Libel">Online Libel</option>
                                                            <option value="Ejectment">Ejectment</option>
                                                            <option value="Trespassing">Trespassing</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Adjust time -->
                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label>Date of Hearing <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input name="date_of_hearing" type="date" min="<?php echo date('Y-m-d') ?>" class="input--light300 input-viewprofile" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label>Time of Hearing <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <input name="time_of_hearing" type="time" class="input--light300 input-viewprofile" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="status">Status <strong style="color:red;">*</strong></label>
                                                <div class="input__inner">
                                                    <div class="select__wrapper">
                                                        <select name="status" id="status" class="select select--resident-profile" required>
                                                            <option disabled hidden>Select</option>
                                                            <option value="1st Mediation" selected>1st Mediation</option>
                                                            <option value="2nd Mediation">2nd Mediation</option>
                                                            <option value="3rd Mediation">3rd Mediation</option>
                                                            <option value="1st Conciliation">1st Conciliation</option>
                                                            <option value="2nd Conciliation">2nd Conciliation</option>
                                                            <option value="3rd Conciliation">3rd Conciliation</option>
                                                            <option value="Certification of File Action">Certification of File Action</option>
                                                            <option value="Settled Concillation">Settled Concillation</option>
                                                            <option value="Settled Mediation">Settled Mediation</option>
                                                            <option value="Case Dissmissed/Withdraw">Case Dissmissed/Withdraw</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="action-taken">Action Taken</label>
                                                <div class="input__inner">
                                                    <textarea name="action_taken" id="action-taken" class="input--light300" value="<?php echo $complaint['action_taken'] ?>">
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
                                                    <textarea name="description" id="description" class="input--light300" required>
                                                </textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="profile-info__container">
                                            <div class="input__wrapper">
                                                <label for="grant">THEREFORE, I/WE pray that the following reliefs be granted on me/us in accordance with law and/or equity.</label>
                                                <div class="input__inner">
                                                    <textarea name="grant" id="grant" class="input--light300">
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

                        <div class="card__footer residentProfileFooter">
                            <div class="card__footer-content">
                                <div class="card__footer-content--right">
                                    <button type="submit" id="submit" name="submit" class="button button--primary button--md">SAVE</button>
                                    <button type="submit" class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</button>
                                </div>
                            </div>
                            <!-- card end -->
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>


</body>

</html>