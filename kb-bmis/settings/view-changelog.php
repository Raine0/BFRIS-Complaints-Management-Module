<?php
ob_start();
$page = 'Fee Settings';
$headerTitle = 'Changelog';
require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (!filter_has_var(INPUT_GET, 'certificate_type_id')) {
    $_SESSION['error'] = 'Cannot Find ID';
    header("location: ./");
} else {
    $clean_certificate_type_id = filter_var($_GET['certificate_type_id'], FILTER_SANITIZE_NUMBER_INT);
    $certificate_type_id = filter_var($clean_certificate_type_id, FILTER_VALIDATE_INT);
}
?>


<main>
    <div class="content">
        <section class="reports">
            <div class="left" style=" margin-bottom:12px;">
                <div>
                    <?php require './../../includes/back-button.php'; ?>
                </div>
            </div>

            <div class="card">
                <div class="card__header card__header--hide">
                    <div class="card__header-content card__header-content--reports">
                        <div class="card__header-content--right">
                            <form id="reportForm" action="" method="GET">
                                <div class="input-date-range">
                                    <div class="input__inner">
                                        <input class="input--light300" type="datetime-local" max="<?php echo date('Y-m-d H:i:s') ?>" name="from_date" value="
                                        <?php if (isset($_GET['from_date'])) {
                                            echo $_GET['from_date'];
                                        } else {
                                        } ?>" required>
                                    </div>

                                    <h4>TO</h4>
                                    <div class="input__inner">
                                        <input class="input--light300" type="datetime-local" min="
                                        <?php if (isset($_GET['from_date'])) {
                                            echo $_GET['from_date'];
                                        } ?>" max="<?php echo date('Y-m-d H:i:s') ?>" name="to_date" value="
                                        <?php if (isset($_GET['to_date'])) {
                                            echo $_GET['to_date'];
                                        } else {
                                        } ?>" required>

                                        <input type="hidden" name="certificate_type_id" value="<?php echo $certificate_type_id ?>">
                                    </div>

                                    <button type="Submit" class="button button--sm button--primary filterBtn">FILTER</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card__body">
                    <div class="card__body-content card__body-content--reports">
                        <form id="reportForm" action="" method="GET">

                            <div class="input-date-range">
                                <div class="input__inner">
                                    <input class="input--light300" type="date" name="from_date" value="
                                    <?php if (isset($_GET['from_date'])) {
                                        echo $_GET['from_date'];
                                    } else {
                                    } ?>" required>
                                </div>

                                <h4>TO</h4>
                                <div class="input__inner">
                                    <input class="input--light300" type="date" name="to_date" value="
                                    <?php if (isset($_GET['to_date'])) {
                                        echo $_GET['to_date'];
                                    } else {
                                    } ?>" required>
                                </div>

                                <button type="Submit" class="button button--sm button--primary filterBtn">FILTER</button>
                            </div>
                        </form>

                        <table id="changelog" class="nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type of Certificate </th>
                                    <th>Fee </th>
                                    <th>Remarks </th>
                                    <th>Created By </th>
                                    <th>Date Created </th>
                                    <th>Updated by </th>
                                    <th>Date Updated </th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                if (isset($_GET['from_date']) && isset($_GET['to_date'])) {

                                    $from_date = $_GET['from_date'];
                                    $to_date = $_GET['to_date'];

                                    $settingQuery = "SELECT * from fee_view
                                    WHERE certificate_type_id = :certificate_type_id AND date_updated BETWEEN :from_date AND :to_date ORDER BY fee_setting_id desc";

                                    $settingStatement = $pdo->prepare($settingQuery);
                                    $settingStatement->bindParam(':certificate_type_id', $certificate_type_id);
                                    $settingStatement->bindParam(':from_date', $from_date);
                                    $settingStatement->bindParam(':to_date', $to_date);
                                    $settingStatement->execute();

                                    $settingCount = $settingStatement->rowCount();

                                    if ($settingCount > 0) {

                                        while ($setting = $settingStatement->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                            <tr>
                                                <td><?php echo $setting['fee_setting_id'] ?></td>
                                                <td><?php echo $setting['certificate_type'] ?></td>
                                                <td>₱<?php echo $setting['fee'] ?></td>
                                                <td><?php echo $setting['remarks'] ?></td>
                                                <td><?php echo $setting['created_by'] ?></td>
                                                <td><?php echo $setting['date_created'] ?></td>
                                                <td><?php echo $setting['updated_by'] ?></td>
                                                <td><?php echo $setting['date_updated'] ?></td>


                                            </tr>
                                        <?php
                                        }
                                    }
                                    // else {
                                    //     echo "No record found";
                                    // }
                                } else {
                                    $settingQuery2 = "SELECT * from fee_view WHERE certificate_type_id = :certificate_type_id
                                    ORDER BY fee_setting_id DESC";

                                    $settingStatement2 = $pdo->prepare($settingQuery2);
                                    $settingStatement2->bindParam(':certificate_type_id', $certificate_type_id);
                                    $settingStatement2->execute();
                                    $settingCount2 = $settingStatement2->rowCount();

                                    if ($settingCount2 > 0) {

                                        while ($setting = $settingStatement2->fetch(PDO::FETCH_ASSOC)) {

                                        ?>
                                            <tr>
                                                <td><?php echo $setting['fee_setting_id'] ?></td>
                                                <td><?php echo $setting['certificate_type'] ?></td>
                                                <td>₱<?php echo $setting['fee'] ?></td>
                                                <td><?php echo $setting['remarks'] ?></td>
                                                <td><?php echo $setting['created_by'] ?></td>
                                                <td><?php echo $setting['date_created'] ?></td>
                                                <td><?php echo $setting['updated_by'] ?></td>
                                                <td><?php echo $setting['date_updated'] ?></td>

                                            </tr>
                                <?php
                                        }
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- card end -->
            </div>
        </section>
    </div>
</main>
<?php ob_end_flush(); ?>
</body>

</html>