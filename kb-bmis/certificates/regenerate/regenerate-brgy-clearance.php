<?php
session_start();
include "../../../db_conn.php";

if (filter_has_var(INPUT_GET, 'brgy_clearance_id')) {
    $clean_id = filter_var($_GET['brgy_clearance_id'], FILTER_SANITIZE_NUMBER_INT);
    $brgy_clearance_id = filter_var($clean_id, FILTER_VALIDATE_INT);
}
$clearanceQuery = "SELECT * FROM brgy_clearance_view WHERE brgy_clearance_id = :brgy_clearance_id";
$clearanceStatement = $pdo->prepare($clearanceQuery);
$clearanceStatement->bindParam(':brgy_clearance_id', $brgy_clearance_id, PDO::PARAM_INT);
$clearanceStatement->execute();
$clearance = $clearanceStatement->fetch(PDO::FETCH_ASSOC);

$official_id = $clearance['official_id'];
$clearance_date_issued = $clearance['date_issued'];
$cedula_date = $clearance['cedula_date'];
$new_date_issued_day = date("jS", strtotime($clearance_date_issued));
$new_date_issued_month_year = date("F Y", strtotime($clearance_date_issued));
$new_cedula_date = date("F j, Y", strtotime($cedula_date));
$new_clearance_date = date("F j, Y", strtotime($clearance_date_issued));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../../assets/img/fatima-logo.png" type="image/png" />

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../../../assets/css/certificates.css" />

    <!--=============== MAIN JS ===============-->
    <script src="../../../assets/js/main.js" defer></script>

    <title>Regenerate Barangay Clearance - Barangay Resident Information System</title>
</head>

<body>

    <div class="certificate__canvas">
        <img class="certificate__header" src="../../../assets/img/brgy-clearance-bg.jpg" alt="Barangay Certificate" />
        <div class="certificate__text certificate__text--brgyclearance">
            <div>
                <div class="row row--space-between">
                    <b>TO WHOM IT MAY CONCERN:</b>
                    <div class="certificate__img">
                        <img src="../../residents/images/<?php echo $clearance['resident_image'] ?>" alt="" />
                    </div>
                </div>
                <p class="indent">
                    This is to certify that <b><u><?php echo strtoupper($clearance['resident_name']) ?>,</u></b> of legal age, <?php echo $clearance['nationality'] ?>, <?php echo strtolower($clearance['civil_status']) ?> and a resident of <b><?php echo $clearance['address'] ?>, Barangay Fatima, General Santos City,</b> is known to be of good moral character, never been charged of any violation before the office of Punong Barangay and has no derogatory records as far as this office is concerned. <?php echo $clearance['sex'] ?> is a law-abiding cetizen and is not a member of any subversive elements against the Republic of the Philippines.
                </p>

                <span class="br br--sm"></span>

                <p class="indent">
                    This clearance is being issued upon the request of the above-named person for the following purposes:
                </p>

                <span class="br br--sm"></span>

                <div style="text-align: center"><b><u><?php echo strtoupper("FOR " . $clearance['purpose'] . " ($clearance[category])") ?></u></b></div>

                <span class="br br--sm"></span>

                <p class="indent">
                    Issued this <b><?php echo $new_date_issued_day ?></b> day of <b><?php echo $new_date_issued_month_year ?></b> at the Office of the Punong Barangay, Barangay Fatima, General Santos City, Philippines.
                </p>

                <br>
                <br>
                <div class="row row--flex-start">
                    <div class="certificate__resident">
                        <div><b><u><?php echo strtoupper($clearance['resident_name']) ?></u></b></div>

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
                    CTC no.: <u><?php echo $clearance['cedula_number']; ?></u><br>
                    Issued on: <u><?php echo $new_clearance_date; ?></u><br>
                    Issued at: <u><?php echo $clearance['cedula_issued_at']; ?></u>
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
                        $mid_name = strtoupper($chairman['mid_name'] ? $chairman['mid_name'][0] . "." : " ");
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

                    <?php
                    $officialQuery = "SELECT last_name, first_name, mid_name, suffix, off_position FROM official_view WHERE official_id = :official_id";

                    $officialStatement = $pdo->prepare($officialQuery);
                    $officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
                    $officialStatement->execute();

                    $officialCount = $officialStatement->rowCount();
                    if ($officialCount === 1) {
                        $official = $officialStatement->fetch(PDO::FETCH_ASSOC);

                        $last_name = strtoupper($official['last_name']);
                        $first_name = strtoupper($official['first_name']);
                        $mid_name = strtoupper($official['mid_name'] ? $official['mid_name'][0] . "." : " ");
                        $suffix = strtoupper(' ' . $official['suffix']);
                    ?>

                        <div class="certificate__signiture">
                            <div class="certificate__official-name">
                                <u>
                                    <?php echo $first_name . " " .  $mid_name . " "  .  $last_name . $suffix ?>
                                </u>
                            </div>


                            <p><?php echo $official['off_position'] ?></p>
                            <p>Officer-In-Charge</p>
                        </div>
                    <?php } ?>
                </div>
            </div>


            <!-- hide print button when print -->
            <div class="certificate__buttons noprint">
                <a href="./../brgy-clearance-list.php?msg=Clearance Regenerated Successfully" type="submit" name="submit" class="button button--sm button--primary" id="print-btn" onclick="printPage()">
                    Print
                </a>
                <button class="button button--sm button--dark" id="back-btn" type="button">
                    <a style="color: #fdfdfd;" onclick="history.back()">Back</a>
                </button>
            </div>
        </div>
    </div>

</body>

</html>