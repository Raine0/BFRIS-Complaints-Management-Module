<?php
$page = 'Reports';
$headerTitle = 'Reports';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

?>
<main>
    <div class="content">
        <section class="reports" style="height: 80vh;">
            <div class="center--row col" style="gap: 50px;">
                <a href="graphical-view.php" class="button button--primary button--xl certificates__button modal-trigger" data-modal-id="modal-brgyclearance">
                    <i class='bx bxs-bar-chart-square'></i>
                    <p>GRAPHICAL VIEW</p>
                </a>

                <a href="brgy-transactions.php" class="button button--primary button--xl certificates__button tabular">
                    <i class='bx bx-table'></i>
                    <p>TABULAR VIEW</p>
                </a>
            </div>
        </section>
    </div>
</main>
</body>

</html>