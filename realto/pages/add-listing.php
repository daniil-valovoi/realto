<?php
require_once '../blocks/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/realto/scripts/php/blocks/add-listing.php';
try{
displayFirstProperty($_SESSION['user_id']);
}
catch(Exception $exception) {
    
}
?>

<head>
    <style>
        .footer {
            background-color: var(--color-white);
        }
    </style>
</head>

<body class="body--gray-bg">
    <main>
        <section class="section">
            <form class="listing-form" action="/realto/scripts/php/blocks/add-listing.php" id="form" method="post">
                <div class="info-card">
                    <div class="info-card__info">
                        <h1>List your property.</h1>
                        <p>List your property for rent or sale. Connect an existing property and fill listing-specific data, like price, rent duration, and other.</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card__info">
                        <h2>Select property</h2>
                        <p>Only active properties are shown. To activate inactive property, go to Account - Your properties - Activate property.</p>
                    </div>
                    <div class="info-card__main">
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label class="listing-form__field-label field__label">Select property</label>
                            </div>
                            <select class="listing-form__field-input listing-form__field-input--long field__input field__input--select" name="property-id" required>
                            </select>
                        </div>
                        <div class="listing" data-add-listing-property>
                            <span class="visually-hidden">Selected property details</span>
                            <div class="listing__image-container">
                                <img src="<?php echo '/realto/images/property-images/' . $firstProperty['main_image']?>" alt="Listing main image" class="listing__image" data-add-listing-property-image>
                            </div>
                            <div class="listing__details">
                                <div class="listing__main-details">
                                    <div class="listing__top-details">
                                        <h3 class="dashboard__listing-title listing__title" data-add-listing-property-title><?php echo $firstProperty['title']?></h3>
                                        <span class="listing__address">
                                            <span class="visually-hidden">Address</span>
                                            <span data-add-listing-property-address><?php echo $firstProperty['address']?></span>,
                                            <span data-add-listing-property-zip><?php echo $firstProperty['zip']?></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="listing__other-details">
                                    <ul class="listing__other-details-list">
                                        <li class="listing__other-details-item">
                                            <span class="listing__other-details-detail">
                                                ID:
                                                <span data-add-listing-property-id><?php echo $firstProperty['property_id']?></span>
                                            </span>
                                        </li>
                                        <li class="listing__other-details-item">
                                            <span class="listing__other-details-detail">
                                                <span>Active</span>
                                            </span>
                                        </li>
                                    </ul>
                                    <a href="<?php echo '/realto/pages/property-page.php?id=' . $firstProperty['property_id']?>" class="listing__link link bold" data-add-listing-property-link>
                                        See details
                                        <svg class="listing__link-icon link__icon icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.3335 5.82292H10.6668M10.6668 5.82292L6.00016 1.15625M10.6668 5.82292L6.00016 10.4896" stroke="none" stroke-width="none" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="info-card">
                    <div class="info-card__info">
                        <h2>Listing information</h2>
                    </div>
                    <div class="info-card__main">
                        <div class="listing-form__fields-row">
                            <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="type" class="listing-form__field-label field__label">Select listing type</label>
                                </div>
                                <select class="listing-form__field-input field__input field__input--select" name="listing-type" id="add-listing-listing-type" required>
                                    <option value="rent">For rent</option>
                                    <option value="sale">For sale</option>
                                </select>
                            </div>
                        </div>
                        <div class="listing-form__field field" data-listing-type="rent">
                            <div class="listing-form__field-info">
                                <label for="type" class="listing-form__field-label field__label">Pet-friendly?</label>
                            </div>
                            <select class="listing-form__field-input field__input field__input--select" name="pet-friendly" required>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="listing-form__fields-row" data-listing-type="rent">
                            <div class="listing-form__field field" data-listing-type="rent">
                                <div class="listing-form__field-info">
                                    <label for="footage" class="listing-form__field-label field__label">Price/mo</label>
                                </div>
                                <input type="number" class="listing-form__field-input field__input" name="rent-price" min="100" max="999999"
                                    placeholder="2500" required>
                            </div>
                            <div class="listing-form__field field" data-listing-type="rent">
                                <div class="listing-form__field-info">
                                    <label for="footage" class="listing-form__field-label field__label">Security deposit</label>
                                </div>
                                <input type="number" class="listing-form__field-input field__input" name="security-deposit" min="100" max="999999999"
                                    placeholder="5000" required>
                            </div>
                        </div>
                        <div class="listing-form__field field" data-listing-type="rent">
                            <div class="listing-form__field-info">
                                <label for="type" class="listing-form__field-label field__label">Minimal rent time(days)</label>
                            </div>
                            <input type="number" class="listing-form__field-input field__input" name="minimal-rent-time" required placeholder="15" min="1" max="1000">
                        </div>
                        <div class="listing-form__field field" data-listing-type="sale">
                            <div class="listing-form__field-info">
                                <label for="footage" class="listing-form__field-label field__label">Price</label>
                            </div>
                            <input type="number" class="listing-form__field-input field__input" name="sale-price" min="100" max="9999999"
                                placeholder="250000" required>
                        </div>
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="status" class="listing-form__field-label field__label">Select status</label>
                                <p>If set to inactive, listing will not be shown to users.</p>
                            </div>
                            <select class="listing-form__field-input field__input field__input--select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php print_r($_SESSION); ?>
                <div class="info-card">
                    <div class="info-card__info">
                        <h2>Last steps</h2>
                        Review all details and make sure everything is correct. After submission, your property will be reviewed by moderator, and you will be able to list it for sale or rent.
                    </div>
                    <div class="info-card__main">
                        <div class="listing-form__contact-info">
                            <h3 class="h4">Contact information</h3>
                            <ul class="listing-form__contact-info-list">
                                <li class="listing-form__contact-info-item">
                                    <span><b>Name: </b><?php echo $_SESSION["first_name"] . ' ' . $_SESSION["last_name"] ?></span>
                                </li>
                                <!--<li class="listing-form__contact-info-item">
                                    <span><b>Phone: </b>+1-232-33-443</span>
                                </li>-->
                                <li class="listing-form__contact-info-item">
                                    <span><b>Email: </b><?php echo $_SESSION["email"] ?></span>
                                </li>
                            </ul>
                        </div>
                        <button type="submit" class="listing-form__submit-button button">Submit property</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <?php require_once '../blocks/footer.php'; ?>