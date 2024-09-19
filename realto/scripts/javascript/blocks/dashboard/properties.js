export async function displayProperties() {
    const propertiesContainer = document.querySelector('.dashboard__item-list');
    propertiesContainer.innerHTML='';
    const response = await fetch('/realto/scripts/php/blocks/dashboard/display-properties.php', {
        headers: {
            'ajax-request': 'true'
        }
    });
    if (response.ok) {
        try {
            const result = await response.json();
            if (result.empty) {
                throw new Error("No properties available");
            }
            const properties = result.properties;
            
            properties.forEach(property => {
                var buttonAction = null;
                var buttonText = null;

                if(property.status_id === 1) {
                    buttonAction = 'deactivate';
                    buttonText = 'Deactivate';
                }
                if(property.status_id === 2) {
                    buttonAction = 'activate';
                    buttonText = 'Activate';
                }

                const propertyCard = document.createElement('li');
                propertyCard.dataset.dashboardElementType = 'property';
                propertyCard.dataset.dashboardElementId = property.property_id;
                propertyCard.classList.add('listing');
                propertyCard.innerHTML = `
                <div class="listing__image-container">
                    <img src="/realto/images/property-images/${property.image_name}" alt="Listing main image" class="listing__image">
                </div>
                <div class="listing__details">
                    <div class="listing__main-details">
                        <div class="listing__top-details">
                            <h3 class="dashboard__listing-title listing__title" >${property.title}</h3>
                            <span class="listing__address">
                                <span class="visually-hidden">Address</span>
                                ${property.address} ${property.zip}, ${property.district_name}
                            </span>
                        </div>
                    </div>
                    <ul class="listing__actions">
                        <li class="listing__action">
                            <button class="link" data-dashboard-element-action="${buttonAction}">${buttonText}</button>
                        </li>
                        <li class="listing__action">
                            <button class="link" data-dashboard-element-action="delete">Delete</button>
                        </li>
                    </ul>
                    <div class="listing__other-details">
                        <ul class="listing__other-details-list">
                            <li class="listing__other-details-item">
                                <span class="listing__other-details-detail">
                                    ID: ${property.property_id}
                                </span>
                            </li>
                            <li class="listing__other-details-item">
                                <span class="listing__other-details-detail">
                                    ${property.status_name}
                                </span>
                            </li>
                        </ul>
                        <a href="/realto/pages/property-page.php?id=${property.property_id}" class="listing__link link bold">
                            See details
                            <svg class="listing__link-icon link__icon icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.3335 5.82292H10.6668M10.6668 5.82292L6.00016 1.15625M10.6668 5.82292L6.00016 10.4896" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            `;
                propertiesContainer.appendChild(propertyCard);
                const propertyActions = propertyCard.querySelectorAll('[data-dashboard-element-action]');
                propertyActions.forEach(action => {
                    action.addEventListener('click', handleAction);
                })
            });
        }
        catch (error) {
            alert(error);
        }
    }
}

async function handleAction(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const parent = button.closest('[data-dashboard-element-type]');

    const targetType = parent.dataset.dashboardElementType;
    const targetId = parent.dataset.dashboardElementId;
    const action = button.dataset.dashboardElementAction;

    if(action === 'delete') {
        if(!confirm(`Do you really want to delete this ${targetType}?`)) {
            return;
        }
    }

    const formData = new FormData();
    formData.append('action', action);
    formData.append('target-type', targetType);
    formData.append('target-id', targetId);

    const response = await fetch('/realto/scripts/php/api/handle-action.php', {
        method: 'POST',
        body: formData,
        headers: {
            'ajax-request': 'true'
        }
    });

    if (response.ok) {
        const result = await response.json();
        if (!result) {
            alert('Invalid response from the server');
            return;
        }

        if (result.success) {
            alert('Action completed successfully');
            location.reload();
        } 
        else {
            alert(result.message || 'Failed to complete action');
        }

    } 
    else {
        alert('An error occurred. Try again later.');
        console.error('Server error:', response.status, response.statusText);
    }

}