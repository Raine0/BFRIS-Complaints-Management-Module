<div class="modal__wrapper" id="modal-low-income-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Resident Low Income Certificate History</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <table id="good-moral-history-modal" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lowIncomeQuery = "SELECT low_income_id, last_name, first_name, mid_name, suffix, date_issued FROM low_income_certificate LEFT JOIN resident ON low_income_certificate.resident_id = resident.resident_id WHERE low_income_certificate.resident_id = :resident_id";

                    $lowIncomeStatement = $pdo->prepare($lowIncomeQuery);
                    $lowIncomeStatement->bindValue(':resident_id', $lowIncome['resident_id']);

                    $lowIncomeStatement->execute();


                    while ($lowIncome = $lowIncomeStatement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="./low-income-view.php?low_income_id=<?php echo $lowIncome['low_income_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $lowIncome['last_name'] ?>,
                                            <?php echo $lowIncome['first_name'] ?>
                                            <?php echo $lowIncome['mid_name'] ? mb_substr($lowIncome['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                            <?php echo $lowIncome['suffix'] ?>
                                        </div>
                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $lowIncome['low_income_id'] ?></div>
                                            <div>Date Issued: <?php echo date('m-d-Y h:i:s a', strtotime($lowIncome['date_issued'])) ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./low-income-view.php?low_income_id=<?php echo $lowIncome['low_income_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                                        <i class='bx bxs-show'></i>
                                        VIEW CERTIFICATE
                                    </a>
                                </div>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>