<?php
$headerTitle = 'Dashboard';
$page = 'Dashboard';

require "../../includes/header.php";
require "../../includes/preloader.php";
include "data-dashboard.php";

?>

<?php if (isset($_SESSION['success'])) { ?>
    <!-- ALERT -->
    <div class="alert alert--success">
        <i class='bx bxs-check-square alert__icon'></i>
        <div class="alert__message">
            <?php
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
            echo $success;
            ?>
        </div>
    </div>
<?php } ?>
<!--=============== MAIN ===============-->
<main>

    <!-- DASHBOARD -->
    <div class="content" style="display:block;">

        <section class="dashboard">
            <div class="dashboard__logo">
                <img src="../../assets/img/fatima-logo.png" alt="fatima-logo">
            </div>


            <div class="dashboard__cards">

                <a <?php if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder' && $user_role !== 'Barangay Clerk - Generate Clearance') : ?>href="../residents/" <?php endif; ?>>
                    <div class="dashboard__card">
                        <div>
                            <div class="dashboard__card--value"><?php echo $totalPopulation['resident'] ?></div>
                            <div class="dashboard__card--label">Total Population</div>
                        </div>

                        <span class="dashboard__card--icon"><i class='bx bxs-group'></i></span>
                    </div>
                </a>

                <a <?php if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder' && $user_role !== 'Barangay Clerk - Generate Clearance') : ?>href="total-male.php" <?php endif; ?>>
                    <div class="dashboard__card">
                        <div>
                            <div class="dashboard__card--value"><?php echo $totalMale['maleTotal']; ?></div>
                            <div class="dashboard__card--label">Total Male Residents</div>
                        </div>

                        <span class="dashboard__card--icon"><i class='bx bx-male'></i></span>
                    </div>
                </a>

                <a <?php if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder' && $user_role !== 'Barangay Clerk - Generate Clearance') : ?>href="total-female.php" <?php endif; ?>>
                    <div class="dashboard__card">
                        <div>
                            <div class="dashboard__card--value"><?php echo $totalFemale['femaleTotal']; ?>
                            </div>
                            <div class="dashboard__card--label">Total Female Residents</div>

                        </div>

                        <span class="dashboard__card--icon"><i class='bx bx-female'></i></span>
                    </div>
                </a>

                <a <?php if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder' && $user_role !== 'Barangay Clerk - Generate Clearance') : ?>href="registered-voters.php" <?php endif; ?>>
                    <div class="dashboard__card">
                        <div>
                            <div class="dashboard__card--value"><?php echo $totalVoters['voters']; ?></div>
                            <div class="dashboard__card--label">Registered Voters</div>
                        </div>

                        <span class="dashboard__card--icon"><i class='bx bxs-box'></i></span>
                    </div>
                </a>
            </div>


            <!-- CHARTS -->
            <div class="dashboard__charts">
                <div class="dashboard__chart dashboard__chart--chart2">
                    <label>
                        Total Population by Age Groups
                    </label>
                    <canvas id="myChart2"></canvas>
                </div>
                <div class="dashboard__chart dashboard__chart--chart3">
                    <label>
                        Total Population by Purok
                    </label>
                    <canvas id="myChart3"></canvas>
                </div>
            </div>

        </section>

    </div>
</main>


<!--=============== CHART JS ===============-->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script> -->
<script src="../../vendors/chart.min.js"></script>

<?php include "charts.php"; ?>

</body>

</html>