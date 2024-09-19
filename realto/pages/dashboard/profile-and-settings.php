            
                <div class="info-card">
                    <header class="info-card__info info-card__info--border-bottom">
                        <h2 class="info-card__subheading">Profile & settings</h2>
                    </header>
                </div>
                <div class="info-card">
                    <header class="info-card__info info-card__info--border-bottom">
                        <h3 class="info-card__subheading">General information</h3>
                    </header>
                    <form class="info-card__main" data-profile-and-settings-form="general-information" enctype="multipart/form-data"> <!--experimental input into label nesting-->
                        <div class="dashboard__field-row field__row">
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    Name
                                </span>
                                <input type="text" class="dashboard__field-input field__input" placeholder="Name" name="name">
                            </label>
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    Last name
                                </span>
                                <input type="text" class="dashboard__field-input field__input" placeholder="Last name" name="last-name">
                            </label>
                        </div>
                        <!--<label class="dashboard__field field">
                            <span class="dashboard__field-label field__label">
                                Phone number
                            </span>
                            <input type="number" class="dashboard__field-input field__input" placeholder="123456789" name="phone-number">
                        </label>-->
                        <div class="column gap--8">
                            <span>Profile picture</span>
                            <div class="row gap--12 align-center">
                                <img src="<?php echo $pageUserProfilePicturePath?>" alt="Your profile picture" class="dashboard__profile-and-settings-profile-picture user-info__profile-picture" data-logged-in-user-profile-picture>
                                <div class="row gap--8">
                                    <label class="dashboard__file-upload-button file-upload__button" tabindex="0">
                                        Upload new
                                        <svg class="dashboard__file-upload-button-icon icon" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 8.82227V11.4889C13 11.8426 12.8595 12.1817 12.6095 12.4317C12.3594 12.6818 12.0203 12.8223 11.6667 12.8223H2.33333C1.97971 12.8223 1.64057 12.6818 1.39052 12.4317C1.14048 12.1817 1 11.8426 1 11.4889V8.82227M10.3333 4.1556L7 0.822266M7 0.822266L3.66667 4.1556M7 0.822266V8.82227" stroke="none" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <input name="new-profile-picture" type="file" accept="image/jpeg, image/jpg, image/png, image/webp" class="visually-hidden" tabindex="-1">
                                    </label>
                                    <label class="dashboard__file-upload-button file-upload__button" type="button" tabindex="0">
                                        Delete current
                                        <svg class="dashboard__file-upload-button-icon icon" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.5 5.82194H3.83333M3.83333 5.82194H22.5M3.83333 5.82194V22.1553C3.83333 22.7741 4.07917 23.3676 4.51675 23.8052C4.95434 24.2428 5.54783 24.4886 6.16667 24.4886H17.8333C18.4522 24.4886 19.0457 24.2428 19.4832 23.8052C19.9208 23.3676 20.1667 22.7741 20.1667 22.1553V5.82194M7.33333 5.82194V3.48861C7.33333 2.86977 7.57917 2.27628 8.01675 1.83869C8.45434 1.40111 9.04783 1.15527 9.66667 1.15527H14.3333C14.9522 1.15527 15.5457 1.40111 15.9832 1.83869C16.4208 2.27628 16.6667 2.86977 16.6667 3.48861V5.82194" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <input type="radio" name="delete-profile-picture" class="visually-hidden" tabindex="-1" id="delete-profile-picture-button">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="form-destination" value="general-information">
                        <button class="dashboard__button button">Update information</button>
                    </form>
                </div>
                <div class="info-card">
                    <header class="info-card__info info-card__info--border-bottom">
                        <h3 class="info-card__subheading">Login & security</h3>
                    </header>
                    <form class="info-card__main" data-profile-and-settings-form="login-and-security">
                        <header class="info-card__info">
                            <h4 class="info-card__subheading">Change email</h4>
                        </header>
                        <div class="dashboard__field-row field__row">
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    Email
                                </span>
                                <input type="text" class="dashboard__field-input field__input" placeholder="Name" name="email">
                            </label>
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    Password
                                </span>
                                <input type="password" class="dashboard__field-input field__input" placeholder="Password" name="password">
                            </label>
                        </div>
                        <header class="info-card__info">
                            <h4 class="info-card__subheading">Change password</h4>
                        </header>
                        <div class="dashboard__field-row field__row">
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    Old password
                                </span>
                                <input type="password" class="dashboard__field-input field__input" placeholder="Old password" name="old-password">
                            </label>
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    New password
                                </span>
                                <input type="password" class="dashboard__field-input field__input" placeholder="New password" name="new-password">
                            </label>
                            <label class="dashboard__field field">
                                <span class="dashboard__field-label field__label">
                                    Repeat new password
                                </span>
                                <input type="password" class="dashboard__field-input field__input" placeholder="New password" name="repeat-new-password">
                            </label>
                        </div>
                        <input type="hidden" name="form-destination" value="login-and-security">
                        <button class="dashboard__button button" type="submit">Update information</button>
                    </form>
                </div>
            