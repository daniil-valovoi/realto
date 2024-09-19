export function initializeSliders() {
    
        var sliders = document.querySelectorAll('.slider');
        var sliderNumber = 0;

        sliders.forEach(slider => {
            sliderNumber++;
            slider.setAttribute("id", `slider${sliderNumber}`);
            const sliderHTML = document.querySelector(`#slider${sliderNumber}`);
            const buttons = sliderHTML.querySelectorAll('.slider__button');
            const leftButton = sliderHTML.querySelector('.slider__button--left');    
            const rightButton = sliderHTML.querySelector('.slider__button--right');
            const sliderList = sliderHTML.querySelector('.slider__list');
        
            function updateButtonsStates () {
                buttons.forEach(button => {
                    button.classList.remove('slider__button--disabled');
                });
        
                if(sliderList.scrollLeft === 0){
                    leftButton.classList.add('slider__button--disabled');
                }
        
                else if(sliderList.scrollWidth - sliderList.scrollLeft - sliderList.clientWidth <= 0){
                    rightButton.classList.add('slider__button--disabled');
                }
            };

            const slide = sliderList.querySelector('.slider__slide');
            var sliderListGap = parseInt(getComputedStyle(sliderList).gap) || 0;
            var cardWidth = slide.offsetWidth;
        
            leftButton.addEventListener('click', () => {
                sliderList.scrollLeft -= (cardWidth + sliderListGap);
            })
        
            rightButton.addEventListener('click', () => {
                sliderList.scrollLeft += cardWidth + sliderListGap;
            })

            sliderList.addEventListener('scroll', updateButtonsStates);
            updateButtonsStates();
        
        });
};

