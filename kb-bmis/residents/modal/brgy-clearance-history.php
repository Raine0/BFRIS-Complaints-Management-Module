<div class="modal__wrapper" id="modal-brgy-clearance-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Resident Barangay Clearance History</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <table id="modal-table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clearanceQuery = "SELECT brgy_clearance_id, purpose, date_issued FROM brgy_clearance_view WHERE resident_id = :resident_id";

                    $clearanceStatement = $pdo->prepare($clearanceQuery);
                    $clearanceStatement->bindValue(':resident_id', $resident['resident_id']);

                    $clearanceStatement->execute();


                    while ($clearance = $clearanceStatement->fetch(PDO::FETCH_ASSOC)) {

                    ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="./../certificates/brgy-clearance-view.php?brgy_clearance_id=<?php echo $clearance['brgy_clearance_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">

                                        </div>
                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $clearance['brgy_clearance_id'] ?></div>
                                            <div>Purpose: <?php echo $clearance['purpose'] ?></div>
                                            <div>Date Issued: <?php echo date('m-d-Y h:i:s a', strtotime($clearance['date_issued'])) ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./../certificates/brgy-clearance-view.php?brgy_clearance_id=<?php echo $clearance['brgy_clearance_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                                        <i class='bx bxs-show'></i>
                                        VIEW CLEARANCE
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>