<!--=============== EDIT OFFICIAL MODAL ===============-->
<div class="modal__wrapper" id="modal-edit-<?php echo $setting['fee_setting_id'] ?>">
    <section class="modal__window modal__window--sm">
        <header class="modal__header">
            <h3>Edit User</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>

        <div class="modal__body">
            <form action="./update-fee.php" method="POST">
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
                    <input hidden type="text" name="fee_setting_id" value="<?php echo $setting['fee_setting_id'] ?>">
                </section>

                <footer class="modal__footer">
                    <button type="submit" name="submit" class="button button--danger button--md">EDIT</button>
                    <a class="button button--dark button--md modal__cancel close">CANCEL</a>
                </footer>
            </form>
        </div>
    </section>
</div>