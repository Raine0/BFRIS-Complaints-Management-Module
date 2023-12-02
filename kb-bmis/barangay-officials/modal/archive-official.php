<!--=============== ARCHIVING OFFICIAL MODAL ===============-->
<div class="modal__wrapper" id="modal-delete">
  <section class="modal__window modal__window--md">
    <header class="modal__header">
      <h3>End Term</h3>
      <button type="button" class="modal__close close" aria-label="Close modal window">
        <i class='bx bx-x'></i>
      </button>
    </header>
    <div class="modal__body">
      <p> Are you sure you want to move
        <strong>
          <?php echo $official['last_name'] ?>,
          <?php echo $official['first_name'] ?>
          <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
          <?php echo $official['suffix'] ?>
        </strong>
        into the Barangay Officials Archive?
      </p>
    </div>

    <br>
    <form action="controller/archive.php" method="POST">
      <input type="text" hidden name="official_id" value="<?php echo $official['official_id']; ?>">
      <input type="text" hidden name="resident_id" value="<?php echo $official['resident_id'];  ?>">
      <input type="text" hidden name="off_position" value="<?php echo $official["off_position"]; ?>">
      <input type="text" hidden name="term" value="<?php echo $official['term'] ?>">

      <section class="profile-info__basic-info">
        <div class="profile-info__container">
          <div class="input__wrapper">
            <label>Reason of Archive <strong style="color: red;">*</strong></label>
            <div class="input__inner">
              <input name="remarks" type="text" class="input--light300 input--login" value="End of Term" readonly />
            </div>
          </div>
        </div>

        <div class="profile-info__container">
          <div class="input__wrapper">
            <label for="password">Password <strong style="color: red;">*</strong></label>
            <div class="input__inner--with-leading-icon input__inner">
              <i class="bx bxs-lock input__icon input__icon--left"></i>

              <input name="password" type="password" class="input--light300 input--login" id="password" placeholder="Password" required />

              <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('password', this)"> </i>
            </div>
          </div>
        </div>
      </section>
      <footer class="modal__footer">
        <button type="submit" name="submit" class="button button--danger button--md">ARCHIVE</button>
        <a class="button button--dark button--md modal__cancel close">CANCEL</a>
      </footer>
    </form>
  </section>
</div>