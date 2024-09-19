const dataSelector = 'data-logged-in-user-';
export async function displayLoggedInUserData() {
    let loggedIn = false;
    const response = await fetch('/realto/scripts/php/api/fetch-user-data.php', {
        headers: {
            'ajax-request': 'true'
        }
    });
    
    if (response.ok) {
        try {
            const fullUserData = await response.json();
            if(fullUserData.logged_in) {
                loggedIn = true;
                const userData = fullUserData.user;
                if (userData && userData !== '') {
                    populateElements('name', userData.name);
                    populateElements('id', userData.id);
                    populateElements('role', userData.role);
                    populateElements('profile-picture', userData.profile_picture, true);
                    populateElements('email', userData.email);
                }
            }
        } catch (error) {
            console.error('Error processing response: ' + error);
        }
    } else {
        console.error('Response was not ok: ' + response.status);
    }
    showRestrictedContent(loggedIn);
}

function populateElements(elementName, value, isImage = false) {
    const elements = document.querySelectorAll(`[${dataSelector}${elementName}]`);

    elements.forEach((element) => {
        if (!isImage) {
            element.innerHTML = value;
        } else if (element.hasAttribute('src')) {
            element.src = value;
        }
    });
}

function showRestrictedContent(loggedIn) {
    const authElements = document.querySelectorAll('.restricted-content--auth');
    const notAuthElements = document.querySelectorAll('.restricted-content--not-auth');

    authElements.forEach(element => {
        element.style.display = loggedIn ? '' : 'none';
    });

    notAuthElements.forEach(element => {
        element.style.display = loggedIn ? 'none' : '';
    });
}

