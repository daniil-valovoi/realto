import { displayLoggedInUserData } from "/realto/scripts/javascript/functions/user-data.js";

document.addEventListener('DOMContentLoaded', ()=> {
    const forms = document.querySelectorAll('[data-profile-and-settings-form]');
    forms.forEach((form) => {
        form.addEventListener('submit', sendFormData);
    })
})

async function sendFormData(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    var url = '/realto/scripts/php/blocks/dashboard/profile-and-settings.php';

    
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'ajax-request': 'true'
                }
        });

        if (response.ok) {
            const result = await response.json();
            if(result.success) {
                alert('Data successfully updated');
            }
            else {
                alert(result.error);
            }
        } 
        else {
            console.error('Request failed with status:', response.status);
        }
    } 
    catch (error) {
        console.error('Error sending form:', error);
    }

    displayLoggedInUserData();

};
