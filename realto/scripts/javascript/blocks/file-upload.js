const fileUploadElements = document.querySelectorAll('.file-upload');
var fileUploadNumber = 0;

fileUploadElements.forEach(fileUploadElement => {
    fileUploadNumber++;
    fileUploadElement.setAttribute('id', `file-upload${fileUploadNumber}`);
    const fileUpload = document.getElementById(`file-upload${fileUploadNumber}`);
    const fileUploadButton = fileUpload.querySelector('.file-upload__button');
    const fileInput = fileUpload.querySelector('input[type="file"]');

    fileUploadButton.addEventListener('keydown', (event) => {
        if(event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            fileInput.click();
        }
    })
    fileUploadButton.addEventListener('click', () => {
        fileInput.click();
    })
})