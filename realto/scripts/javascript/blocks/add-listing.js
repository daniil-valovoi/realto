document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form');
    const propertySelection = form.querySelector('select[name="property-id"]');
    const typeSelection = form.querySelector('select[name="listing-type"]');
    const rentElements = form.querySelectorAll('[data-listing-type="rent"]');
    const saleElements = form.querySelectorAll('[data-listing-type="sale"]');
    const propertyCard = document.querySelector('[data-add-listing-property]');
    var properties = 0;

    fetchProperties();
    checkListingType(typeSelection.value);


    function populateSelection() {
        properties.forEach(property => {
            const option = document.createElement('option');
            option.value = property.property_id;
            option.innerHTML = `ID: ${option.value} - ${property.title}`;
            propertySelection.appendChild(option);
        })
    }



    async function fetchProperties() {
        const response = await fetch('/realto/scripts/php/api/add-listing.php', {
            headers: {
                'ajax-request' : 'true'
            }
        });

        if(response.ok) {
            const result = await response.json();
            if(result.empty == false) {
                properties = result.properties;
                populateSelection();
            }
            else {
                alert('No properties found for this user');
            }
        }
        else {
            alert('Error fetching properties/bad response');
        }
    }

    function displaySelectedProperty(propertyId) {
        const property = properties.find(property => property.property_id == propertyId);
        propertyCard.querySelectorAll('[data-add-listing-property-title').forEach(element => {
            element.innerHTML = property.title;
        });
        propertyCard.querySelectorAll('[data-add-listing-property-address').forEach(element => {
            element.innerHTML = property.address;
        });
        propertyCard.querySelectorAll('[data-add-listing-property-zip').forEach(element => {
            element.innerHTML = property.zip;
        });
        propertyCard.querySelectorAll('[data-add-listing-property-id').forEach(element => {
            element.innerHTML = property.property_id;
        });
        propertyCard.querySelectorAll('[data-add-listing-property-link').forEach(element => {
            element.setAttribute('href', `/realto/pages/property-page?id=${property.property_id}`);
        });
        propertyCard.querySelectorAll('[data-add-listing-property-image]').forEach(element => {
            element.setAttribute('src', `/realto/images/property-images/${property.main_image}`);
        });
    }

    typeSelection.onchange =  ()=> {
        checkListingType(typeSelection.value);
    }

    propertySelection.onchange = () => {
        displaySelectedProperty(propertySelection.value);
    }

    function checkListingType(type) {
        switch (type) {
            case 'sale':
                toggleInputs(rentElements, saleElements);
                break;

            case 'rent':
                toggleInputs(saleElements, rentElements);
                break;

            default:
                alert('type selection failed.');
                break;
        }
    }

    function toggleInputs(hideElements, showElements) {
        hideElements.forEach(element => {
            element.querySelector('input, select, textarea').removeAttribute('required');
            element.setAttribute('hidden', '');
        });

        showElements.forEach(element => {
            element.querySelector('input, select, textarea').setAttribute('required', '');
            element.removeAttribute('hidden');
        })

    }

    
})