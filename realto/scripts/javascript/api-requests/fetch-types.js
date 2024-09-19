async function addTypes(containerElementSelector, appendingElementClass, appendingElementType) {
    const container = document.querySelector(containerElementSelector);
    if(container) {
        const response = await fetch ('/realto/scripts/php/api/fetch-types.php', {
            headers: {
                'ajax-request': 'true'
            }
        });
        const types = await response.json();
        types.forEach(type => {
            const appendingElement = document.createElement(`${appendingElementType}`);
            appendingElement.innerText = type.type_name;
            if(appendingElementClass) {
                appendingElement.classList.add(`${appendingElementClass}`);
            }
            container.appendChild(appendingElement);
            
        });
    }

    /*else {
        alert('fetch types failed. container is not found');
    }*/
}