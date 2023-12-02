<?php
session_start();
include "../../../db_conn.php";
include "../../calculate-age.php";

if (filter_has_var(INPUT_GET, 'osca_id')) {
    $clean_osca_id = filter_var($_GET['osca_id'], FILTER_SANITIZE_NUMBER_INT);
    $osca_id = filter_var($clean_osca_id, FILTER_VALIDATE_INT);
}

$oscaQuery = "SELECT * FROM osca_certificate_view WHERE osca_id = :osca_id";
$oscaStatement = $pdo->prepare($oscaQuery);
$oscaStatement->bindParam(':osca_id', $osca_id, PDO::PARAM_INT);
$oscaStatement->execute();

$osca = $oscaStatement->fetch(PDO::FETCH_ASSOC);

$date_of_birth = $osca['date_of_birth'];
$formatted_date_of_birth = date('F d, Y', strtotime($date_of_birth));
$age = calculate_age($date_of_birth);

$place_of_birth = $osca['place_of_birth'];

$date_of_residency = $osca['date_of_residency'];
$formatted_date_of_residency = date('F d, Y', strtotime($date_of_residency));

$clearance_date_issued = $osca['date_issued'];
$new_date_issued_day = date("jS", strtotime($clearance_date_issued));
$new_date_issued_month_year = date("F Y", strtotime($clearance_date_issued));
$new_clearance_date = date("F j, Y", strtotime($clearance_date_issued));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../../assets/img/fatima-logo.png" type="image/png" />

    <!--=============== CSS ===============-->

    <link href="./../../../vendors/boxicons-2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="./../../../vendors/jquery.dataTables.min.css">

    <link rel="stylesheet" href="../../../assets/css/certificates.css" />

    <!--=============== MAIN JS ===============-->
    <script type="text/javascript" src="./../../../vendors/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="./../../../vendors/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/main.js" defer></script>

    <title>Generated OSCA Certificate - Barangay Information System</title>
</head>

<body>
    <div class="certificate__canvas">
        <img class="certificate__header" src="../../../assets/img/goodmoral-bg.jpg" alt="Good Moral Certificate" />
        <div class="certificate__text certificate__text--brgyclearance">
            <div>
                <div class="row row--space-between">
                    <b>TO WHOM IT MAY CONCERN:</b>
                    <div class="certificate__img">
                        <img src="../../residents/images/<?php echo $osca['resident_image'] ?>" alt="" />
                    </div>
                </div>
                <p class="indent">
                    This is to certify that <b><u><?php echo strtoupper($osca['resident_name']) ?></u>, </u> <u><?php echo $age ?></u></b> years old, <?php echo $osca['nationality'] ?: 'Filipino' ?>, <?php echo $osca['civil_status']; ?> and a resident of <b><?php echo $osca['address'] ?>, Barangay Fatima, General Santos City </b> since <b><u><?php echo $formatted_date_of_residency ?></u></b> up to present.
                </p>

                <span class="br br--sm"></span>
                <p class="indent">
                    This is to certify further that the aforementioned person was born on <b>
                        <u><?php echo $formatted_date_of_birth ?></u> at <?php echo $place_of_birth ?></b>
                </p>

                <span class="br br--sm"></span>

                <p class="indent">
                    This certification is issued upon the request of the above-named person, purposively to vouch the fact that he/she is a resident of this community and to comply the requirement for <b>Office of the Senior Citizen's Affair (OSCA) <u><?php echo strtoupper($osca['purpose']) ?></u></b>.
                </p>

                <span class="br br--sm"></span>

                <p class="indent">
                    Issued this <b><?php echo $new_date_issued_day ?></b> day of <b><?php echo $new_date_issued_month_year ?></b> at the Office of the Punong Barangay, Barangay Fatima, General Santos City, Philippines.
                </p>

                <span class="br br--sm"></span>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div class="row row--flex-start">
                    <div class="certificate__resident">
                        <div><b><u><?php echo strtoupper($osca['resident_name']) ?></u></b></div>

                        <p>(Signiture over Printed Name)</p>
                    </div>
                </div>

            </div>

            <div class="row row--flex-end">
                <div class="certificate__official">

                    <span class="br br--sm"></span>
                    <br>

                    <div class="certificate__seal">
                        Not valid without dry seal
                    </div>

                    <?php
                    $chairmanQuery = "SELECT * FROM resident, official WHERE official.off_position = :position AND resident.resident_id = official.resident_id";

                    $chairmanStatement = $pdo->prepare($chairmanQuery);
                    $chairmanStatement->bindValue(':position', 'Barangay Chairman');
                    $chairmanStatement->execute();

                    $chairmanCount = $chairmanStatement->rowCount();
                    if ($chairmanCount === 1) {
                        $chairman = $chairmanStatement->fetch(PDO::FETCH_ASSOC);

                        $last_name = strtoupper($chairman['last_name']);
                        $first_name = strtoupper($chairman['first_name']);
                        $mid_name = strtoupper($chairman['mid_name'] ? mb_substr($chairman['mid_name'], 0, 1, 'UTF-8')  . "." : " ");
                        $suffix = strtoupper(' ' . $chairman['suffix']);
                    ?>

                        <div class="certificate__signiture">
                            <div class="certificate__official-name">
                                <u>
                                    <?php echo $first_name . " " .  $mid_name . " "  .  $last_name . $suffix ?>
                                </u>
                            </div>
                            <p>Punong Barangay</p>

                            <span class="br br--sm"></span>

                            <p>
                                By the Authority of Punong Barangay
                            </p>

                        </div>
                    <?php } ?>


                    <?php
                    $officialQuery = "SELECT last_name, first_name, mid_name, suffix, off_position FROM official_view WHERE official_id = :official_id";

                    $officialStatement = $pdo->prepare($officialQuery);
                    $officialStatement->bindParam(':official_id', $osca['official_id'], PDO::PARAM_INT);
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
                <button type="submit" name="submit" class="button button--sm button--primary" id="print-btn" onclick="printPage()" disabled>
                    Print
                </button>
                <button class="button button--sm button--dark" id="back-btn" type="button">
                    <a style="color: #fdfdfd;" onclick="history.back()">Back</a>
                </button>
            </div>
        </div>
    </div>
    <?php require "./../modals/official.php"; ?>
</body>

</html>