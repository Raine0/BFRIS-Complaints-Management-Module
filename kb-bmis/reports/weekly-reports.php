<?php
$page = 'Reports';
$headerTitle = 'Reports';

require_once "../../includes/header.php";


?>

<main>
    <div class="content">
        <section class="reports">
            <div class="left">
                <div>
                    <a href="index.php" class="button button--md back-btn" style="position: relative; margin-bottom:14px; margin-left:-15px;">
                        <i class='bx bx-left-arrow-circle'></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card__header">
                    <div class="card__header-content">
                        <div class="card__header-content--left">
                            <ul class="reports__tabs-list">
                                <a href="weekly-reports.php">
                                    <li class="reports__tabs-item">
                                        Last 7 Days
                                    </li>
                                </a>
                                <a href="monthly-reports.php">
                                    <li class="reports__tabs-item">
                                        Monthly
                                    </li>
                                </a>
                                <a href="yearly-reports.php">
                                    <li class="reports__tabs-item">
                                        Yearly
                                    </li>
                                </a>
                            </ul>
                        </div>

                        <div class="card__header-content--right">

                        </div>
                    </div>
                </div>

                <div class="card__body">
                    <div class="card__body-content" style="flex-direction: row;">
                        <div class="graph" style=" width: 50%;">
                            <h1>Barangay Clearance Revenue</h1>
                            <canvas id="brgy-week"></canvas>
                        </div>

                        <!-- <div class="graph1" style="width: 50%;">
                            <h1>Business Clearance Revenue</h1>
                            <canvas id="bs-week"></canvas>
                        </div> -->
                    </div>
                </div>
                <!-- card end -->
            </div>
        </section>
    </div>
</main>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script> -->
<script type="text/javascript" src="../../assets/js/chart.js"></script>

</body>

</html>