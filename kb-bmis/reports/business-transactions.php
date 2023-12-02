<?php
$page = 'Reports';
$headerTitle = 'Reports';
include "../../db_conn.php";

require_once "../../includes/header.php";
include "../../includes/preloader.php";
?>

<main>
    <div class="content">
        <section class="reports">
            <div class="left" style=" margin-bottom:12px;">
                <div>
                    <a href="index.php" class="button button--md back-btn" style="position: relative; top: 0; left: 0; padding:0;">
                        <i class='bx bx-left-arrow-circle'></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card__header">
                    <div class="card__header-content card__header-content--reports">
                        <div class="card__header-content--left">
                            <ul class="tabs tabs--reports">
                                <a href="brgy-transactions.php">
                                    <li class="tab">
                                        Barangay Clearance
                                    </li>
                                </a>

                                <a href="business-transactions.php">
                                    <li class="tab tab--active">
                                        Business Clearance
                                    </li>
                                </a>
                            </ul>
                        </div>

                        <div class="card__header-content--right">
                            <form id="reportForm" action="" method="GET">
                                <div class="input-date-range">
                                    <div class="input__inner">
                                        <input class="input--light300" type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                                                                                echo $_GET['from_date'];
                                                                                                            } else {
                                                                                                            } ?>" required>
                                    </div>
                                    <h4>TO</h4>
                                    <div class="input__inner">
                                        <input class="input--light300" type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                                                                                echo $_GET['to_date'];
                                                                                                            } else {
                                                                                                            } ?>" required>
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
                                    <input class="input--light300" type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                                                                            echo $_GET['from_date'];
                                                                                                        } else {
                                                                                                        } ?>" required>
                                </div>
                                <h4>TO</h4>
                                <div class="input__inner">
                                    <input class="input--light300" type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                                                                            echo $_GET['to_date'];
                                                                                                        } else {
                                                                                                        } ?>" required>
                                </div>

                                <button type="Submit" class="button button--sm button--primary filterBtn">FILTER</button>
                            </div>
                        </form>

                        <table id="reports-bsnclr-table" class="nowrap">
                            <thead>
                                <tr>
                                    <th>O.R No.</th>
                                    <th>Date Issued</th>
                                    <th>Name</th>
                                    <th>Business Name</th>
                                    <th>Business Type</th>
                                    <th>Amount</th>
                                    <th>Issued by</th>

                                </tr>
                            </thead>
                            <?php if (isset($_GET['from_date']) && isset($_GET['to_date'])) {

                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];

                                $query = "SELECT * FROM business_clearance WHERE date_issued BETWEEN '$from_date' AND '$to_date' order by id desc";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {

                                    foreach ($query_run as $row) {

                            ?>
                                        <tr>
                                            <td><?php echo $row['receipt_number'] ?></td>
                                            <td><?php echo $row['date_issued'] ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['bus_name'] ?></td>
                                            <td><?php echo $row['bus_type'] ?></td>
                                            <td>₱<?php echo $row['fee'] ?></td>
                                            <td><?php echo $row['user_log'] ?></td>


                                        </tr>
                                    <?php
                                    }
                                }
                            } else {
                                $query = "SELECT * FROM business_clearance order by id desc";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {

                                    foreach ($query_run as $row) {

                                    ?>
                                        <tr>
                                            <td><?php echo $row['receipt_number'] ?></td>
                                            <td><?php echo $row['date_issued'] ?></td>
                                            <td><?php echo $row['name'] ?></td>
                                            <td><?php echo $row['bus_name'] ?></td>
                                            <td><?php echo $row['bus_type'] ?></td>
                                            <td>₱<?php echo $row['fee'] ?></td>
                                            <td><?php echo $row['user_log'] ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                            }
                            ?>
                    </div>
                </div>
                <!-- card end -->
            </div>
        </section>
    </div>
</main>

</body>

</html>