<?php
session_start();
include "../../../db_conn.php";


if (filter_has_var(INPUT_POST, 'fee_setting_id')) {

    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);
    $clean_fee_id = filter_var($_POST['fee_setting_id'], FILTER_SANITIZE_NUMBER_INT);
    $fee_setting_id = filter_var($clean_fee_id, FILTER_VALIDATE_INT);
    $last_name = strtoupper($_POST['last_name']);
    $first_name = strtoupper($_POST['first_name']);
    $mid_name = strtoupper($_POST['mid_name'] ? mb_substr($_POST['mid_name'], 0, 1, 'UTF-8') . "." : " ");
    $suffix = strtoupper(' ' . $_POST['suffix']);
    $address = ucwords($_POST['address']);
    $purpose = $_POST['purpose'];
    if ($purpose != "Others") {
        $purpose = htmlspecialchars(ucwords($_POST['purpose']));
    } else {
        $purpose = htmlspecialchars(ucwords(strtolower(trim($_POST['other_purpose']))));
    }
    $category = htmlspecialchars($_POST['certificate_category']);
    $receipt_number = $_POST['receipt_number'];
    $clearance_date_issued = $_POST['date_issued'];
    $cedula_number = $_POST['cedula_number'];
    $cedula_issued_at = ucwords(trim($_POST['cedula_issued_at']));
    $cedula_date = $_POST['cedula_date'];
    $nationality = $_POST['nationality'];
    $civil_status = strtolower($_POST['civil_status']);
    $new_date_issued_day = date("jS", strtotime($clearance_date_issued));
    $new_date_issued_month_year = date("F Y", strtotime($clearance_date_issued));
    $new_cedula_date = date("F j, Y", strtotime($cedula_date));
    $new_clearance_date = date("F j, Y", strtotime($clearance_date_issued));
    $pic = $_POST['pic'];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="../../../assets/img/fatima-logo.png" type="image/png" />

        <link href="./../../../vendors/boxicons-2.0.9/css/boxicons.min.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="./../../../vendors/jquery.dataTables.min.css">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="../../../assets/css/certificates.css" />

        <!--=============== SCRIPTS ===============-->
        <script type="text/javascript" src="./../../../vendors/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8" src="./../../../vendors/jquery.dataTables.min.js"></script>

        <!--=============== MAIN JS ===============-->
        <script src="../../../assets/js/main.js" defer></script>


        <title>Generate Barangay Clearance - Barangay Information System</title>
    </head>

    <body>
        <form action="../save/save-brgy-clearance.php" method="post">
            <input name="resident_id" type="hidden" value="<?php echo $resident_id ?>">
            <input name="official_id" id="official_id" type="hidden">
            <input name="fee_setting_id" type="hidden" value="<?php echo $fee_setting_id ?>">
            <input name="purpose" type="hidden" value="<?php echo $purpose ?>">
            <input name="category" type="hidden" value="<?php echo $category ?>">
            <input name="cedula_number" type="hidden" value="<?php echo $cedula_number ?>">
            <input name="cedula_issued_at" type="hidden" value="<?php echo $cedula_issued_at ?>">
            <input name="cedula_date" type="hidden" value="<?php echo $cedula_date ?>">
            <input name="receipt_number" type="hidden" value="<?php echo $receipt_number ?>">

            <div class="certificate__canvas">
                <img class="certificate__header" src="../../../assets/img/brgy-clearance-bg.jpg" alt="Barangay Certificate" />
                <div class="certificate__text certificate__text--brgyclearance">
                    <div>
                        <div class="row row--space-between">
                            <b>TO WHOM IT MAY CONCERN:</b>
                            <div class="certificate__img">
                                <img src="../../residents/images/<?php echo $pic ?>" alt="" />
                            </div>
                        </div>
                        <p class="indent">
                            This is to certify that <b><u><?php echo $first_name . " " .  $mid_name . " " . $last_name . $suffix ?>,</u></b> of legal age, <?php echo $nationality ?>, <?php echo $civil_status; ?> and a resident of <b><?php echo $address ?>,</b> is known to be of good moral character, never been charged of any violation before the office of Punong Barangay and has no derogatory records as far as this office is concerned. She/he is a law-abiding cetizen and is not a member of any subversive elements against the Republic of the Philippines.
                        </p>

                        <span class="br br--sm"></span>

                        <p class="indent">
                            This clearance is being issued upon the request of the above-named person for the following purposes:
                        </p>

                        <span class="br br--sm"></span>

                        <div style="text-align: center"><b><u><?php echo strtoupper("FOR " . $purpose . " ($category)") ?></u></b></div>

                        <span class="br br--sm"></span>

                        <p class="indent">
                            Issued this <b><?php echo $new_date_issued_day ?></b> day of <b><?php echo $new_date_issued_month_year ?></b> at the Office of the Punong Barangay, Barangay Fatima, General Santos City, Philippines.
                        </p>

                        <br>
                        <br>
                        <div class="row row--flex-start">
                            <div class="certificate__resident">
                                <div><b><u><?php echo $first_name . " " .  $mid_name . " " .  $last_name . $suffix ?></u></b></div>

                                <p>(Signiture over Printed Name)</p>
                            </div>
                        </div>

                        <div class="row row--flex-start">
                            <div class="certificate__thumbmark-box">
                                <p>LEFT</p>
                            </div>

                            <div class="certificate__thumbmark-box">
                                <p>RIGHT</p>
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="certificate__date">
                            CTC no.: <u><?php echo $cedula_number; ?></u><br>
                            Issued on: <u><?php echo $new_clearance_date; ?></u><br>
                            Issued at: <u><?php echo $cedula_issued_at; ?></u>
                        </div>

                    </div>

                    <div class="row row--flex-end">
                        <div class="certificate__official">
                            <div class="certificate__seal">
                                Not valid without dry seal
                            </div>

                            <?php
                            $chairmanQuery = "SELECT last_name, first_name, mid_name, suffix, off_position FROM official_view WHERE off_position = :position ";

                            $chairmanStatement = $pdo->prepare($chairmanQuery);
                            $chairmanStatement->bindValue(':position', 'Barangay Chairman');
                            $chairmanStatement->execute();

                            $chairmanCount = $chairmanStatement->rowCount();
                            if ($chairmanCount === 1) {
                                $chairman = $chairmanStatement->fetch(PDO::FETCH_ASSOC);

                                $last_name = strtoupper($chairman['last_name']);
                                $first_name = strtoupper($chairman['first_name']);
                                $mid_name = strtoupper($chairman['mid_name'] ? mb_substr($chairman['mid_name'], 0, 1, 'UTF-8') . "." : " ");
                                $suffix = strtoupper(' ' . $chairman['suffix']);
                            ?>

                                <div class="certificate__signiture">
                                    <div class="certificate__official-name">
                                        <u>
                                            <?php echo $first_name . " " .  $mid_name . " "  .  $last_name . $suffix ?>
                                        </u>
                                    </div>
                                    <p><?php echo $chairman['off_position'] ?></p>

                                    <span class="br br--sm"></span>

                                    <p>
                                        By the Authority of <?php echo $chairman['off_position'] ?>
                                    </p>

                                </div>
                            <?php } ?>



                            <div class="certificate__signiture">
                                <a class="button button--green button--sm modal-trigger" id="choose_official" data-modal-id="official-modal">
                                    <i class='bx bxs-user-voice'></i>
                                    <p class="modal-trigger" data-modal-id="official-modal">Choose Official</p>
                                </a>
                                <a class="modal-trigger" data-modal-id="official-modal">
                                    <div class="certificate__official-name modal-trigger" data-modal-id="official-modal">
                                        <u class="modal-trigger" data-modal-id="official-modal" id="off_name">

                                        </u>
                                    </div>
                                </a>

                                <p id="off_position"></p>
                                <p>Officer-In-Charge</p>
                            </div>
                        </div>
                    </div>


                    <!-- hide print button when print -->
                    <div class="certificate__buttons noprint">
                        <button type="submit" name="submit" class="button button--sm button--primary" id="print-btn" onclick="printPage()" disabled>
                            Print
                        </button>
                        <button class="button button--sm button--dark" id="back-btn" type="button">
                            <a style="color: #fdfdfd;" onclick="history.back()">Back</a>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <?php require "./../modals/official.php"; ?>
    </body>

    </html>

<?php } ?>