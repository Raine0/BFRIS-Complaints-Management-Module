<?php
$page = 'Archive';
$headerTitle = 'Archive';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../");
    exit();
} else {
    $user_role = $_SESSION['role'];
}
?>
<main>
    <div class="content">
        <section class="archive" style="height: 80vh;">
            <div class="center--row col" style="gap: 50px;">
                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Resident Admin') : ?>
                    <a href="resident-archive.php" class="button button--primary button--xl certificates__button modal-trigger" data-modal-id="modal-brgyclearance">
                        <i class='bx bxs-group'></i>
                        <p>RESIDENTS</p>
                    </a>
                <?php endif; ?>

                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>
                    <a href="official-archive.php" class="button button--primary button--xl certificates__button">
                        <i class='bx bx-user-voice'></i>
                        <p>BARANGAY OFFICIALS</p>
                    </a>
                <?php endif; ?>

                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin') : ?>
                    <a href="" class="button button--primary button--xl certificates__button">
                        <i class='bx bxs-notepad'></i>
                        <p>COMPLAINT</p>
                    </a>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>
</body>

</html>