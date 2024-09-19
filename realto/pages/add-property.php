<?php
require_once '../blocks/header.php';
?>
<!DOCTYPE html>
<html lang="en">
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
            <form enctype="multipart/form-data" class="listing-form" action="../scripts/php/blocks/add-property-exp.php" id="form" method="post">
                <div class="info-card">
                    <div class="info-card__info">
                        <h1>Add your property first.</h1>
                        <p>Before listing your property for sale or rent, it has to be added. This will make it easier to further create listings by connecting them to the property. You can have separate title and description for 'for sale' and 'for rent' listings. You can add them right now and choose to use them in your listings, or leave blank.</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card__info">
                        <h2>General information</h2>
                    </div>
                    <div class="info-card__main">
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="title" class="listing-form__field-label field__label">Property title. Max 75 characters</label>
                            </div>
                            <input type="text" class="listing-form__field-input field__input listing-form__field-input--full-width" 
                            name="title" maxlength="75"
                            placeholder="Spacious apartment with lake view">
                        </div>
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="description" class="listing-form__field-label field__label">Property description. Max 5000 characters</label>
                            </div>
                            <textarea class="listing-form__field-input field__input field__input--textarea listing-form__field-input--full-width" 
                            name="description" maxlength="5000"
                            placeholder="include details like 'comfortable beds', 'big driveway', or 'friendly neighborhood'. Tell what makes your property special."></textarea>
                        </div>
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="type" class="listing-form__field-label field__label">Select property type</label>
                            </div>
                            <select class="listing-form__field-input field__input field__input--select" name="type" required>
                                <option value="house">House</option>
                                <option value="apartment">Apartment</option>
                            </select>
                        </div>
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="footage" class="listing-form__field-label field__label">Footage in sq ft</label>
                            </div>
                            <input type="number" class="listing-form__field-input field__input" name="footage" max="99999"
                            placeholder="1000" required>
                        </div>
                        <div class="listing-form__fields-row">
                            <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="bedrooms" class="listing-form__field-label field__label">Bedrooms</label>
                                </div>
                                <input type="number" class="listing-form__field-input field__input" name="bedrooms"
                                placeholder="4" max="20" required>
                            </div>
                            <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="bathrooms" class="listing-form__field-label field__label">Bathrooms</label>
                                </div>
                                <input type="number" class="listing-form__field-input field__input" name="bathrooms"
                                placeholder="2" max="20" required>
                            </div>
                        </div>
                        <div class="listing-form__fields-row">
                            <div class="listing-form__field field display-none" id="floor-field-container"> <!--hidden when type is house-->
                                <div class="listing-form__field-info">
                                    <label for="floor" class="listing-form__field-label field__label">Floor</label>
                                </div>
                                <input type="text" class="listing-form__field-input field__input" name="floor"
                                placeholder="8" max="200" required>
                            </div>
                            <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="building-floors" class="listing-form__field-label field__label">House floors</label> 
                                </div>
                                <input type="number" class="listing-form__field-input field__input" name="building-floors" id="building-floors"
                                placeholder="2" max="200" required>
                            </div>
                            <div class="listing-form__field field" id="lot-size-field-container"> <!--hidden when type is apartment-->
                                <div class="listing-form__field-info">
                                    <label for="lot-size" class="listing-form__field-label field__label">Lot size in sq ft</label>
                                </div>
                                <input type="text" class="listing-form__field-input field__input" name="lot-size"
                                placeholder="6000" max="99999" required>
                            </div>
                            
                        </div>
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="parking-spots" class="listing-form__field-label field__label">Parking spots</label>
                            </div>
                            <input type="number" class="listing-form__field-input field__input" name="parking-spots"
                            placeholder="2" max="20" required>
                        </div>
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="status" class="listing-form__field-label field__label">Select status</label>
                                <p>If set to inactive, no listings can be connected to this property.</p>
                            </div>
                            <select class="listing-form__field-input field__input field__input--select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card__info">
                        <h2>Address & Location</h2>
                    </div>
                    <div class="info-card__main">
                        <div class="listing-form__fields-row">
                            <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="district" class="listing-form__field-label field__label">Select district</label>
                                </div>
                                <select class="listing-form__field-input field__input field__input--select" name="district" id="district" required data-districts>
                                </select>
                            </div>
                            <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="zip" class="listing-form__field-label field__label">ZIP code</label>
                                </div>
                                <input type="number" class="listing-form__field-input field__input" name="zip"
                                placeholder="32176" min="33000" max="39999" minlength="5" maxlength="5" required>
                            </div>
                        </div>
                        <div class="listing-form__field field">
                                <div class="listing-form__field-info">
                                    <label for="address" class="listing-form__field-label field__label">Address</label>
                                    <p>Only include street and building number</p>
                                </div>
                                <input type="text" class="listing-form__field-input listing-form__field-input--full-width field__input" name="address"
                                placeholder="4848 Pointe Lane" maxlength="150" required>
                        </div>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card__info">
                        <h2>Property photos</h2>
                    </div>
                    <div class="info-card__main">
                        <!--image preview-->
                        <div class="listing-form__field field display-none" id="property-images-preview">
                            <div class="listing-form__field-info">
                                <label for="" class="listing-form__field-label field__label">Preview</label>
                                <p>Click on the image to mark as main</p>
                            </div>
                            <div class="listing-form__slider slider">
                                <div class="listing-form__slider-slides slider__slides">
                                    <ul class="listing-form__slider-list slider__list" id="images-container">
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                        <li class="listing-form__slider-slide slider__slide">
                                            <img src="/realto/images/property-images/example.jpg" alt=""
                                            class="listing-form__slider-image">
                                        </li>
                                    </ul>
                                </div>
                                <div class="listing-form__slider-buttons-container slider__buttons-container">
                                    <button type="button" class="listing-form__slider-button listing-form__slider-button--left slider__button slider__button--left">
                                        <span class="visually-hidden">Previous image</span>
                                        <div class="listing-form__slider-button-icon slider__button-icon"></div>
                                    </button>
                                    <button type="button" class="listing-form__slider-button listing-form__slider-button--right slider__button slider__button--right">
                                        <span class="visually-hidden">Next image</span>
                                        <div class="listing-form__slider-button-icon slider__button-icon"></div>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="main-image" id="main-image">
                        </div>
                        <!--upload-->
                        <div class="listing-form__field field">
                            <div class="listing-form__field-info">
                                <label for="images[]" class="listing-form__field-label field__label">Upload photos</label>
                                <p>Select all images at once</p>
                            </div>
                            <div class="file-upload file-upload--gray-bg">
                                <div class="file-upload__inner">
                                    <span class="file-upload__text">
                                        Select files from your device
                                    </span>
                                    <label for="images[]" class="file-upload__button" tabindex="0">Click here 
                                        <div class="file-upload__button-icon"></div>
                                        <input name="images[]" type="file" accept="image/jpeg, image/png, image/webp" class="visually-hidden" multiple tabindex="-1" required>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <span><b>Name: </b>Alex Tilbury</span>
                                </li>
                                <li class="listing-form__contact-info-item">
                                    <span><b>Phone: </b>+1-232-33-443</span>
                                </li>
                                <li class="listing-form__contact-info-item">
                                    <span><b>Email: </b>alextilbury1@gmail.com</span>
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