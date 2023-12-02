<?php
$page = 'Certificates';
$headerTitle = 'Resdency Certificate';

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

                $residents = $statement->fetch(PDO::FETCH_ASSOC);
                $sex = $residents['sex'];
                $nationality = $residents['nationality'] ?: 'Filipino';
                $civil_status = $residents['civil_status'];
                $purok = $residents['purok'] ? $residents['purok'] . ', ' : '';
                $street = $residents['street'] ? $residents['street'] . ', ' : '';
                $lot_number = $residents['lot_number'] ? $residents['lot_number'] . ', ' : '';

                ?>

                <div class="card__body">
                    <form id="" action="generate/generate-residency.php" method="post">
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

                                    <input type="hidden" name="resident_id" value="<?php echo $residents['resident_id'] ?>" />

                                    <input type="hidden" name="civil_status" value="<?php echo $civil_status ?>" />

                                    <input type="hidden" name="nationality" value="<?php echo $nationality ?>" />

                                    <!-- hidden -->

                                    <div class="input__wrapper">
                                        <label>Name</label>
                                        <div class="input__inner">
                                            <input readonly name="name1" type="text" required class="input--light300 input-viewprofile" value="<?php echo $residents['last_name'] ?>, <?php echo $residents['first_name'] ?> <?php echo $residents['mid_name'] ? mb_substr($residents['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?> <?php echo $residents['suffix'] ?>">

                                            <input type="hidden" name="first_name" id="first_name" title="Numbers and Special Characters are not allowed." class="input--light300" pattern="[a-zA-z -]+" value="<?php echo $residents['first_name'] ?>" required>

                                            <input type="hidden" name="mid_name" id="mid_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $residents['mid_name'] ?>" pattern="[a-zA-z -]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')">

                                            <input type="hidden" name="last_name" id="last_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $residents['last_name'] ?>" pattern="[a-zA-z -]+" required>

                                            <input type="hidden" name="suffix" id="suffix" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $residents['suffix'] ?>" pattern="[a-zA-Z. ]+" oninvalid="this.setCustomValidity('Numbers and Special Characters are not allowed.')" onchange="try{setCustomValidity('')}catch(e){}" oninput="setCustomValidity(' ')" maxlength="7">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Address</label>
                                        <div class="input__inner">
                                            <input readonly name="address" type="text" required="" class="input--light300 input-viewprofile" value="<?php echo $purok ?><?php echo $street ?><?php echo $lot_number ?>Barangay Fatima, General Santos City">
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


                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Purpose <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select name="purpose" id="purpose" class="select select--resident-profile" onchange="showInput('purpose', 'other_purpose', 'other-purpose')" required>
                                                    <option selected disabled hidden value="">Select</option>
                                                    <option value="Identification">Identification</option>
                                                    <option value="Water Connection">Water Connection</option>
                                                    <option value="PC">PC</option>
                                                    <option value="Loan">Loan</option>
                                                    <option value="Co-maker">Co-maker</option>
                                                    <option value="Bailbond">Bailbond</option>
                                                    <option value="DSWD Financial Assistance">DSWD Financial Assistance</option>
                                                    <option value="4PS Requirement">4PS Requirement</option>
                                                    <option value="CHED Scholarship">CHED Scholarship</option>
                                                    <option value="DOST Scholarship">DOST Scholarship</option>
                                                    <option value="UNIFAST Scholarship">UNIFAST Scholarship</option>
                                                    <option value="GSIS Scholarship">GSIS Scholarship</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="certificates-info" style="margin-top: 10px;">
                                <div class="profile-info__container" id="other_purpose" style="display:none">
                                    <div class="input__wrapper">
                                        <label for="other-purpose">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input type="text" name="other_purpose" id="other-purpose" title="Numbers and Special Characters are not allowed." class="input--light300" pattern="[a-zA-Z ,-.]+">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Date of Residency <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input type="date" name="date_of_residency" class="input--light300 input-viewprofile" required>
                                        </div>
                                    </div>
                                </div>

                                <input name="fee_setting_id" id="fee-setting-id" type="hidden" value="">

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Fee <strong style="color:red;">*</strong></label>
                                        <div class="input__inner input__inner--with-leading-icon">
                                            <i class="input__icon input__icon--leading">₱</i>
                                            <input readonly type="text" id="fee" class="input--light300 input-viewprofile" value="0" required>
                                        </div>
                                    </div>
                                </div>
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