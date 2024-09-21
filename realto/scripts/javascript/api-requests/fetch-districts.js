export async function addDistricts(parentElementSelector, appendingElementClass, appendingElementType, districtLimit, isSelect = null, html = null) {
    const parentElements = document.querySelectorAll(`${parentElementSelector}[data-districts]`);

    const response = await fetch('/realto/scripts/php/api/fetch-districts.php', {
        headers: {
            'ajax-request': 'true'
        }
    });
    const districts = await response.json();

    parentElements.forEach(async (parentElement) => {
        if (parentElement) {
            parentElement.querySelectorAll('option[data-dynamic]').forEach(o => o.remove());
            var iterationsAmount = districts.length;
            if (districtLimit) {
                iterationsAmount = districtLimit;
            }

            for (let i = 0; i < iterationsAmount; i++) {
                const district = districts[i];
                const appendingElement = document.createElement(`${appendingElementType}`);
                appendingElement.setAttribute('data-dynamic', '');
                appendingElement.innerText = district.district_name;
                if (appendingElementClass) {
                    appendingElement.classList.add(`${appendingElementClass}`);
                }
                if (isSelect) {
                    appendingElement.value = district.district_name;
                }
                parentElement.appendChild(appendingElement);
            }
        }
    })
}

export async function footerDistricts() {
    const response = await fetch('/realto/scripts/php/api/fetch-districts.php', {
        headers: {
            'ajax-request': 'true'
        }
    });
    const districts = await response.json();
    const footerList = document.querySelector('.footer__navigation-list[data-districts]');
    districts.forEach(district => {
        const item = document.createElement('li');
        item.classList.add('footer__navigation-item');
        item.innerHTML = `
        <a href="/realto/pages/search-results.php?district=${district.district_name}" class="footer__navigation-link link">${district.district_name}</a>
        `;
        footerList.appendChild(item);
    })
}


