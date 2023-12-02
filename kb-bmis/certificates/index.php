<?php
$page = 'Certificates';
$headerTitle = 'Certificates';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

$user_role = $_SESSION['role'];
?>


<main>
  <div class="content" id="content-certificates">
    <section class="certificates">
      <div class="center--row">

        <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
          <a href="brgy-clearance-list.php" class="button button--primary button--xl certificates__button modal-trigger">
            <i class='bx bx-file'></i>
            <p>BARANGAY CLEARANCE</p>
          </a>

          <a href="good-moral-list.php" class="button button--primary button--xl certificates__button modal-trigger">
            <i class='bx bx-file'></i>
            <p>GOOD MORAL CERTIFICATE</p>
          </a>

          <a href="jobseeker-list.php" class="button button--primary button--xl certificates__button modal-trigger">
            <i class='bx bx-file'></i>
            <p>JOBSEEKERS CERTIFICATE</p>
          </a>

          <a href="residency-list.php" class="button button--primary button--xl certificates__button modal-trigger">
            <i class='bx bx-file'></i>
            <p>RESIDENCY CERTIFICATE</p>
          </a>

          <a href="osca-list.php" class="button button--primary button--xl certificates__button modal-trigger">
            <i class='bx bx-file'></i>
            <p>OSCA CERTIFICATE</p>
          </a>

          <a href="low-income-list.php" class="button button--primary button--xl certificates__button modal-trigger">
            <i class='bx bx-file'></i>
            <p>LOW INCOME CERTIFICATE</p>
          </a>

        <?php endif; ?>

      </div>
    </section>
  </div>
</main>
</body>

</html>