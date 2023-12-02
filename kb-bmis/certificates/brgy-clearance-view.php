<?php
$headerTitle = 'Barangay Clearance';
$page = 'Certificate';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'brgy_clearance_id')) {
    $brgy_clearance_id = $_GET['brgy_clearance_id'];
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
                $clearanceQuery = "SELECT resident_id, resident_name, official_name, address, purpose, category, receipt_number, cedula_number, cedula_issued_at, cedula_date, issued_by, date_issued, resident_image FROM brgy_clearance_view
                WHERE brgy_clearance_id = :brgy_clearance_id";

                $clearanceStatement = $pdo->prepare($clearanceQuery);
                $clearanceStatement->bindParam(':brgy_clearance_id', $brgy_clearance_id, PDO::PARAM_INT);
                $clearanceStatement->execute();

                $clearanceCount = $clearanceStatement->rowCount();

                if ($clearanceCount === 1) {
                    $clearance = $clearanceStatement->fetch(PDO::FETCH_ASSOC);

                    $resident_name = $clearance['resident_name'];
                    $official_name = $clearance['official_name'];
                    $address = $clearance['address'];
                    $purpose = $clearance['purpose'];
                    $category = $clearance['category'];
                    $receipt_number = $clearance['receipt_number'];
                    $cedula_number = $clearance['cedula_number'];
                    $cedula_place = $clearance['cedula_issued_at'];
                    $cedula_date = $clearance['cedula_date'];
                    $issued_by = $clearance['issued_by'];
                    $date_issued = $clearance['date_issued'];
                    $img_url = $clearance['resident_image'];
                ?>

                    <div class="info">
                        <h4><strong>Issued By:</strong></h4>
                        <div>
                            <?php echo $official_name ?>
                        </div>
                        <p>
                            <?php echo $issued_by ?>
                        </p>
                        <h4><strong>Date Issued:</strong></h4>
                        <p><?php echo date('m-d-Y', strtotime($date_issued)); ?></p>

                        <a class="button button--info button--md modal-trigger" data-modal-id="modal-brgy-clearance-history" id="resident-history">
                            <i class='bx bxs-book-bookmark' data-modal-id="modal-brgy-clearance-history"></i>
                            HISTORY
                        </a>
                    </div>

                    <div class="card__body">
                        <div class="card__body-content">

                            <div class="profile__img profile__img--change">
                                <img src="../residents/images/<?php echo $img_url ?>" name="default" alt="">
                            </div>
                        </div>

                        <div class="center">
                            <div class="profile__name" style="margin: 20px 0px 30px 0px;">
                                <?php echo $resident_name ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="action__cert">
                                <?php if ($user_role == 'Barangay Clerk - Generate Clearance' || $user_role == 'Barangay Secretary' || $user_role == 'Administrator') { ?>
                                    <a href="regenerate/regenerate-brgy-clearance.php?brgy_clearance_id=<?php echo $brgy_clearance_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $clearance['date_issued'] ?>">
                                        <i class='bx bxs-file-blank'></i>
                                        REGENERATE
                                    </a>
                                <?php } ?>

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
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $resident_name ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Address</label>
                                        <div class="input__inner">
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $address ?>">
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
                            </section>

                            <section class="certificates-info" style="margin-top: 10px;">

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Certificate Category</label>
                                        <div class="input__inner">
                                            <input name="certificate_category" type="text" class="input--light300 input-viewprofile" value="<?php echo $category ?>" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>O.R No.</label>
                                        <div class="input__inner">
                                            <input name="receipt_number" type="text" class="input--light300 input-viewprofile" value="<?php echo $receipt_number ?>" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Cedula No.</label>
                                        <div class="input__inner">
                                            <input name="cedula_number" type="text" class="input--light300 input-viewprofile" pattern="[0-9]{8}" maxLength="8" value="<?php echo $cedula_number ?>" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Cedula Issued at</label>
                                        <div class="input__inner">
                                            <input name="cedula_address" type="text" class="input--light300 input-viewprofile" value="<?php echo $cedula_place ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Cedula Issued on</label>
                                        <div class="input__inner">
                                            <input name="cedula_date" type="date" class="input--light300 input-viewprofile" value="<?php echo $cedula_date ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <?php require './modals/history/brgy-clearance-history.php'; ?>
                <?php } ?>
            </div>
        </section>
    </div>
</main>

</body>

</html>