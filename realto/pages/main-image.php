<?php require_once '../blocks/header.php';?>
<body>
<section class="section container">
<div class="gallery">
    <div class="gallery__current-image-container">
        <img class="gallery__current-image" id="current-image" src="" alt="">
        <div class="gallery__buttons-container">
            <button class="chevron-button" id="left">
                <svg class="chevron-icon" width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.5 1.91138L5.5 5.91138L9.5 1.91138" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="chevron-button chevron-button--right" id="right">
                <svg class="chevron-icon" width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.5 1.91138L5.5 5.91138L9.5 1.91138" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
    <ul class="gallery__list">
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/5.png" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/example.jpg" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/2.jpg" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/3.webp" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/4.jpg" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/1.png" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/6.jpg" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/7.png" alt="">
        </li>
        <li class="gallery__item">
            <img class="gallery__image" src="/realto/images/property-images/8.png" alt="">
        </li>
    </ul>
</div>
</section>
</body>
<script>
    const currentImage = document.getElementById('current-image');
    const leftButton = document.getElementById('left');
    const rightButton = document.getElementById('right');
    var currentIndex = 1;
    const images = document.querySelectorAll('.gallery__image');
    const galleryItems = document.querySelectorAll('.gallery__item');

    leftButton.addEventListener('click', () => {
        if(currentIndex > 1) {
            currentIndex--;
            updateCurrentImage();
        }
    });

    rightButton.addEventListener('click', () => {
        if(currentIndex < images.length) {
            currentIndex++;
            updateCurrentImage();
        }
    })

    function updateCurrentImage() {
        currentImage.style.opacity = '0';
        setTimeout(() => {
        currentImage.src = images[currentIndex -1].src;
        currentImage.style.opacity = '100%';
        }, 200);

        leftButton.classList.toggle('chevron-button--disabled', currentIndex === 1);
        rightButton.classList.toggle('chevron-button--disabled', currentIndex === images.length);

        galleryItems.forEach((item, index) => {
            item.classList.toggle('gallery__item--selected', index === currentIndex -1);
        })
    }

    galleryItems.forEach((item, index) => {
            item.onclick = () => {
                currentIndex = index + 1;
                updateCurrentImage();
            }
    })

    document.addEventListener('DOMContentLoaded', () => {
        updateCurrentImage();
    })
</script>