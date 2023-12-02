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
          <ul class="history-info__list" style="margin: 0">
            <li class="history-info__item history-info__item--active complainantTab">
              <span>
                Complainant
              </span>
            </li>

            <li class="history-info__item respondentTab">
              <span>
                Respondent
              </span>
            </li>
          </ul>

          <tr>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>

        <tbody class="history-info__content complainantTab" style="display: block;">
          <?php
          $complainantQuery = "SELECT * FROM resident_complaint_view WHERE complainant_resident_id = :resident_id ";

          $complainantStatement = $pdo->prepare($complainantQuery);
          $complainantStatement->bindValue(':resident_id', $resident['resident_id']);
          $complainantStatement->execute();


          while ($complainant = $complainantStatement->fetch(PDO::FETCH_ASSOC)) {

          ?>
            <tr>
              <td></td>
              <td>
                <a href="./../complaint/resident-complaint-view.php?case_no=<?php echo $complainant['case_no'] ?>">
                  <div class="table__row-text">
                    <div class="table__row-name">
                    </div>
                    <div class="table__row-sub">
                      <div>Reason: <?php echo $complainant['reason'] ?></div>
                      <div>Complaint Status: <?php echo $complainant['complaint_status'] ?></div>
                      <div>Case No: <?php echo $complainant['case_no'] ?></div>
                    </div>
                  </div>
                </a>
              </td>
              <td>
                <div class="table__action-buttons">
                  <a href="./../complaint/resident-complaint-view.php?case_no=<?php echo $complainant['case_no'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                    VIEW COMPLAINT
                  </a>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        
        <tbody class="history-info__content respondentTab" style="display:none;">
          <?php
          $respondentQuery = "SELECT case_no, reason, complaint_status FROM resident_complaint_view WHERE respondent_resident_id = :resident_id";

          $respondentStatement = $pdo->prepare($respondentQuery);
          $respondentStatement->bindValue(':resident_id', $resident['resident_id']);
          $respondentStatement->execute();


          while ($respondent = $respondentStatement->fetch(PDO::FETCH_ASSOC)) {

          ?>
            <tr>
              <td></td>
              <td>
                <a href="./../complaint/resident-complaint-view.php?case_no=<?php echo $respondent['case_no'] ?>">
                  <div class="table__row-text">
                    <div class="table__row-name">
                    </div>
                    <div class="table__row-sub">
                      <div>Reason: <?php echo $respondent['reason'] ?></div>
                      <div>Complaint Status: <?php echo $respondent['complaint_status'] ?></div>
                      <div>Case No: <?php echo $respondent['case_no'] ?></div>
                    </div>
                  </div>
                </a>
              </td>
              <td>
                <div class="table__action-buttons">
                  <a href="./../complaint/resident-complaint-view.php?case_no=<?php echo $respondent['case_no'] ?>" class="button button--green button--sm action__cert" id="action-cert">
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