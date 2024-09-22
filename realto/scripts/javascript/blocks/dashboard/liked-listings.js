export async function displayLikedListings() {
    const listingsContainer = document.querySelector('.dashboard__item-list');
    listingsContainer.innerHTML = '';
    const response = await fetch('/realto/scripts/php/blocks/dashboard/display-liked-listings.php', {
        headers: { 'ajax-request': 'true' }
    });
    if (response.ok) {
        try {
            const result = await response.json();
            if (result.empty) {
                throw new Error('No liked listings');
            }
            result.listings.forEach(listing => {
                var listingPrice;
                if (listing.is_for_rent && listing.is_for_sale) {
                    listingPrice = `$${listing.sale_price} | $${listing.rent_price}/mo`;
                } else if (!listing.is_for_rent) {
                    listingPrice = `$${listing.sale_price}`;
                } else {
                    listingPrice = `$${listing.rent_price}/mo`;
                }

                const listingCard = document.createElement('li');
                listingCard.classList.add('listing');
                listingCard.dataset.listingId = listing.listing_id;
                listingCard.innerHTML = `
                <div class="listing__image-container">
                    <img src="/realto/images/property-images/${listing.image_name}" alt="Listing main image" class="listing__image">
                    <button class="listing__like-button like-button like-button--selected" data-listing-id="${listing.listing_id}">
                        <svg class="listing__like-button-icon like-button__icon icon" viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80638 3.20659C3.70651 2.30673 4.92719 1.80122 6.19998 1.80122C7.47276 1.80122 8.69344 2.30673 9.59357 3.20659L11 4.61179L12.4064 3.20659C12.8492 2.74815 13.3788 2.38247 13.9644 2.13091C14.5501 1.87934 15.1799 1.74693 15.8172 1.74139C16.4546 1.73585 17.0866 1.8573 17.6766 2.09865C18.2665 2.34 18.8024 2.69641 19.2531 3.1471C19.7038 3.59778 20.0602 4.13371 20.3015 4.72361C20.5429 5.31352 20.6643 5.94558 20.6588 6.58292C20.6532 7.22026 20.5208 7.85012 20.2693 8.43574C20.0177 9.02136 19.652 9.55101 19.1936 9.99379L11 18.1886L2.80638 9.99379C1.90651 9.09366 1.401 7.87298 1.401 6.60019C1.401 5.32741 1.90651 4.10673 2.80638 3.20659V3.20659Z" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="listing__details">
                    <div class="listing__main-details">
                        <div class="listing__top-details">
                            <h3 class="dashboard__listing-title listing__title">${listing.title}</h3>
                            <span class="listing__address">
                                <span class="visually-hidden">Address</span>
                                <span>${listing.address}</span>, <span>${listing.zip}</span>
                            </span>
                        </div>
                        <span class="visually-hidden">Price</span>
                        <span class="listing__price">${listingPrice}</span>
                    </div>
                    <div class="listing__other-details">
                        <div class="column gap--4">
                            <ul class="listing__other-details-list">
                                <li class="listing__other-details-item">
                                    <span class="listing__other-details-detail">ID: <span>${listing.listing_id}</span></span>
                                </li>
                            </ul>
                        </div>
                        <a href="/realto/pages/property-page.php?id=${listing.property_id}" class="listing__link link bold">
                            See details
                            <svg class="listing__link-icon link__icon icon" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.3335 5.82292H10.6668M10.6668 5.82292L6.00016 1.15625M10.6668 5.82292L6.00016 10.4896" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
                `;
                listingsContainer.appendChild(listingCard);

                listingCard.querySelector('.like-button').addEventListener('click', () => toggleFavorite(listing.listing_id, listingCard));
            });
        } catch (error) {
            listingsContainer.innerHTML = `<span class="h3 margin-auto">${error.message}</span>`;
        }
    }
}

async function toggleFavorite(listingId, cardElement) {
    const formData = new FormData();
    formData.append('listing_id', listingId);
    const response = await fetch('/realto/scripts/php/api/toggle-favorite.php', {
        method: 'POST',
        body: formData,
        headers: { 'ajax-request': 'true' }
    });
    if (response.ok) {
        const result = await response.json();
        if (result.success && result.action === 'removed' && cardElement) {
            cardElement.remove();
        }
    }
}
