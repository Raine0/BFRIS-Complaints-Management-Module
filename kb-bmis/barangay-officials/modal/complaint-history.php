<!--=============== ADDING NEW OFFICIAL MODAL ===============-->
<div class="modal__wrapper" id="modal-complaint-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Resident Complaint History</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <table id="complaint-history-modal" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $complaintQuery = "SELECT case_no, complainant_name, respondent_name FROM resident_complaint_view WHERE official_id = :official_id";

                    $complaintStatement = $pdo->prepare($complaintQuery);
                    $complaintStatement->bindValue(':official_id', $official['official_id']);
                    $complaintStatement->execute();


                    while ($complaint = $complaintStatement->fetch(PDO::FETCH_ASSOC)) {

                    ?>
                        <tr>
                            <td></td>
                            <td>
                                <a href="./../complaint/resident-complaint-view.php?case_no=<?php echo $complaint['case_no'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                        </div>
                                        <div class="table__row-sub">
                                            <div>Complainant: <?php echo $complaint['complainant_name'] ?></div>
                                            <div>Respondent: <?php echo $complaint['respondent_name'] ?></div>
                                            <div>Case No: <?php echo $complaint['case_no'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./../complaint/resident-complaint-view.php?case_no=<?php echo $complaint['case_no'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                                        VIEW COMPLAINT
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