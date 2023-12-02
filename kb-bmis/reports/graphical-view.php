<?php
$page = 'Reports';
$headerTitle = 'Reports';

require_once "../../includes/header.php";
include "../reports/data/total-transactions.php";



?>
<main>
    <div class="content">
        <section class="reports">
            <?php
            include "../../includes/back-button.php";
            ?>
            <div class="card">
                <div class="card__header">
                    <div class="card__header-content">

                        <div class="card__header-content--left">

                            <ul class="tabs">
                                <li class="tab tab--active">
                                    Last 7 days
                                </li>

                                <li class="tab">
                                    Monthly
                                </li>

                                <li class="tab">
                                    Yearly
                                </li>
                            </ul>
                        </div>

                        <div class="card__header-content--right">
                        </div>
                    </div>
                </div>

                <div class="card__body" style="padding: 40px 10px;">
                    <div class="card__body-content" style="min-height: 500px;">
                        <div class="tabContent reports">
                            <a href="../archive/brgy-clearance-archive.php">
                                <div class="reports__card">
                                    <div>
                                        <div class="reports__card--value">
                                            <?php echo $weeklyClearance['WeeklyBrgyClearanceTotal'] ?></div>
                                        <div class="reports__card--label">Total Barangay Clearance</div>
                                    </div>

                                    <span class="reports__card--icon"><i class='bx bx-file'></i></span>
                                </div>
                            </a>

                            <!-- <div class="reports__card">
                                <div>
                                    <div class="reports__card--value">
                                        <?php echo $total_WeekBusinessClr['weeklyBusTotal'] ?>
                                    </div>
                                    <div class="reports__card--label">Total Business Clearance</div>

                                </div>

                                <span class="reports__card--icon"><i class='bx bxs-file'></i></span>
                            </div> -->

                            <div class="graph">
                                <h3>Barangay Clearance Revenue</h3>
                                <canvas id="brgy-week"></canvas>
                            </div>

                            <!-- <div class="graph">
                                <h3>Business Clearance Revenue</h3>
                                <canvas id="bs-week"></canvas>
                            </div> -->
                        </div>

                        <div class="tabContent reports" style="display: none;">
                            <div class="reports__card">
                                <div>
                                    <div class="reports__card--value">
                                        <?php echo $monthlyClearance['TotalBrgyClearanceGenerated'] ?></div>
                                    <div class="reports__card--label">Total Barangay Clearance</div>
                                </div>

                                <span class="reports__card--icon"><i class='bx bx-file'></i></span>
                            </div>

                            <!-- <div class="reports__card">
                                <div>
                                    <div class="reports__card--value">
                                        <?php echo $total_MonthBusinessClr['monthlyBusTotal'] ?>
                                    </div>
                                    <div class="reports__card--label">Total Business Clearance</div>
                                </div>

                                <span class="reports__card--icon"><i class='bx bxs-file'></i></span>
                            </div> -->

                            <div class="graph">
                                <h3>Barangay Clearance Revenue</h3>
                                <canvas id="brgy-month"></canvas>
                            </div>

                            <!-- <div class="graph">
                                <h3>Business Clearance Revenue</h3>
                                <canvas id="bs-month"></canvas>
                            </div> -->
                        </div>

                        <div class="tabContent reports" style="display: none;">
                            <div class="reports__card">
                                <div>
                                    <div class="reports__card--value">
                                        <?php echo $yearlyClearance['YearlyBrgyClearanceTotal'] ?></div>
                                    <div class="reports__card--label">Total Barangay Clearance</div>
                                </div>

                                <span class="reports__card--icon"><i class='bx bx-file'></i></span>
                            </div>

                            <!-- <div class="reports__card">
                                <div>
                                    <div class="reports__card--value">
                                        <?php echo $total_YearBusinessClr['yearlyBusTotal'] ?>
                                    </div>
                                    <div class="reports__card--label">Total Business Clearance</div>

                                </div>

                                <span class="reports__card--icon"><i class='bx bxs-file'></i></span>
                            </div> -->


                            <div class="graph">
                                <h3>Barangay Clearance Revenue</h3>
                                <canvas id="brgy-year"></canvas>
                            </div>

                            <!-- <div class="graph">
                                <h3>Business Clearance Revenue</h3>
                                <canvas id="bs-year"></canvas>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- card end -->
            </div>
        </section>
    </div>
</main>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script> -->
<script src="../../vendors/chart.min.js"></script>
<script type="text/javascript" src="../../assets/js/chart.js"></script>
<!-- -->
</body>

</html>