/*document.addEventListener('DOMContentLoaded', () => {
    const chatsPopups = document.querySelectorAll('.chats');
    const chatsOpenButton = document.getElementById('chatsOpenButton');
    const supportTicketsOpenButton = document.getElementById('supportTicketsOpenButton');
    function initializeInput () {
        input = chatsPopup.querySelector('.write-message__input');
        inputPanel = chatsPopup.querySelector('.chats__chat-write-message');
        if (input && input !== 0) {
            function displayPlaceholder() {
                if (input.innerText.trim() === '') {
                    input.style.setProperty('--displayPlaceholder', 'inline');
                }
                else {
                    input.style.setProperty('--displayPlaceholder', 'none');
                }
            }

            input.addEventListener('input', displayPlaceholder);
        }
        input.addEventListener('focus', () => {
            inputPanel.classList.add('shadow');
        });
    
        input.addEventListener('blur', () => {
            inputPanel.classList.remove('shadow');
        });
    }
    function slideToBottom() {
        const messagesList = chatsPopup.querySelector('.chats__chat-messages');
        messagesList.scrollTop = messagesList.scrollHeight;
    }


    chatsOpenButton.addEventListener('click', () => {
        initializeInput();
        slideToBottom();
    })
    supportTicketsOpenButton.addEventListener('click', () => {
        initializeInput();
        slideToBottom();
    })

    
    
})*/


document.addEventListener('DOMContentLoaded', () => {
    const openButtons = document.querySelectorAll('.open-chat-button'); // Assuming buttons have a common class

    function initializeInput(chatPopup) {
        const input = chatPopup.querySelector('.write-message__input');
        const inputPanel = chatPopup.querySelector('.chats__chat-write-message');
        if (input) {
            function displayPlaceholder() {
                if (input.innerText.trim() === '') {
                    input.style.setProperty('--displayPlaceholder', 'inline');
                } else {
                    input.style.setProperty('--displayPlaceholder', 'none');
                }
            }

            input.addEventListener('input', displayPlaceholder);

            input.addEventListener('focus', () => {
                inputPanel.classList.add('shadow');
            });

            input.addEventListener('blur', () => {
                inputPanel.classList.remove('shadow');
            });
        }
    }

    function slideToBottom(chatPopup) {
        const messagesList = chatPopup.querySelector('.chats__chat-messages');
        if (messagesList) {
            messagesList.scrollTop = messagesList.scrollHeight;
        }
    }

    function handleOpenButtonClick(button) {
        const targetPopupSelector = button.dataset.target;
        const chatPopup = document.querySelector('#' + targetPopupSelector);
        if (chatPopup) {
            initializeInput(chatPopup);
            slideToBottom(chatPopup);
        }
    }

    openButtons.forEach(button => {
        button.addEventListener('click', () => handleOpenButtonClick(button));
    });
});

