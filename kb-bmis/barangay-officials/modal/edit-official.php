<!--=============== EDIT OFFICIAL MODAL ===============-->
<div class="modal__wrapper" id="modal-edit-<?php echo $official['official_id'] ?>">
    <section class="modal__window modal__window--sm">
        <header class="modal__header">
            <h3>Edit Official</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>

        <div class="modal__body">
            <form action="update-official.php" method="POST">
                <section class="profile-info__basic-info">
                    <div class="profile-info__container">
                        <div class="input__wrapper">
                            <label for="password">Password <strong style="color: red;">*</strong></label>
                            <div class="input__inner--with-leading-icon input__inner">
                                <i class="bx bxs-lock input__icon input__icon--left"></i>

                                <input name="password" type="password" class="input--light300 input--login" id="edit-password" placeholder="Password" required />

                                <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('edit-password', this)"> </i>
                            </div>
                        </div>
                    </div>
                </section>

                <input type="text" hidden name="official_id" value="<?php echo $official['official_id']; ?>">
                <input type="text" hidden name="resident_id" value="<?php echo $official['resident_id']; ?>">

                <footer class="modal__footer">
                    <button type="submit" name="submit" class="button button--danger button--md">EDIT</button>
                    <a class="button button--dark button--md modal__cancel close">CANCEL</a>
                </footer>
            </form>
        </div>
    </section>
</div>