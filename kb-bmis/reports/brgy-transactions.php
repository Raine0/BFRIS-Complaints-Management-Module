<?php
$page = 'Reports';
$headerTitle = 'Reports';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
?>



<main>
    <div class="content">
        <section class="reports">

            <?php require '../../includes/back-button.php'; ?>

            <div class="card">
                <div class="card__header">
                    <div class="card__header-content card__header-content--reports">
                        <div class="card__header-content--left">
                            <ul class="tabs tabs--reports">
                                <a href="brgy-transactions.php">
                                    <li class="tab tab--active">
                                        Barangay Clearance
                                    </li>
                                </a>

                                <!-- <a href="business-transactions.php">
                                    <li class="tab">
                                        Business Clearance
                                    </li>
                                </a> -->
                            </ul>
                        </div>

                        <div class="card__header-content--right">
                            <form id="reportForm" action="" method="GET">
                                <div class="input-date-range">
                                    <div class="input__inner">
                                        <input class="input--light300" type="datetime-local" name="from_date" max="<?php echo date('Y-m-d H:i:s') ?>" value="<?php if (isset($_GET['from_date'])) {
                                                                                                                                                                    echo $_GET['from_date'];
                                                                                                                                                                }
                                                                                                                                                                ?>" required>
                                    </div>
                                    <h4>TO</h4>
                                    <div class="input__inner">
                                        <input class="input--light300" type="datetime-local" name="to_date" max="<?php echo date('Y-m-d H:i:s') ?>" value="<?php if (isset($_GET['to_date'])) {
                                                                                                                                                                echo $_GET['to_date'];
                                                                                                                                                            }
                                                                                                                                                            ?>" required>
                                    </div>
                                    <button type="submit" class="button button--sm button--primary filterBtn">FILTER</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card__body">
                    <div class="card__body-content card__body-content--reports">

                        <table id="reports-brgyclr-table" class="nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Purpose</th>
                                    <th>Amount</th>
                                    <th>O.R No.</th>
                                    <th>Cedula No.</th>
                                    <th>Cedula Date</th>
                                    <th>Issued by</th>
                                    <th>Date Issued</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php if (filter_has_var(INPUT_GET, 'from_date') && filter_has_var(INPUT_GET, 'to_date')) {

                                    $from_date = htmlspecialchars($_GET['from_date']);
                                    $to_date = htmlspecialchars($_GET['to_date']);

                                    $clearanceQuery = "SELECT resident_name, purpose, fee, receipt_number, cedula_number, cedula_date, issued_by, date_issued FROM brgy_clearance_view WHERE date_issued BETWEEN :from_date AND :to_date ORDER BY brgy_clearance_id DESC";

                                    $clearanceStatement = $pdo->prepare($clearanceQuery);
                                    $clearanceStatement->bindParam(':from_date', $from_date);
                                    $clearanceStatement->bindParam(':to_date', $to_date);
                                    $clearanceStatement->execute();

                                    $clearanceCount = $clearanceStatement->rowCount();

                                    if ($clearanceCount > 0) {

                                        while ($clerance = $clearanceStatement->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                            <tr>
                                                <td><?php echo $clerance['resident_name'] ?></td>
                                                <td><?php echo $clerance['purpose'] ?></td>
                                                <td>₱<?php echo $clerance['fee'] ?></td>
                                                <td><?php echo $clerance['receipt_number'] ?></td>
                                                <td><?php echo $clerance['cedula_number'] ?></td>
                                                <td><?php echo $clerance['cedula_date'] ?></td>
                                                <td><?php echo $clerance['issued_by'] ?></td>
                                                <td><?php echo $clerance['date_issued'] ?></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                } else {
                                    $clearanceQuery2 = "SELECT resident_name, purpose, fee, receipt_number, cedula_number, cedula_date, issued_by, date_issued FROM brgy_clearance_view ORDER BY brgy_clearance_id DESC";

                                    $clearanceStatement2 = $pdo->query($clearanceQuery2);
                                    $clearanceCount2 = $clearanceStatement2->rowCount();



                                    if ($clearanceCount2 > 0) {
                                        $clearances = $clearanceStatement2->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($clearances as $clearance2) {


                                        ?> <tr>
                                                <td><?php echo $clearance2['resident_name'] ?></td>
                                                <td><?php echo $clearance2['purpose'] ?></td>
                                                <td>₱<?php echo $clearance2['fee'] ?></td>
                                                <td><?php echo $clearance2['receipt_number'] ?></td>
                                                <td><?php echo $clearance2['cedula_number'] ?></td>
                                                <td><?php echo $clearance2['cedula_date'] ?></td>
                                                <td><?php echo $clearance2['issued_by'] ?></td>
                                                <td><?php echo $clearance2['date_issued'] ?></td>
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

</body>

</html>