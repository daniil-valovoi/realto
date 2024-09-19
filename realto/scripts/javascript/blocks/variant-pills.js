var buttons = document.querySelectorAll('.variant-pills__button');
buttons.forEach(button => {
    button.addEventListener('click', () => {
        buttons.forEach(btn => {
            btn.classList.remove('variant-pills__button--selected');
        });
        button.classList.add('variant-pills__button--selected');
    });
});