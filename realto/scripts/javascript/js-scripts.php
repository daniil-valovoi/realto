<script src="../scripts/javascript/blocks/variant-pills.js"></script>
<script type="module" src="../scripts/javascript/blocks/slider.js"></script>
<script type="module" src="../scripts/javascript/blocks/sign-in-popup.js"></script>
<script src="../scripts/javascript/api-requests/fetch-listings.js"></script>
<script src="../scripts/javascript/api-requests/fetch-types.js"></script>
<script src="../scripts/javascript/api-requests/fetch-statuses.js"></script>
<script src="../scripts/javascript/blocks/chats-popup.js"></script>



<script type="module">
    import {addDistricts, footerDistricts} from '/realto/scripts/javascript/api-requests/fetch-districts.js';
    document.addEventListener('DOMContentLoaded', () => {
        addDistricts('select', null, 'option', null, true);
        footerDistricts();
    });
</script>


<?php
$current_page = basename($_SERVER['PHP_SELF']); 
$path = $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/javascript/page-specific/';
switch ($current_page) {
    case 'add-property.php' :
        require_once $path . 'add-property.php';
    break;

    case 'home.php' :
        require_once $path. 'home.php';
        break;

    case 'property-page.php':
        require_once $path . 'property-page.php';
        break;

    case 'dashboard.php':
        require_once $path . 'dashboard.php';
        break;

    case 'test.php':
        require_once $path . 'test.php';
        break;

    case 'add-listing.php':
        require_once $path . 'add-listing.php';
        break;

    case 'search-results.php':
        require_once $path . 'search-results.php';
        break;
    
    default :
    break;
}