import {initializeGallery} from '/realto/scripts/javascript/blocks/gallery.js';
document.addEventListener('DOMContentLoaded', async()=> {
    const urlParams = new URLSearchParams(window.location.search);
    const propertyId = urlParams.get('id');
    const response = await fetch(`/realto/scripts/php/blocks/property-page.php?id=${propertyId}`, {
        headers: {
        'ajax-request': 'true'
        }
    });
    if(response.ok) {
        const result = await response.json();
        const mainImage = result.main_image;
        const images = result.images;
        const imagesList = document.querySelector('.gallery__list');
        const mainImageHTML = document.querySelector('.gallery__current-image');
        const path = '/realto/images/property-images/';
        mainImageHTML.src = path + mainImage;
        images.forEach(image => {
            const item = document.createElement('li');
            item.classList.add('gallery__item')
            const imageHTML = document.createElement('img');
            imageHTML.classList.add('gallery__image');
            imageHTML.src = path + image.image_name;
            item.appendChild(imageHTML);
            imagesList.appendChild(item);
        });
        initializeGallery();
    }
    else {
        alert('error with response')
    }
})