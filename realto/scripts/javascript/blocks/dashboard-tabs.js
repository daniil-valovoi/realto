import { displayProperties } from "/realto/scripts/javascript/blocks/dashboard/properties.js";
import { displayListings } from "/realto/scripts/javascript/blocks/dashboard/listings.js";
import { displayUsers } from "/realto/scripts/javascript/blocks/dashboard/users.js";

document.addEventListener('DOMContentLoaded', () => {
    const dashboard = document.querySelector('.dashboard');
    const dashboardTabsLinks = dashboard.querySelectorAll('.dashboard__tabs-link');
    const cachedDashboardTabs = {};
    const dashboardTabContainer = dashboard.querySelector('.dashboard__main');
    var currentTab = null;

    dashboardTabsLinks.forEach(tabLink => {
        if (!tabLink.classList.contains('open-chat-button')) {
            tabLink.addEventListener('click', async () => {
                dashboardTabsLinks.forEach(tabLinkTemp => {
                    tabLinkTemp.classList.remove('dashboard__tabs-link--selected');
                });
                tabLink.classList.add('dashboard__tabs-link--selected');

                const dashboardTab = tabLink.dataset.dashboardTab;
                if (!(dashboardTab in cachedDashboardTabs)) {
                    const url = `/realto/scripts/php/api/fetch-dashboard-tabs.php?tab=${dashboardTab}`;
                    const response = await fetch(url);
                    if (response.ok) {
                        try {
                            const tabContent = await response.json();
                            if (tabContent !== null && tabContent !== '') {
                                cachedDashboardTabs[dashboardTab] = tabContent;
                                dashboardTabContainer.innerHTML = tabContent.content;

                                if (dashboardTab === 'properties') {
                                    displayProperties();
                                }
                                if(dashboardTab === 'listings') {
                                    displayListings();
                                }
                                if(dashboardTab === 'manage-users') {
                                    displayUsers();
                                }
                            } else {
                                throw new Error();
                            }
                        } catch (error) {
                            dashboardTabContainer.innerHTML = `
                                <span class="h3 margin-auto">Error displaying ${dashboardTab}, empty response. Try again or contact support.</span>
                            `;
                            console.error('Error fetching tab: ' + error);
                        }
                    } else {
                        console.error('Response was not ok: ' + response.status);
                    }
                } else {
                    const tabContent = cachedDashboardTabs[dashboardTab];
                    dashboardTabContainer.innerHTML = tabContent.content;

                    if (dashboardTab === 'properties') {
                        displayProperties();
                    }
                    if(dashboardTab === 'listings') {
                        displayListings();
                    }
                }
            });
        }
    });
});
