document.addEventListener('DOMContentLoaded', async () => {

    const cachedResults = {};

    const sections = document.querySelectorAll('.section');
    sections.forEach((section, sectionIndex) => {
        section.id = `section${sectionIndex}`;
        const variant_pills = section.querySelector('.variant-pills');
        if(variant_pills) {
            const variant_pills_buttons = variant_pills.querySelectorAll('.variant-pills__variant .variant-pills__button');
            variant_pills_buttons.forEach(variant_pills_button => {
                variant_pills_button.addEventListener('click', async function() {
                    const variant_data = this.dataset.variant;
                    if(!cachedResults[variant_data]) {
                        const response = await fetch(`/realto/scripts/php/api/fetch-listings.php?variant=${variant_data}`, {
                            headers: {
                                'ajax-request': 'true'
                            }
                        });
                        if(response.ok) {
                            var listings = null;
                            try {
                                listings = await response.json();
                                cachedResults[variant_data] = listings;
                            }
                            catch(error) {
                                console.error('Error with JSON, ', error);
                            }
                            displayListings(section, listings);
                        }
                        else {
                            window.alert('fetch listings failed. Response failed/not received');
                        }
                    }
                    else {
                        const listings = cachedResults[variant_data];
                        displayListings(section, listings);
                    }
                });
            });
        };
        
    });
    const firstButton = document.getElementById('variant-pills-first-button');
        if(firstButton) {
            firstButton.click();
        }

    function displayListings(sectionUtil, listingsUtil) {
        const listing_list = sectionUtil.querySelector('.slider__list');
        listing_list.innerHTML = '';
        if(listingsUtil !== null) {
            listingsUtil.forEach(listing => {
                const listingHTML = document.createElement('li');
                listingHTML.classList.add('slider__slide');  

                var propertyStatus = null;
                var listingPrice = null;
                if(listing.is_for_rent && listing.is_for_sale) {
                    propertyStatus = 'For sale & rent';
                    listingPrice = `$${listing.sale_price} | $${listing.rent_price}/mo`
                }
                else if(!listing.is_for_rent) {
                    propertyStatus = 'For sale';
                    listingPrice = `$${listing.sale_price}`;
                }
                else {
                    propertyStatus = 'For rent';
                    listingPrice = `$${listing.rent_price}/mo`;
                }

                var propertyType = null;
                if(listing.type_id == 1) {
                    propertyType = 'House';
                }
                else if(listing.type_id == 2) {
                    propertyType = 'Apartment';
                }

                listingHTML.innerHTML = `
                <div class="slider__card property-card" data-listing-id="${listing.listing_id}">
                    <div class="property-card__image-container">
                        <a href="/realto/pages/property-page.php?id=${listing.property_id}" class="property-card__link">
                            <span class="visually-hidden">Go to listing page</span>
                        </a>
                        <img src="/realto/images/property-images/${listing.image_name}"
                        alt="Listing image" class="property-card__image">
                        <button class="property-card__like-button like-button">
                            <svg class="property-card__like-button-icon like-button__icon icon" viewBox="0 0 22 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.80638 3.20659C3.70651 2.30673 4.92719 1.80122 6.19998 1.80122C7.47276 1.80122 8.69344 2.30673 9.59357 3.20659L11 4.61179L12.4064 3.20659C12.8492 2.74815 13.3788 2.38247 13.9644 2.13091C14.5501 1.87934 15.1799 1.74693 15.8172 1.74139C16.4546 1.73585 17.0866 1.8573 17.6766 2.09865C18.2665 2.34 18.8024 2.69641 19.2531 3.1471C19.7038 3.59778 20.0602 4.13371 20.3015 4.72361C20.5429 5.31352 20.6643 5.94558 20.6588 6.58292C20.6532 7.22026 20.5208 7.85012 20.2693 8.43574C20.0177 9.02136 19.652 9.55101 19.1936 9.99379L11 18.1886L2.80638 9.99379C1.90651 9.09366 1.401 7.87298 1.401 6.60019C1.401 5.32741 1.90651 4.10673 2.80638 3.20659V3.20659Z" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="property-card__type">
                            <span>${propertyType}</span>
                        </div>
                    </div>
                    <div class="property-card__body">
                        <h3 class="visually-hidden">${listing.name}</h3>
                        <span class="property-card__price">
                            <span class="visually-hidden">Price</span>
                            ${listingPrice}
                        </span>
                        <h4 class="visually-hidden">Characteristics</h4>
                        <div class="property-card__characteristics">
                            <ul class="property-card__list">
                                <li class="property-card__item">
                                    <span class="property-card__characteristic">
                                        <strong>${listing.bedrooms}</strong> Beds
                                    </span>
                                </li>
                                <li class="property-card__item">
                                    <span class="property-card__characteristic">
                                        <strong>${listing.bathrooms}</strong> Baths
                                    </span>
                                </li>
                                <li class="property-card__item">
                                    <span class="property-card__characteristic">
                                        <strong>${listing.footage}</strong> Sqft
                                    </span>
                                </li>
                            </ul>
                            <span class="property-card__status">${propertyStatus}</span>
                        </div>
                        <span class="visually-hidden">Address</span>
                        <address class="property-card__address">${listing.address} ${listing.district_name} ${listing.zip}</address>
                    </div>
                </div>
                `;
                listing_list.appendChild(listingHTML);
                const likeBtn = listingHTML.querySelector('.like-button');
                likeBtn.addEventListener('click', () => toggleFavorite(listing.listing_id, likeBtn));
            })
        }
        else {
            listing_list.innerHTML = `
            <span class="h3 margin-auto">Nothing found or an error occured</h3>
            `;
        }
    }

})

async function toggleFavorite(listingId, btn) {
    const formData = new FormData();
    formData.append('listing_id', listingId);
    const response = await fetch('/realto/scripts/php/api/toggle-favorite.php', {
        method: 'POST',
        body: formData,
        headers: { 'ajax-request': 'true' }
    });
    if (response.ok) {
        const result = await response.json();
        if (result.success) {
            btn.classList.toggle('like-button--selected', result.action === 'added');
        }
    }
}
