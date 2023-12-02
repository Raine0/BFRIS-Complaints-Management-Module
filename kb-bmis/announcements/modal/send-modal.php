<form id="send_announcement" action="send.php" method="post" enctype="multipart/form-data" data-parsley-validate="">
    <!--=============== MODALS ===============-->
    <div class="modal__wrapper" id="modal-sendmessage">
        <section class="modal__window">
            <header class="modal__header">
                <h3>Announcement</h3>
                <button type="button" class="modal__close close" aria-label="Close modal window">
                    <i class='bx bx-x'></i>
                </button>
            </header>
            <div class="modal__body" style="align-items: flex-start; padding: 0 20px;">
                <div class="announcements__contacts">
                    <label>Recipients</label>
                    <div class="input__inner">
                        <div class="select__wrapper select__wrapper--announcements">
                            <select required name="recipients" id="" class="select select--announcements input-viewprofile input-viewprofile">
                                <option value="" disabled selected>Select</option>
                                <option value="All Residents">All residents</option>
                                <option value="Barangay Officials">Barangay Officials</option>
                                <option value="Senior Citizens">Senior Citizens</option>
                                <option value="Persons with Disability">Persons with Disability</option>
                                <option value="Registered Voters">Registered Voters</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="announcements__message">
                    <label>Message</label>
                    <div class="message__container">
                        <div class="message__field">
                            <textarea required name="message" id="" placeholder="Type your message here"></textarea>
                        </div>

                        <div>

                        </div>
                    </div>
                </div>
            </div>
            <footer class="modal__footer">
                <button class="button button--md button--primary send-btn" name="btn_save"><i class='bx bx-send'></i>
                    SEND</button>
                <a href="#" class="button button--dark button--md modal__cancel close">CANCEL</a>
            </footer>
        </section>
    </div>
</form>