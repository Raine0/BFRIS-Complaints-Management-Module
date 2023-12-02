<?php
$headerTitle = 'Low Income Certificate';
$page = 'Certificate';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'low_income_id')) {
    $clean_low_income_id = filter_var($_GET['low_income_id'], FILTER_SANITIZE_NUMBER_INT);
    $low_income_id = filter_var($clean_low_income_id, FILTER_VALIDATE_INT);
}

?>

<main>
    <div class="content" id="content-certificates">
        <section class="certificates__info">
            <div class="card">
                <a class="button button--md back-btn">
                    <?php require "../../includes/back-button.php"; ?>
                </a>

                <?php
                $lowIncomeQuery = "SELECT oc.*, r1.last_name, r1.first_name, r1.mid_name, r1.suffix, r2.last_name AS official_lastname, r2.first_name AS official_firstname, r2.mid_name AS official_midname, r2.suffix AS official_suffix, r1.img_url, r1.purok, r1.street, r1.lot_number FROM low_income_certificate oc 
                LEFT JOIN resident r1 ON r1.resident_id = oc.resident_id 
                LEFT JOIN official o ON o.official_id = oc.official_id
                LEFT JOIN resident r2 ON r2.resident_id = o.resident_id
                WHERE oc.low_income_id = :low_income_id ORDER BY oc.date_issued DESC";

                $lowIncomeStatement = $pdo->prepare($lowIncomeQuery);
                $lowIncomeStatement->bindParam(':low_income_id', $low_income_id, PDO::PARAM_INT);
                $lowIncomeStatement->execute();

                $lowIncomeCount = $lowIncomeStatement->rowCount();

                if ($lowIncomeCount === 1) {
                    $lowIncome = $lowIncomeStatement->fetch(PDO::FETCH_ASSOC);

                    $purok = $lowIncome['purok'] ? $lowIncome['purok'] . ', ' : '';
                    $street = $lowIncome['street'] ? $lowIncome['street'] . ', ' : '';
                    $lot_number = $lowIncome['lot_number'] ? $lowIncome['lot_number'] . ', ' : '';
                    $purpose = $lowIncome['purpose'];
                    $date_of_residency = $lowIncome['date_of_residency'];
                    $issued_by = $lowIncome['issued_by'];
                    $date_issued = $lowIncome['date_issued'];
                    $resident_image = $lowIncome['img_url'];
                ?>

                    <div class="info">
                        <h4><strong>Issued By:</strong></h4>
                        <div>
                            <?php echo $lowIncome['official_lastname'] ?>,
                            <?php echo $lowIncome['official_firstname'] ?>
                            <?php echo $lowIncome['official_midname'] ? mb_substr($lowIncome['official_midname'], 0, 1, 'UTF-8')  . "." : "" ?>
                            <?php echo $lowIncome['official_suffix'] ?>
                        </div>
                        <p><?php echo $issued_by ?></p>
                        <h4><strong>Date Issued:</strong></h4>
                        <p><?php echo date('m-d-Y', strtotime($date_issued)); ?></p>

                        <a class="button button--info button--md modal-trigger" data-modal-id="modal-low-income-history">
                            <i class='bx bxs-book-bookmark' data-modal-id="modal-low-income-history"></i>
                            HISTORY
                        </a>
                    </div>

                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--change">
                                <img src="../residents/images/<?php echo $resident_image ?>" name="default" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $lowIncome['last_name'] ?>,
                                <?php echo $lowIncome['first_name'] ?>
                                <?php echo $lowIncome['mid_name'] ? mb_substr($lowIncome['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                <?php echo $lowIncome['suffix'] ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="action__cert">
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                    <a href="regenerate/regenerate-low-income.php?low_income_id=<?php echo $low_income_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $lowIncome['date_issued'] ?>">
                                        <i class='bx bxs-file-blank'></i>
                                        REGENERATE
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <br>
                        <br>
                        
                        <div class="certificates-info__content">
                            <section class="certificates-info">
                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Name</label>
                                        <div class="input__inner">
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $lowIncome['last_name'] ?>, <?php echo $lowIncome['first_name'] ?> <?php echo $lowIncome['mid_name'] ? mb_substr($lowIncome['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?> <?php echo $lowIncome['suffix'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Address</label>
                                        <div class="input__inner">
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $purok ?> <?php echo $street ?> <?php echo $lot_number ?>Barangay Fatima, General Santos City">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Date Issued</label>
                                        <div class="input__inner">
                                            <input name="date_issued" class="input--light300 input-viewprofile" value="<?php echo $date_issued ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Purpose </label>
                                        <div class="input__inner">
                                            <input name="purpose" type="text" class="input--light300 input-viewprofile" value="<?php echo $purpose ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Date of Residency </label>
                                        <div class="input__inner">
                                            <input name="date_of_residency" type="text" class="input--light300 input-viewprofile" value="<?php echo $date_of_residency ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <?php require './modals/history/low-income-history.php'; ?>
                <?php } ?>
            </div>
        </section>
    </div>
</main>
</body>

</html>