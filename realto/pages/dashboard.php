<?php require_once '../blocks/header.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/dashboard/dashboard.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/api/api-functions.php';

restrictAccess();
?>

<style>
    body {
        background-color: var(--color-gray-light);
    }

    .footer {
        background-color: var(--color-white);
    }
</style>
<main>
    <section class="section container">
        <h1 class="visually-hidden">Your profile dashboard</h1>
        <div class="grid grid--6 gap--24 dashboard">
            <div class="dashboard__side grid__column--2 gap--20 column">
                <div class="info-card">
                    <div class="info-card__info">
                        <span class="info-card__subheading bold h4">Logged in as:</span>
                    </div>
                    <div class="info-card__main">
                        <div class="user-info">
                            <img src="<?php echo $pageUserProfilePicturePath?>" alt="User profile picture" class="user-info__profile-picture" data-logged-in-user-profile-picture>
                            <div class="user-info__info">
                                <span class="user-info__name h4" data-logged-in-user-name></span>
                                <div class="circle-separator-list row gap--8">
                                    <span class="user-info__subtext bold">ID: <span data-logged-in-user-id></span></span>
                                    <span class="user-info__subtext bold"><span data-logged-in-user-role></span></span>
                                </div>
                            </div>
                        </div>
                        <span class="info-card__subheading bold" data-logged-in-user-email></span>
                    </div>
                </div>
                <div class="info-card">
                    <span class="visually-hidden">
                        Profile navigation list
                    </span>
                    <div class="info-card__main">
                        <button class="dashboard__tabs-link dashboard__tabs-link--selected link" data-dashboard-tab="profile-and-settings" type="button">
                            <svg class="dashboard__tabs-link-icon dashboard__tabs-link-icon--selected icon" width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.3334 22.3223V19.9889C20.3334 18.7513 19.8417 17.5643 18.9665 16.6891C18.0913 15.8139 16.9044 15.3223 15.6667 15.3223H6.33335C5.09568 15.3223 3.90869 15.8139 3.03352 16.6891C2.15835 17.5643 1.66669 18.7513 1.66669 19.9889V22.3223M15.6667 5.98893C15.6667 8.56626 13.5773 10.6556 11 10.6556C8.42269 10.6556 6.33335 8.56626 6.33335 5.98893C6.33335 3.4116 8.42269 1.32227 11 1.32227C13.5773 1.32227 15.6667 3.4116 15.6667 5.98893Z" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Profile & settings
                        </button>
                        <?php
                        if($_SESSION['role'] === 'user') {
                            echo '          
                        <button class="dashboard__tabs-link link" data-dashboard-tab="listings" type="button">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.33333 1.82227H22.5M7.33333 8.82227H22.5M7.33333 15.8223H22.5M1.5 1.82227H1.51167M1.5 8.82227H1.51167M1.5 15.8223H1.51167" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Your listings
                        </button>
                        <button class="dashboard__tabs-link link" data-dashboard-tab="properties" type="button">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.5 24.4886V12.8219H15.5V24.4886M1.5 9.32194L12 1.15527L22.5 9.32194V22.1553C22.5 22.7741 22.2542 23.3676 21.8166 23.8052C21.379 24.2428 20.7855 24.4886 20.1667 24.4886H3.83333C3.21449 24.4886 2.621 24.2428 2.18342 23.8052C1.74583 23.3676 1.5 22.7741 1.5 22.1553V9.32194Z" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Your properties
                        </button>
                        ';
                        }
                        if($_SESSION['role'] === 'admin') {
                            echo '
                        <button class="dashboard__tabs-link link" data-dashboard-tab="listings" type="button">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 24 17" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.33333 1.82227H22.5M7.33333 8.82227H22.5M7.33333 15.8223H22.5M1.5 1.82227H1.51167M1.5 8.82227H1.51167M1.5 15.8223H1.51167" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Manage listings
                        </button>
                        <button class="dashboard__tabs-link link" data-dashboard-tab="properties" type="button">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.5 24.4886V12.8219H15.5V24.4886M1.5 9.32194L12 1.15527L22.5 9.32194V22.1553C22.5 22.7741 22.2542 23.3676 21.8166 23.8052C21.379 24.2428 20.7855 24.4886 20.1667 24.4886H3.83333C3.21449 24.4886 2.621 24.2428 2.18342 23.8052C1.74583 23.3676 1.5 22.7741 1.5 22.1553V9.32194Z" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Manage properties
                        </button>
                        <button class="dashboard__tabs-link link" data-dashboard-tab="manage-users" type="button">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.8334 22.3232V19.9899C19.8334 18.7522 19.3418 17.5652 18.4666 16.6901C17.5914 15.8149 16.4044 15.3232 15.1667 15.3232H5.83342C4.59574 15.3232 3.40875 15.8149 2.53358 16.6901C1.65841 17.5652 1.16675 18.7522 1.16675 19.9899V22.3232M26.8334 22.3232V19.9899C26.8326 18.9559 26.4885 17.9515 25.855 17.1343C25.2215 16.3171 24.3346 15.7334 23.3334 15.4749M18.6667 1.47491C19.6706 1.73193 20.5603 2.31573 21.1957 3.13427C21.831 3.95282 22.1759 4.95954 22.1759 5.99574C22.1759 7.03194 21.831 8.03867 21.1957 8.85721C20.5603 9.67576 19.6706 10.2596 18.6667 10.5166M15.1667 5.98991C15.1667 8.56724 13.0774 10.6566 10.5001 10.6566C7.92275 10.6566 5.83342 8.56724 5.83342 5.98991C5.83342 3.41258 7.92275 1.32324 10.5001 1.32324C13.0774 1.32324 15.1667 3.41258 15.1667 5.98991Z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Manage users
                        </button>
                        ';
                        }
                        ?>
                        <button class="dashboard__tabs-link link" data-dashboard-tab="liked-listings" type="button">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.3133 3.20078C23.7174 2.60461 23.0099 2.1317 22.2312 1.80904C21.4525 1.48638 20.6179 1.32031 19.775 1.32031C18.9321 1.32031 18.0975 1.48638 17.3187 1.80904C16.54 2.1317 15.8325 2.60461 15.2367 3.20078L14 4.43744L12.7633 3.20078C11.5597 1.99714 9.9272 1.32094 8.225 1.32094C6.52279 1.32094 4.8903 1.99714 3.68666 3.20078C2.48302 4.40442 1.80682 6.0369 1.80682 7.73911C1.80682 9.44131 2.48302 11.0738 3.68666 12.2774L14 22.5908L24.3133 12.2774C24.9095 11.6816 25.3824 10.9741 25.7051 10.1954C26.0277 9.41665 26.1938 8.58201 26.1938 7.73911C26.1938 6.89621 26.0277 6.06156 25.7051 5.28286C25.3824 4.50416 24.9095 3.79666 24.3133 3.20078Z" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Liked listings
                        </button>
                        <button class="dashboard__tabs-link link open-chat-button" type="button" onclick="chats.showModal()" id="chatsOpenButton" data-target="chats">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.5 15.3223C22.5 15.9411 22.2542 16.5346 21.8166 16.9722C21.379 17.4098 20.7855 17.6556 20.1667 17.6556H6.16667L1.5 22.3223V3.6556C1.5 3.03676 1.74583 2.44327 2.18342 2.00568C2.621 1.5681 3.21449 1.32227 3.83333 1.32227H20.1667C20.7855 1.32227 21.379 1.5681 21.8166 2.00568C22.2542 2.44327 22.5 3.03676 22.5 3.6556V15.3223Z" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Chats
                        </button>
                        <!--<button class="dashboard__tabs-link link open-chat-button" type="button" onclick="supportTickets.showModal()" id="supportTicketsOpenButton" data-target="supportTickets">
                            <svg class="dashboard__tabs-link-icon icon" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24.5 14.8223H22.1667C20.878 14.8223 19.8333 15.8669 19.8333 17.1556V19.4889C19.8333 20.7776 20.878 21.8223 22.1667 21.8223C23.4553 21.8223 24.5 20.7776 24.5 19.4889V14.8223ZM24.5 14.8223C24.5 9.02327 19.799 4.32227 14 4.32227C8.20101 4.32227 3.5 9.02327 3.5 14.8223M3.5 14.8223V19.4889C3.5 20.7776 4.54467 21.8223 5.83333 21.8223C7.122 21.8223 8.16667 20.7776 8.16667 19.4889V17.1556C8.16667 15.8669 7.122 14.8223 5.83333 14.8223H3.5Z" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M24.5 17.1553V21.8219C24.5 24.1553 23.7223 25.3219 22.1667 25.3219C20.6112 25.3219 18.6667 25.3219 16.3334 25.3219" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Support tickets
                        </button>-->
                        <div class="separator separator--gray-light"></div>
                        <button class="dashboard__tabs-link link" data-dashboard-tab="logout" type="button">
                            <svg class="icon" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.24352 1.02246H3.91999C3.26475 1.02246 2.63635 1.28059 2.17302 1.74005C1.7097 2.19951 1.4494 2.82268 1.4494 3.47246V18.1725C1.4494 18.8222 1.7097 19.4454 2.17302 19.9049C2.63635 20.3643 3.26475 20.6225 3.91999 20.6225H8.24352M8.55057 10.8225H22.5506M22.5506 10.8225L17.2012 5.22246M22.5506 10.8225L17.2012 16.4225" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Logout
                        </button>
                        <button class="dashboard__tabs-link link" data-dashboard-tab="delete-account" type="button">
                            <svg class="icon" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.5 5.82194H3.83333M3.83333 5.82194H22.5M3.83333 5.82194V22.1553C3.83333 22.7741 4.07917 23.3676 4.51675 23.8052C4.95434 24.2428 5.54783 24.4886 6.16667 24.4886H17.8333C18.4522 24.4886 19.0457 24.2428 19.4832 23.8052C19.9208 23.3676 20.1667 22.7741 20.1667 22.1553V5.82194M7.33333 5.82194V3.48861C7.33333 2.86977 7.57917 2.27628 8.01675 1.83869C8.45434 1.40111 9.04783 1.15527 9.66667 1.15527H14.3333C14.9522 1.15527 15.5457 1.40111 15.9832 1.83869C16.4208 2.27628 16.6667 2.86977 16.6667 3.48861V5.82194" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Delete account
                        </button>
                    </div>
                </div>
            </div>
            <div class="grid__column--4 dashboard__main column gap--20">
                <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/pages/dashboard/profile-and-settings.php'; ?>
            </div>
        </div>
    </section>
    <?php require_once '../blocks/footer.php';
