<form action="" class="chats__write-message write-message">
    <label>
        <span class="visually-hidden">Write a message</span>
        <textarea class="visually-hidden" name="message"></textarea>
        <div class="write-message__input" contenteditable></div>
    </label>
    <label class="write-message__file-button" tabindex="0">
        <span class="visually-hidden">Send an image</span>
        <svg class="write-message__file-button-icon icon" width="13" height="22" viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.1449 4.38L11.1449 15.2105C11.1449 16.5373 10.6178 17.8098 9.67964 18.748C8.74144 19.6862 7.46896 20.2133 6.14214 20.2133C4.81532 20.2133 3.54285 19.6862 2.60464 18.748C1.66644 17.8098 1.13936 16.5373 1.13936 15.2105L1.13936 4.38C1.13936 3.49545 1.49075 2.64713 2.11622 2.02166C2.74168 1.39619 3.59 1.04481 4.47455 1.04481C5.3591 1.04481 6.20741 1.39619 6.83288 2.02166C7.45835 2.64713 7.80974 3.49545 7.80974 4.38L7.80384 15.2164C7.80384 15.6587 7.62815 16.0828 7.31542 16.3956C7.00268 16.7083 6.57852 16.884 6.13625 16.884C5.69398 16.884 5.26982 16.7083 4.95708 16.3956C4.64435 16.0828 4.46866 15.6587 4.46866 15.2164L4.47455 5.21674" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <input type="file" class="visually-hidden" name="file" accept="image/jpeg, image/png, image/webp" tabindex="-1">
    </label>
    <label class="write-message__send-button" tabindex="0">
        <span class="visually-hidden">Send the message</span>
        <svg class="write-message__send-button-icon icon" width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24.6666 1.69238L11.8333 14.5257M24.6666 1.69238L16.5 25.0257L11.8333 14.5257M24.6666 1.69238L1.33331 9.85905L11.8333 14.5257" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <input type="submit" class="visually-hidden" tabindex="-1">
    </label>
</form>