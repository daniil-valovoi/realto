export function initializeGallery() {
    const currentImage = document.getElementById('current-image');
    const leftButton = document.getElementById('left');
    const rightButton = document.getElementById('right');
    var currentIndex = 1;
    const galleryItems = document.querySelectorAll('.gallery__item');
    const images = document.querySelectorAll('.gallery__image');


    leftButton.addEventListener('click', () => {
        if (currentIndex > 1) {
            currentIndex--;
            updateCurrentImage();
        }
    });

    rightButton.addEventListener('click', () => {
        if (currentIndex < images.length) {
            currentIndex++;
            updateCurrentImage();
        }
    })

    function updateCurrentImage() {
        currentImage.style.opacity = '0';
        setTimeout(() => {
            currentImage.src = images[currentIndex - 1].src;
            currentImage.style.opacity = '100%';
        }, 200);

        leftButton.classList.toggle('chevron-button--disabled', currentIndex === 1);
        rightButton.classList.toggle('chevron-button--disabled', currentIndex === images.length);

        galleryItems.forEach((item, index) => {
            item.classList.toggle('gallery__item--selected', index === currentIndex - 1);
        })
    }

    galleryItems.forEach((item, index) => {
        item.onclick = () => {
            currentIndex = index + 1;
            updateCurrentImage();
        }
    })

    updateCurrentImage();
}
