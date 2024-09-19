async function addStatuses(containerElementSelector, appendingElementClass, appendingElementType) {
    const container = document.querySelector(containerElementSelector);
    if(container) {
        const response = await fetch ('/realto/scripts/php/api/fetch-statuses.php', {
            headers: {
                'ajax-request': 'true'
            }
        });
        const districts = await response.json();
        districts.forEach(status => {
            const appendingElement = document.createElement(`${appendingElementType}`);
            appendingElement.innerText = status.status_name;
            if(appendingElementClass) {
                appendingElement.classList.add(`${appendingElementClass}`);
            }
            container.appendChild(appendingElement);
        });
    }

    /*else {
        alert('fetch statuses failed. container is not found');
    }*/
}