<?php
$page = 'Certificates';
$headerTitle = 'Jobseeker Certificate';

require_once "../../includes/header.php";
require "../../includes/preloader.php";
?>

<main>
    <div class="content" id="content-certificates">
        <section class="certificates__info">
            <div class="card">
                <button class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
                    <i class='bx bx-left-arrow-circle'></i>
                    Back
                </button>
                <?php
                if (filter_has_var(INPUT_GET, 'resident_id')) {
                    $sanitize_id = filter_var($_GET['resident_id'], FILTER_SANITIZE_NUMBER_INT);
                    $resident_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);
                }


                $query = "SELECT * FROM resident WHERE resident_id = :resident_id";
                $statement = $pdo->prepare($query);
                $statement->bindParam(':resident_id', $resident_id);
                $statement->execute();

                while ($residents = $statement->fetch(PDO::FETCH_ASSOC)) {

                    $nationality = $residents['nationality'] ?: 'Filipino';
                    $purok = $residents['purok'] ? $residents['purok'] . ', ' : '';
                    $street = $residents['street'] ? $residents['street'] . ', ' : '';
                    $lot_number = $residents['lot_number'] ? $residents['lot_number'] . ', ' : '';

                ?>
                    <div class="card__body">
                        <form id="" action="generate/generate-jobseeker.php" method="post">
                            <div class="card__body-content">

                                <div class="profile__img profile__img--change">
                                    <img src="../residents/images/<?php echo $residents['img_url'] ?>" name="default" alt="">

                                    <input type="hidden" name="pic" value="<?php echo $residents['img_url'] ?>" />
                                </div>
                            </div>

                            <div class="center">
                                <div class="profile__name" style="margin: 20px 0px 30px 0px;">
                                    <?php echo $residents['last_name'] ?>,
                                    <?php echo $residents['first_name'] ?>
                                    <?php echo $residents['mid_name'] ? mb_substr($residents['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                    <?php echo $residents['suffix'] ?>
                                </div>
                            </div>

                            <div class="certificates-info__content">
                                <section class="certificates-info">
                                    <div class="certificates-info__container">
                                        <!-- hidden -->
                                        <div class="cert-info">
                                            <input type="hidden" name="resident_id" value="<?php echo $residents['resident_id'] ?>" />
                                        </div>
                                        <div class="cert-info">
                                            <input type="hidden" name="civil_status" value="<?php echo $residents['civil_status'] ?>" />
                                        </div>

                                        <div class="cert-info">
                                            <input type="hidden" name="nationality" value="<?php echo $nationality ?>" />
                                        </div>
                                        <div class="cert-info">
                                            <input type="hidden" name="age" id="age" class="input--light300 input-viewprofile dob" value="<?php echo calculate_age($residents['date_of_birth']) ?>">
                                        </div>

                                        <!-- hidden -->

                                        <div class="input__wrapper">
                                            <label>Name</label>
                                            <div class="input__inner">
                                                <input readonly name="name1" type="text" required class="input--light300 input-viewprofile" value="<?php echo $residents['last_name'] ?>, <?php echo $residents['first_name'] ?> <?php echo $residents['mid_name'] ? mb_substr($residents['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?> <?php echo $residents['suffix'] ?? "" ?>">

                                                <input type="hidden" name="first_name" id="first_name" class="input--light300" value="<?php echo $residents['first_name'] ?>" required>

                                                <input type="hidden" name="mid_name" id="mid_name" class="input--light300" value="<?php echo $residents['mid_name'] ?>">

                                                <input type="hidden" name="last_name" id="last_name" class="input--light300" value="<?php echo $residents['last_name'] ?>" required>

                                                <input type="hidden" name="suffix" id="suffix" class="input--light300" value="<?php echo $residents['suffix'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="certificates-info__container">
                                        <div class="input__wrapper">
                                            <label>Address</label>
                                            <div class="input__inner">
                                                <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $purok ?><?php echo $street ?><?php echo $lot_number ?>Barangay Fatima, General Santos City">

                                                <input type="text" hidden name="address" value="<?php echo $purok ?><?php echo $street ?><?php echo $lot_number ?>Barangay Fatima, General Santos City">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="certificates-info__container">
                                        <div class="input__wrapper">
                                            <label>Date of Residency <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <input name="date_of_residency" type="date" class="input--light300 input-viewprofile" autofocus required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="certificates-info__container">
                                        <div class="input__wrapper">
                                            <label>Date Issued</label>
                                            <div class="input__inner">
                                                <input readonly name="date_issued" type="datetime" class="input--light300 input-viewprofile" value="<?php echo date('Y-m-d H:i:s'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </section>

                                <div class="card__footer">
                                    <div class="card__footer-content">
                                        <div class="card__footer-content--right">
                                            <button class="button button--primary button--md" name="btn_save">GENERATE</button>
                                            <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </section>
    </div>
</main>

<!--=============== MODALS ===============-->
<?php
include "../../includes/modal-cancel.php";
?>

</body>

</html>