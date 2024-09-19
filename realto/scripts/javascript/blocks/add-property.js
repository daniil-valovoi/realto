import { initializeSliders } from "/realto/scripts/javascript/blocks/slider.js";
const form = document.getElementById('form');
const typeSelection = form.querySelector('select[name="type"]');
const lotSizeField = form.querySelector('#lot-size-field-container');
const floorField = form.querySelector('#floor-field-container');
const lotSizeInput = form.querySelector('input[name="lot-size"]');
const floorInput = form.querySelector('input[name="floor"]');
const mainImageInput = form.querySelector('input[name="main-image"]');
const imagesField = form.querySelector('input[name="images[]"]');
const imagesContainer = form.querySelector('.listing-form__slider-list');
const previewContainer = form.querySelector('#property-images-preview');

typeSelection.onchange = () => checkPropertyType(typeSelection.value);
checkPropertyType(typeSelection.value);

function checkPropertyType(type) {
    switch(type) {
        case 'house':
            toggleInputs(floorField, floorInput, lotSizeField, lotSizeInput, "number");
            break;

        case 'apartment':
            toggleInputs(lotSizeField, lotSizeInput, floorField, floorInput, "number");
            break;  

        default:
            alert('type selection failed.');
            break;
    }
}

function toggleInputs(hideField, disableInput, showField, enableInput, enableInputType) {
    hideField.classList.add('display-none');
    disableInput.removeAttribute('required');
    disableInput.type = 'hidden';

    showField.classList.remove('display-none');
    enableInput.setAttribute('required', 'true');
    enableInput.type = enableInputType;

}



imagesField.onchange = previewImages;

function previewImages() {
    var files= Array.from(imagesField.files);
    if(files.length > 0) {
        previewContainer.classList.remove('display-none');
        initializeSliders();
        imagesContainer.innerHTML = '';
        files.forEach((img, index) => {
            const item = document.createElement('li');
            item.classList.add('listing-form__slider-slide', 'slider__slide');
            const image = document.createElement('img');
            image.src = URL.createObjectURL(img);
            image.classList.add('listing-form__slider-image')
            item.onclick = function () {
                const allItems = imagesContainer.querySelectorAll('.listing-form__slider-slide');
                allItems.forEach(itemTemp => {
                    itemTemp.classList.remove('listing-form__slider-slide--main-image');
                });
                mainImageInput.value = index;
                item.classList.add('listing-form__slider-slide--main-image');
            }
            item.appendChild(image);
            imagesContainer.appendChild(item);
        });
    }
    else {
        previewContainer.classList.add('display-none');
    }
}

document.addEventListener('DOMContentLoaded', ()=> {
    previewImages();
})
