export async function displayUsers() {
    const usersContainer = document.querySelector('.dashboard__item-list');
    usersContainer.innerHTML = '';
    const response = await fetch('/realto/scripts/php/blocks/dashboard/display-users.php', {
        headers: {
            'ajax-request': 'true'
        }
    });
    if (response.ok) {
        try {
            const result = await response.json();
            if (result.empty) {
                throw new Error("No users available");
            }
            const users = result.users;

            users.forEach(user => {

                const registrationDate = user.registration_date.split(' ')[0];

                const userCard = document.createElement('li');
                userCard.dataset.dashboardElementType = 'user';
                userCard.dataset.dashboardElementId = user.user_id;
                userCard.classList.add('dashboard__manage-users-user');
                userCard.innerHTML = `
                <div class="dashboard__manage-users-user-info user-info">
                    <img class="user-info__profile-picture" src="/realto/images/user-images/profile-pictures/${user.profile_picture}" alt="User profile picture">
                    <div class="user-info__info">
                        <span class="user-info__name bold">${user.first_name} ${user.last_name}</span>
                        <span class="user-info__subtext bold small-text">User since <time datetime="${registrationDate}">${registrationDate}</time></span>
                        <ul class="user-info__other-details">
                            <li class="user-info__other-details-item">
                                <span class="user-info__other-details-detail small-text">
                                    ${user.property_count} properties
                                </span>
                            </li>
                            <li class="user-info__other-details-item">
                                <span class="user-info__other-details-detail small-text">
                                    ${user.listing_count} listings
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <ul class="dashboard__manage-users-actions-container">
                    <span class="visually-hidden">Actions</span>
                    <li class="dashboard__manage-users-actions-item">
                        <a href="mailto:${user.email}" class="dashboard__manage-users-action link">Contact user</button>
                    </li>
                    <!--<li class="dashboard__manage-users-actions-item">
                        <button class="dashboard__manage-users-action link">See properties</button>
                    </li>
                    <li class="dashboard__manage-users-actions-item">
                        <button class="dashboard__manage-users-action link">See listings</button>
                    </li>-->
                    <li class="dashboard__manage-users-actions-item">
                        <button class="dashboard__manage-users-action link" data-dashboard-element-action="delete">Delete user</button>
                    </li>
                </ul>

            `;
                usersContainer.appendChild(userCard);
                const userActions = userCard.querySelectorAll('[data-dashboard-element-action]');
                userActions.forEach(action => {
                    action.addEventListener('click', handleAction);
                })
            });
        }
        catch (error) {
            alert(error);
        }
    }
}

async function handleAction(event) {
    event.preventDefault();
    const button = event.currentTarget;
    const parent = button.closest('[data-dashboard-element-type]');

    const targetType = parent.dataset.dashboardElementType;
    const targetId = parent.dataset.dashboardElementId;
    const action = button.dataset.dashboardElementAction;

    if (action === 'delete') {
        if (!confirm(`Do you really want to delete this ${targetType}?`)) {
            return;
        }
    }

    const formData = new FormData();
    formData.append('action', action);
    formData.append('target-type', targetType);
    formData.append('target-id', targetId);

    const response = await fetch('/realto/scripts/php/api/handle-action.php', {
        method: 'POST',
        body: formData,
        headers: {
            'ajax-request': 'true'
        }
    });

    if (response.ok) {
        const result = await response.json();
        if (!result) {
            alert('Invalid response from the server');
            return;
        }

        if (result.success) {
            alert('Action completed successfully');
            location.reload();
        }
        else {
            alert(result.message || 'Failed to complete action');
        }

    }
    else {
        alert('An error occurred. Try again later.');
        console.error('Server error:', response.status, response.statusText);
    }

}