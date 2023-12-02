<?php
$page = 'Certificates';
$headerTitle = 'Barangay Clearance';

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

                $resident = $statement->fetch(PDO::FETCH_ASSOC);
                $sex = $resident['sex'];
                $nationality = $resident['nationality'] ?: 'Filipino';
                $civil_status = $resident['civil_status'];

                $purok = $resident['purok'] ? $resident['purok'] . ', ' : '';
                $street = $resident['street'] ? $resident['street'] . ', ' : '';
                $lot_number = $resident['lot_number'] ? $resident['lot_number'] . ', ' : '';


                ?>
                <div class="card__body">
                    <form id="" action="generate/generate-brgy-clearance.php" method="post">
                        <div class="card__body-content">

                            <div class="profile__img profile__img--change">
                                <img src="../residents/images/<?php echo $resident['img_url'] ?>" name="default" alt="">

                                <input type="hidden" name="pic" value="<?php echo $resident['img_url'] ?>" />
                            </div>
                        </div>

                        <div class="center">
                            <div class="profile__name" style="margin: 20px 0px 30px 0px;">
                                <?php echo $resident['last_name'] ?>,
                                <?php echo $resident['first_name'] ?>
                                <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                <?php echo $resident['suffix'] ?>
                            </div>
                        </div>

                        <div class="certificates-info__content">
                            <section class="certificates-info">
                                <div class="certificates-info__container">
                                    <!-- hidden -->
                                    <div class="cert-info">
                                        <input id="id" type="hidden" name="resident_id" value="<?php echo $resident['resident_id'] ?>" />
                                    </div>
                                    <div class="cert-info">
                                        <input id="id" type="hidden" name="civil_status" value="<?php echo $civil_status ?>" />
                                    </div>

                                    <div class="cert-info">
                                        <input id="id" type="hidden" name="nationality" value="<?php echo $nationality ?>" />
                                    </div>

                                    <!-- hidden -->

                                    <div class="input__wrapper">
                                        <label>Name</label>
                                        <div class="input__inner">
                                            <input readonly name="name1" type="text" required class="input--light300 input-viewprofile" value="<?php echo $resident['last_name'] ?>, <?php echo $resident['first_name'] ?> <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?> <?php echo $resident['suffix'] ?>">

                                            <input type="hidden" name="first_name" id="first_name" title="Numbers and Special Characters are not allowed." class="input--light300" pattern="[a-zA-z -]+" value="<?php echo $resident['first_name'] ?>">

                                            <input type="hidden" name="mid_name" id="mid_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['mid_name'] ?>">

                                            <input type="hidden" name="last_name" id="last_name" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['last_name'] ?>">

                                            <input type="hidden" name="suffix" id="suffix" title="Numbers and Special Characters are not allowed." class="input--light300" value="<?php echo $resident['suffix'] ?>">
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
                                                <select name="purpose" id="purpose" class="select select--resident-profile" onchange="showInput('purpose', 'other_purpose', 'other-purpose'); showClearanceCategory('purpose', 'category-container', 'certificate-category');" required autofocus>
                                                    <option selected disabled hidden value="">Select</option>
                                                    <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                    <option value="Pag-asa Loan">Pag-asa Loan</option>
                                                    <option value="Asa Loan">Asa Loan</option>
                                                    <option value="Mediatrix Loan">Mediatrix Loan</option>
                                                    <option value="Light Micro Loan">Light Micro Loan</option>
                                                    <option value="Application Loan">Application Loan</option>

                                                    <option value="Employment">Employment</option>
                                                    <option value="Postal ID">Postal ID</option>
                                                    <option value="Water Connection">Water Connection</option>
                                                    <option value="DepEd Requirement">DepEd Requirement</option>
                                                    <option value="Identification">Identification</option>
                                                    <option value="SSS Requirement">SSS Requirement</option>
                                                    <option value="BIR Requirement">BIR Requirement</option>
                                                    <option value="Driver's License">Driver's License</option>
                                                    <option value="Security License">Security License</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input__inner">
                                    <input name="fee_setting_id" id="fee-setting-id" type="hidden" value="">
                                </div>

                            </section>

                            <section class="certificates-info" style="margin-top: 10px;">

                                <div class="certificates-info__container" id="category-container" style="display: none">
                                    <div class="input__wrapper">
                                        <label>Certificate Category <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <div class="select__wrapper">
                                                <select name="certificate_category" id="certificate-category" class="select select--resident-profile" disabled>
                                                    <option selected disabled hidden value="">Select</option>
                                                    <option value="New">New</option>
                                                    <option value="Renewal">Renewal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container" id="other_purpose" style="display:none">
                                    <div class="input__wrapper">
                                        <label for="other-purpose">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input type="text" name="other_purpose" id="other-purpose" title="Numbers and Special Characters are not allowed." class="input--light300" pattern="[a-zA-Z ,-.]+">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>O.R No. <small style="font-style: italic">(i.e. 2342343A) </small><strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input type="text" name="receipt_number" id="receipt-number" title="Special Characters are not allowed." class="input--light300 input-viewprofile" maxlength="8" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Cedula No. <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input name="cedula_number" type="text" id="cedula-number" title="Characters and Special characters are not allowed." class="input--light300 input-viewprofile" maxLength="8" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Cedula Issued at <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input name="cedula_issued_at" type="text" id="cedula_issued_at" title="Numbers and Special Characters are not allowed." class="input--light300 input-viewprofile" value="Barangay Fatima, GSC" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Cedula Issued on <strong style="color:red;">*</strong></label>
                                        <div class="input__inner">
                                            <input name="cedula_date" type="date" class="input--light300 input-viewprofile" value="" max="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                </div>

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