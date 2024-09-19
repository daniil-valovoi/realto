import { displayLoggedInUserData } from '/realto/scripts/javascript/functions/user-data.js';

document.addEventListener('DOMContentLoaded', () => {
    const signInButtons = document.querySelectorAll('.sign-in-button');
    signInButtons.forEach((signInButton) => {
        signInButton.addEventListener('click', () => {
            const signInPopup = document.getElementById('signInPopup');
            const options = signInPopup.querySelectorAll('.sign-in__option-button');
            const logInFields = signInPopup.querySelectorAll('.sign-in__log-in-fields');
            const signUpFields = signInPopup.querySelectorAll('.sign-in__sign-up-fields');
            toggleAction('log-in');
            options.forEach((option) => {
                option.addEventListener('click', () => {
                    options.forEach((option) => {
                        option.classList.remove('sign-in__option-button--selected');
                    })
                    option.classList.add('sign-in__option-button--selected');
                    const optionVariant = option.dataset.signInOption;
                    switch (optionVariant) {
                        case 'log-in':
                            showFields(logInFields, signUpFields);
                            toggleAction('log-in');
                            break;
                        case 'sign-up':
                            showFields(signUpFields, logInFields);
                            toggleAction('sign-up');
                            break;
                    }
                })
            })
            showFields(logInFields, signUpFields);
            const form = document.getElementById('sign-in-form');
            form.addEventListener('submit', sendForm);
        })
    })

})

function showFields(showElements, hideElements) {
    
    showElements.forEach((showElement) => {
        showElement.classList.remove('display-none');
        const inputs = showElement.querySelectorAll('input, select, textarea');
        inputs.forEach((input) => input.disabled = false);
    });

    hideElements.forEach((hideElement) => {
        hideElement.classList.add('display-none');
        const inputs = hideElement.querySelectorAll('input, select, textarea');
        inputs.forEach((input) => input.disabled = true);
    });
}


async function sendForm(event) {
    event.preventDefault();
    const form = event.currentTarget;
    const formData = new FormData(form);

    try {
        const response = await fetch('/realto/scripts/php/api/sign-in.php', {
            method: 'POST',
            body: formData,
            headers: {
                'ajax-request': 'true'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        handleResponse(result);
    } catch (error) {
        console.error('An error occurred:', error);
        alert('There was an issue submitting the form. Please try again later.');
    }
}

function handleResponse(result) {
    if (result.status) {
        alert('Successful authentication');
        document.getElementById('signInPopup').close();
        displayLoggedInUserData();

    } else {
        alert(`Error: ${result.error}`);
    }
}

function toggleAction(action) {
    const actionInput = document.getElementById('sign-in-action');
    actionInput.value = action;
}