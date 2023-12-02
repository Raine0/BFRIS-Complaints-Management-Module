<!--=============== ADDING NEW OFFICIAL MODAL ===============-->
<div class="modal__wrapper" id="modal-newofficial">
  <section class="modal__window modal__window--md">
    <header class="modal__header">
      <h3>Add New Official</h3>
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
          $residentQuery = "SELECT * FROM resident_view WHERE occupation NOT IN (:chairman, :secretary, :treasurer, :councilor, :chairperson, :skcouncilor, :clerk, :kagawad) ORDER BY resident_id DESC";

          $residentStatement = $pdo->prepare($residentQuery);
          $residentStatement->bindValue(':chairman', 'Barangay Chairman');
          $residentStatement->bindValue(':secretary', 'Barangay Secretary');
          $residentStatement->bindValue(':treasurer', 'Barangay Treasurer');
          $residentStatement->bindValue(':councilor', 'Barangay Councilor');
          $residentStatement->bindValue(':chairperson', 'SK Chairperson');
          $residentStatement->bindValue(':skcouncilor', 'SK Councilor');
          $residentStatement->bindValue(':clerk', 'Barangay Clerk');
          $residentStatement->bindValue(':kagawad', 'Barangay Kagawad');
          $residentStatement->execute();


          while ($resident = $residentStatement->fetch(PDO::FETCH_ASSOC)) {

          ?>
            <tr>
              <td>
                <div class="table__row-img">
                  <img src="../residents/images/<?php echo $resident['img_url'] ?>" alt="">
                </div>
              </td>
              <td>
                <a href="create-official.php?resident_id=<?php echo $resident['resident_id'] ?>">
                  <div class="table__row-text">
                    <div class="table__row-name">
                      <?php echo $resident['last_name'] ?>,
                      <?php echo $resident['first_name'] ?>
                      <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                      <?php echo $resident['suffix'] ?>
                    </div>
                    <div class="table__row-sub">
                      <div>ID: <?php echo $resident['resident_id'] ?></div>
                    </div>
                  </div>
                </a>
              </td>
              <td>
                <div class="table__action-buttons">
                  <a href="create-official.php?resident_id=<?php echo $resident['resident_id'] ?>" class="button button--primary button--sm action__cert" id="action-cert">
                    SELECT RESIDENT
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