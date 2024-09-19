<dialog class="sign-in" id="signInPopup">
    <header class="sign-in__header">
        <h3 class="sign-in__title h3">Sign in to Realto</h3>
        <form method="dialog" class="sign-in__cross-button-wrapper cross-button__wrapper">
            <button class="sign-in__cross-button cross-button cross-button--thick">
                <span class="visually-hidden">Close sign up window</span>
            </button>
        </form>
    </header>
    <div class="sign-in__body">
        <ul class="sign-in__options">
            <li class="sign-in__option">
                <button class="sign-in__option-button--selected sign-in__option-button" data-sign-in-option="log-in">Log in</button>
            </li>
            <li class="sign-in__option">
                <button class="sign-in__option-button" data-sign-in-option="sign-up">Create new account</button>
            </li>
        </ul>
        <form class="display-contents" id="sign-in-form">
            <div class="sign-in__fields">
                <label for="sign-in-email" class="sign-in__field field">
                    <span class="sign-in__label field__label">Email</span>
                    <input type="email" class="sign-in__input field__input" placeholder="example@example.com" name="email" required>
                </label>
                <label class="sign-in__field field">
                    <span class="sign-in__label field__label">Password</span>
                    <input type="password" class="sign-in__input field__input" placeholder="Your password" name="password" required>
                </label>
                <label class="sign-in__field field sign-in__sign-up-fields">
                    <span class="sign-in__label field__label">Repeat password</span>
                    <input type="password" class="sign-in__input field__input" placeholder="Your password" name="repeat-password" required>
                </label>
                <label class="sign-in__field field sign-in__sign-up-fields">
                    <span class="sign-in__label field__label">First name</span>
                    <input type="text" class="sign-in__input field__input" placeholder="First name" name="first-name" required>
                </label>
                <label class="sign-in__field field sign-in__sign-up-fields">
                    <span class="sign-in__label field__label">Last name</span>
                    <input type="text" class="sign-in__input field__input" placeholder="Last name" name="last-name">
                </label>
                
            </div>
            <div class="sign-in__buttons">
                <button class="sign-in__button button sign-in__log-in-fields" type="submit">Log in</button>
                <button class="sign-in__link link bold sign-in__log-in-fields">Forgot your password?</button>
                <button class="sign-in__button button sign-in__sign-up-fields" type="submit">Create account</button>
                <input type="hidden" name="sign-in-action" id="sign-in-action">
            </div>
        </form>
    </div>
</dialog>