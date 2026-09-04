<?php require_once '../blocks/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/property-page.php';
try {
    $propertyData = (array) displayProperty();
} catch (Exception $exception) {
    returnData($exception->getMessage());
}
$propertyId = $propertyData['property_id'];
$propertyStatus = $propertyData['status_name'];
$propertyTitle = $propertyData['title'];
$propertyDescription = $propertyData['description'];
$bedrooms = $propertyData['bedrooms'];
$bathrooms = $propertyData['bathrooms'];
$footage = $propertyData['footage'];
$propertyType = $propertyData['type_name'];
$lotSize = $propertyData['lot_size'] ?? null;
$floor = $propertyData['floor'] ?? null;
$floors = $propertyData['building_floors'];
$parkingSpots = $propertyData['parking_spots'];
$address = $propertyData['address'];
$district = $propertyData['district_name'];
$zip = $propertyData['zip'];
$userName = $propertyData['first_name'] . ' ' . $propertyData['last_name'];
$userEmail = $propertyData['email'];
$profilePicture = '/realto/images/user-images/profile-pictures/' . $propertyData['profile_picture'];
$offerType = $propertyData['offer_type'];
$forSale = false;
$forRent = false;
$displayedPrice = '';
$petFriendly = ($propertyData['pet_friendly'] = 0) ? 'No' : 'Yes' ?? null;
$securityDeposit = $propertyData['security_deposit'] ?? null;
$minimalRentTime = $propertyData['minimal_rent_time'] ?? null;

switch ($offerType) {
    case 'sale':
        $displayedPrice = '$' . $propertyData['sale_price'];
        $forSale = true;
        break;

    case 'rent':
        $displayedPrice = '$' . $propertyData['rent_price'] . '/mo';
        $forRent = true;
        break;

    case 'both':
        $displayedPrice = '$' . $propertyData['sale_price'] . ' | $' . $propertyData['rent_price'] . '/mo';
        $forRent = true;
        $forSale = true;
        break;

    case 'none':
        break;
}

?>

<head>
    <style>
        body {
            background-color: var(--color-gray-light);
        }

        .footer {
            background-color: var(--color-white);
        }
    </style>
</head>
<main>
    <h1 class="visually-hidden" data-data="property-title"><? echo $propertyTitle ?></h1>
    <section class="section container">
        <div class="property__column--tablet property__column">
            <div class="grid grid--6 property__grid">
                <div class="grid__column--4 property__column--main property__column">
                    <div class="info-card">
                        <div class="info-card__main">
                            <span class="visually-hidden">Property photos gallery</span>
                            <div class="gallery">
                                <div class="gallery__current-image-container">
                                    <img class="gallery__current-image" id="current-image" src="" alt="">
                                    <div class="gallery__buttons-container">
                                        <button class="chevron-button" id="left">
                                            <span class="visually-hidden">Previous image</span>
                                            <svg class="chevron-icon" width="11" height="7" viewBox="0 0 11 7"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 1.91138L5.5 5.91138L9.5 1.91138" stroke="none"
                                                    stroke-width="none" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                        <button class="chevron-button chevron-button--right" id="right">
                                            <span class="visually-hidden">Next image</span>
                                            <svg class="chevron-icon" width="11" height="7" viewBox="0 0 11 7"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 1.91138L5.5 5.91138L9.5 1.91138" stroke="none"
                                                    stroke-width="none" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <ul class="gallery__list">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-card__main">
                            <div class="property__details-row-container property__details-row--space-between">
                                <dl class="property__details-container property__details-container--vertical">
                                    <div class="property__detail-container property__detail-container--price-address">
                                        <?php
                                        if ($forSale || $forRent) {
                                            echo <<<HTML
                                                <dt class="visually-hidden">Price</dt>
                                                <dd class="property__text--h2 h2"><span data-data="price">$displayedPrice</span></dd>
                                            HTML;
                                        } else if (!$forSale && !$forRent) {
                                            echo <<<HTML
                                                <span class="property__text--h4 h4">No listings connected to this property</span>
                                            HTML;
                                        }
                                        ?>
                                    </div>
                                    <div class="property__detail-container">
                                        <dt class="visually-hidden">Address</dt>
                                        <dd class="property__text--p"><span
                                                data-data="address"><?php echo $address . ', ' . $zip ?></span></dd>
                                    </div>
                                </dl>
                                <dl class="property__details-row property__details-quick-details">
                                    <div
                                        class="property__detail-container property__detail-container--align-items-center">
                                        <dd class="property__text--h3 h3"><span
                                                data-data="bedrooms"><?php echo $bedrooms ?></span></dd>
                                        <dt class="property__text--p">Bedrooms</dt>
                                    </div>
                                    <div
                                        class="property__detail-container property__detail-container--align-items-center">
                                        <dd class="property__text--h3 h3"><span
                                                data-data="bathrooms"><?php echo $bathrooms ?></span></dd>
                                        <dt class="property__text--p">Bathrooms</dt>
                                    </div>
                                    <div
                                        class="property__detail-container property__detail-container--align-items-center">
                                        <dd class="property__text--h3 h3"><span
                                                data-data="footage"><?php echo $footage ?></span></dd>
                                        <dt class="property__text--p">Sqft</dt>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <!--<div class="info-card">
                        <div class="info-card__main">
                            <div class="property__details-row property__details-row--space-between">
                                <p class="property__text--text">This property is also available for <span data-data="also-available-for">rent</span>.</p>
                                <a href="" class="link--bold link nowrap">See details
                                    <svg class="link__arrow-icon arrow-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.3335 5.82292H10.6668M10.6668 5.82292L6.00016 1.15625M10.6668 5.82292L6.00016 10.4896" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>-->
                    <div class="info-card">
                        <header class="info-card__info">
                            <h2 class="info-card__subheading h4">Description</h2>
                        </header>
                        <div class="info-card__main">
                            <h3 class="property__title h1" data-data="property-title"><?php echo $propertyTitle ?></h3>
                            <p class="property__description property__description--closed"
                                data-data="property-description"><?php echo $propertyDescription ?></p>
                            <!-- <button class="property__description-toggle-button link--bold link">Read full description
                                <svg class="property__description-toggle-button-icon link__arrow-icon arrow-icon"
                                    width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.3335 5.82292H10.6668M10.6668 5.82292L6.00016 1.15625M10.6668 5.82292L6.00016 10.4896"
                                        stroke="none" stroke-width="none" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button> -->
                        </div>
                    </div>
                    <div class="info-card">
                        <header class="info-card__info">
                            <h2 class="info-card__subheading h4">Details & Features</h2>
                        </header>
                        <div class="info-card__main">
                            <dl class="property__details-list">
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Status</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail"><?php echo $propertyStatus ?></dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Property type</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="property-type">
                                        <?php echo $propertyType ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Footage</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail"><span
                                            data-data="footage"><?php echo $footage ?></span> sqft</dd>
                                </div>
                                <?php
                                if ($lotSize) {
                                    echo <<<HTML
                                    <div class="property__details-list-item">
                                        <div class="property__details-list-detail-title-wrapper">
                                            <dt class="property__details-list-detail-title">Lot size</dt>
                                            <div class="property__detail-separator"></div>
                                        </div>
                                        <dd class="property__details-list-detail"><span data-data="lot-size">$lotSize</span> sqft</dd>
                                    </div>
                                    HTML;
                                } else {
                                    echo <<<HTML
                                    <div class="property__details-list-item">
                                        <div class="property__details-list-detail-title-wrapper">
                                            <dt class="property__details-list-detail-title">Floor</dt>
                                            <div class="property__detail-separator"></div>
                                        </div>
                                        <dd class="property__details-list-detail"><span data-data="lot-size">$floor</span> sqft</dd>
                                    </div>
                                    HTML;
                                }
                                ?>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Bedrooms</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="bedrooms">
                                        <?php echo $bedrooms ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Bathrooms</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="bathrooms">
                                        <?php echo $bathrooms ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Floors</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="floors"><?php echo $floors ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Parking spots</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="parking-spots">
                                        <?php echo $parkingSpots ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Property ID</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="property-id">
                                        <?php echo $propertyId ?>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <?php
                    if ($forRent) {
                        echo <<<HTML
                            <div class="info-card">
                                <header class="info-card__info">
                                    <h2 class="info-card__subheading h4">Rent details</h2>
                                </header>
                                <div class="info-card__main">
                                    <dl class="property__details-list">
                                        <div class="property__details-list-item">
                                            <div class="property__details-list-detail-title-wrapper">
                                                <dt class="property__details-list-detail-title">Pet-friendly</dt>
                                                <div class="property__detail-separator"></div>
                                            </div>
                                            <dd class="property__details-list-detail" data-data="property-type">$petFriendly</dd>
                                        </div>
                                        <div class="property__details-list-item">
                                            <div class="property__details-list-detail-title-wrapper">
                                                <dt class="property__details-list-detail-title">Security deposit</dt>
                                                <div class="property__detail-separator"></div>
                                            </div>
                                            <dd class="property__details-list-detail"><span data-data="footage">$securityDeposit</span></dd>
                                        </div>
                                        <div class="property__details-list-item">
                                            <div class="property__details-list-detail-title-wrapper">
                                                <dt class="property__details-list-detail-title">Minimal rent time</dt>
                                                <div class="property__detail-separator"></div>
                                            </div>
                                            <dd class="property__details-list-detail" data-data="bedrooms">$minimalRentTime days</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        HTML;
                    } ?>
                    <div class="info-card">
                        <header class="info-card__info">
                            <h2 class="info-card__subheading h4">Location</h2>
                        </header>
                        <div class="info-card__main">
                            <dl class="property__details-list">
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">Street</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="address"><?php echo $address ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">District</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="district">
                                        <?php echo $district ?>
                                    </dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">ZIP</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="zip"><?php echo $zip ?></dd>
                                </div>
                                <div class="property__details-list-item">
                                    <div class="property__details-list-detail-title-wrapper">
                                        <dt class="property__details-list-detail-title">City</dt>
                                        <div class="property__detail-separator"></div>
                                    </div>
                                    <dd class="property__details-list-detail" data-data="city">Miami</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="grid__column--2 property__column--side property__column">
                    <div class="info-card">
                        <header class="info-card__info">
                            <h3 class="info-card__subheading h4">Contact information</h3>
                        </header>
                        <div class="info-card__main">
                            <div class="user-info">
                                <img class="user-info__profile-picture" alt="User profile picture"
                                    src="<?php echo $profilePicture ?>" data-data="profile-picture">
                                <div class="user-info__info">
                                    <span class="user-info__name h4"
                                        data-data="user-name"><?php echo $userName ?></span>
                                    <span class="user-info__subtext bold">Owner</span>
                                </div>
                            </div>
                            <div class="user-info__buttons-container">
                                <button class="link restricted-content--not-auth sign-in-button"
                                    onclick="signInPopup.showModal()">Log in/sign up to contact the user</button>
                                <button class="button button--ghost restricted-content--auth"><a
                                        href="mailto:<?php echo $userEmail ?>">Email the user</a></button>
                                <button class="button open-chat-button restricted-content--auth"
                                    onclick="chats.showModal()" data-target="chats">Send a message</button>
                            </div>
                        </div>
                    </div>
                    <!--<div class="info-card">
                        <div class="info-card__main">
                            <button class="button button--ghost">Edit listing</button>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </section>
    <!--
    <section class="section container">
        <header class="section__header">
            <div class="section__header-main">
                <h2 class="section__title">Other listings you might like</h2>
            </div>
        </header>
        <div class="section__body">
            <div class="slider">
                <div class="slider__slides">
                    <ul class="slider__list">
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0001
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0002
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0003
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0004
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0005
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0006
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0007
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg"
                                alt="" class="property-card__image">
                                <div class="property-card__body">
                                    <h3 class="visually-hidden">Property title</h3>
                                    <span class="property-card__price">
                                        <span class="visually-hidden">Price</span>
                                        $250,0008
                                    </span>
                                    <h4 class="visually-hidden">Characteristics</h4>
                                    <div class="property-card__characteristics">
                                        <ul class="property-card__list">
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>2</strong> Beds
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>4</strong> Baths
                                                </span>
                                            </li>
                                            <li class="property-card__item">
                                                <span class="property-card__characteristic">
                                                    <strong>1233</strong> Sqft
                                                </span>
                                            </li>
                                        </ul>
                                        <span class="property-card__status">For sale & rent</span>
                                    </div>
                                    <span class="visually-hidden">Address</span>
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728</address>                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="slider__buttons-container slider__buttons-container--absolute">
                    <button class="slider__button slider__button--left">
                        <span class="visually-hidden">Previous offer</span>
                        <div class="slider__button-icon"></div>
                    </button>
                    <button class="slider__button slider__button--right">
                        <span class="visually-hidden">Next offer</span>
                        <div class="slider__button-icon"></div>
                    </button>
                </div>
            </div>
            <a href="" class="button">See more listings</a>
        </div>
    </section>-->
</main>

<?php require_once '../blocks/footer.php'; ?>