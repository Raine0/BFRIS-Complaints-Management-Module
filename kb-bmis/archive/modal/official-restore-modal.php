<div class="modal__wrapper" id="modal-restore">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Restore Profile</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <p> Are you sure you want to restore
                <strong>
                    <?php echo $official['first_name']; ?>
                    <?php echo $official['last_name']; ?>
                    <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                    <?php echo $official['suffix'] ?>
                </strong>?
            </p>

            <br>

            <form action="controllers/official-restore.php" method="POST">
                <section class="profile-info__basic-info">
                    <div class="profile-info__container">
                        <div class="input__wrapper">
                            <label>Password <strong style="color: red;">*</strong></label>
                            <div class="input__inner--with-leading-icon input__inner">
                                <i class="bx bxs-lock input__icon input__icon--left"></i>

                                <input name="password" type="password" id="password" class="input--light300 input--login" placeholder="Password" style="width: 100%;" required>

                                <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('password', this)"> </i>
                            </div>
                        </div>
                    </div>
                </section>

                <input type="text" hidden name="official_archive_id" value="<?php echo $official['official_archive_id']; ?>">

                <footer class="modal__footer">
                    <button type="submit" name="restore" class="button button--danger button--md">RESTORE</button>
                    <a class="button button--dark button--md modal__cancel close">CANCEL</a>
                </footer>
            </form>
        </div>
    </section>
</div>