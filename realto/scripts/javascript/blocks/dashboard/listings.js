// offer_type_id: 1 = for rent, 2 = for sale
const OFFER_TYPE = { 'All': null, 'For sale': 2, 'For rent': 1 };

function renderListings(listings, offerTypeId) {
    const listingsContainer = document.querySelector('.dashboard__item-list');
    listingsContainer.innerHTML = '';
    const filtered = offerTypeId === null ? listings : listings.filter(l => l.offer_type_id === offerTypeId);

    if (!filtered.length) {
        listingsContainer.innerHTML = '<li>No listings found.</li>';
        return;
    }

    filtered.forEach(listing => {
        const buttonAction = listing.listing_status === 1 ? 'deactivate' : 'activate';
        const buttonText   = listing.listing_status === 1 ? 'Deactivate' : 'Activate';

        const listingCard = document.createElement('li');
        listingCard.dataset.dashboardElementType = 'listing';
        listingCard.dataset.dashboardElementId = listing.listing_id;
        listingCard.classList.add('listing');
        listingCard.innerHTML = `
                <div class="listing__image-container">
                    <img src="/realto/images/property-images/${listing.image_name}" alt="Listing main image" class="listing__image">
                </div>
                <div class="listing__details">
                    <div class="listing__main-details">
                        <div class="listing__top-details">
                            <h3 class="dashboard__listing-title listing__title" >${listing.title}</h3>
                            <span>Property ID: ${listing.property_id}</span>
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
                                    ID: ${listing.listing_id}
                                </span>
                            </li>
                            <li class="listing__other-details-item">
                                <span class="listing__other-details-detail">
                                   User ID: ${listing.user_id}
                                </span>
                            </li>
                            <li class="listing__other-details-item">
                                <span class="listing__other-details-detail">
                                    ${listing.status_name}
                                </span>
                            </li>
                        </ul>
                        <a href="/realto/pages/property-page.php?id=${listing.property_id}" class="listing__link link bold">
                            See details
                            <svg class="listing__link-icon link__icon icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.3335 5.82292H10.6668M10.6668 5.82292L6.00016 1.15625M10.6668 5.82292L6.00016 10.4896" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            `;
        listingsContainer.appendChild(listingCard);
        listingCard.querySelectorAll('[data-dashboard-element-action]').forEach(action => {
            action.addEventListener('click', handleAction);
        });
    });
}

export async function displayListings() {
    const listingsContainer = document.querySelector('.dashboard__item-list');
    listingsContainer.innerHTML = '';
    const response = await fetch('/realto/scripts/php/blocks/dashboard/display-listings.php', {
        headers: {
            'ajax-request': 'true'
        }
    });
    if (response.ok) {
        try {
            const result = await response.json();
            if (result.empty) {
                throw new Error("No listings available");
            }
            const listings = result.listings;

            renderListings(listings, null);

            document.querySelectorAll('.tab-selection__button').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.tab-selection__button').forEach(b => b.classList.remove('tab-selection__button--selected'));
                    btn.classList.add('tab-selection__button--selected');
                    renderListings(listings, OFFER_TYPE[btn.textContent.trim()] ?? null);
                });
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

    if (action === 'delete') {
        if (!confirm(`Do you really want to delete this ${targetType}?`)) {
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