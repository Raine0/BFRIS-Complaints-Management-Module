<div class="modal__wrapper" id="modal-jobseeker-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Resident Jobseeker Certificate History</h3>
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
                    $jobseekerQuery = "SELECT jobseeker_id, last_name, first_name, mid_name, suffix, date_issued FROM jobseeker_certificate LEFT JOIN resident ON jobseeker_certificate.resident_id = resident.resident_id WHERE jobseeker_certificate.resident_id = :resident_id";

                    $jobseekerStatement = $pdo->prepare($jobseekerQuery);
                    $jobseekerStatement->bindValue(':resident_id', $jobseeker['resident_id']);

                    $jobseekerStatement->execute();


                    while ($jobseeker = $jobseekerStatement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="./jobseeker-view.php?jobseeker_id=<?php echo $jobseeker['jobseeker_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $jobseeker['last_name'] ?>,
                                            <?php echo $jobseeker['first_name'] ?>
                                            <?php echo $jobseeker['mid_name'] ? mb_substr($jobseeker['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                            <?php echo $jobseeker['suffix'] ?>
                                        </div>
                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $jobseeker['jobseeker_id'] ?></div>
                                            <div>Date Issued: <?php echo date('m-d-Y h:i:s a', strtotime($jobseeker['date_issued'])) ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./jobseeker-view.php?jobseeker_id=<?php echo $jobseeker['jobseeker_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                                        <i class='bx bxs-show'></i>
                                        VIEW JOBSEEKER
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