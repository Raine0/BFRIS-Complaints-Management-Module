<?php
$page = 'Complaints';
$headerTitle = 'Complaints';


require_once "../../includes/header.php";
include "../../includes/preloader.php";

$user_role = $_SESSION['role'];

?>


<main>
    <div class="content" id="content-certificates">
        <section class="certificates">
            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder') : ?>
                <div class="center--row" style="gap: 50px;">
                    <a href="resident-complaint-list.php" class="button button--primary button--xl certificates__button modal-trigger">
                        <i class='bx bx-notepad'></i>
                        <p>RESIDENT COMPLAINT</p>
                    </a>

                    <a href="non-resident-complaint-list.php" class="button button--primary button--xl certificates__button modal-trigger">
                        <i class='bx bx-notepad'></i>
                        <p>NON-RESIDENT COMPLAINT</p>
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
</body>

</html>