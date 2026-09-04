<?php
require_once '../blocks/header.php';
?>

<main>
    <!--hero-->
    <section class="hero section">
        <div class="container">
            <div class="section__body">
                <div class="hero__main">
                    <div class="hero__content">
                        <h1 class="hero__title">Miami’s best property. Welcome to Realto.</h1>
                        <div class="hero__description">
                            <p>Discover premium real estate in Miami's finest neighborhoods. Browse verified listings,
                                connect with owners, and find your next home today.</p>
                        </div>
                    </div>
                    <form class="hero__search-form search-form" action="/realto/pages/search-results.php" method="get">
                        <select name="property-type" id="hero__property-type" class="field__input">
                            <option value="houses">Houses</option>
                            <option value="apartments">Apartments</option>
                        </select>
                        <select name="offer-type" id="hero__listing-type" class="field__input">
                            <option value="for-sale">For Sale</option>
                            <option value="for-rent">For Rent</option>
                        </select>
                        <select name="district" id="hero__district" class="field__input" data-districts>
                            <option value="all">All districts</option>
                        </select>
                        <button class="hero__search-form-button search-form__button button">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--categories-->
    <section class="section container">
        <header class="section__header">
            <div class="section__header-main">
                <h2 class="section__title">Browse by categories</h2>
                <div class="section__description">
                    <p>Find the right offer from these hand-picked listings</p>
                </div>
            </div>
            <ul class="variant-pills">
                <li class="variant-pills__variant">
                    <button class="variant-pills__button" data-variant="family-houses"
                        id="variant-pills-first-button">Family houses</button>
                </li>
                <li class="variant-pills__variant">
                    <button class="variant-pills__button" data-variant="short-term-rentals">Short term rentals</button>
                </li>
                <li class="variant-pills__variant">
                    <button class="variant-pills__button" data-variant="affordable-apartments">Affordable
                        apartments</button>
                </li>
                <!-- <li class="variant-pills__variant">
                    <button class="variant-pills__button" data-variant="new-to-realto">New to Realto</button>
                </li> -->
                <li class="variant-pills__variant">
                    <button class="variant-pills__button" data-variant="luxury-rentals">Luxury rentals</button>
                </li>
            </ul>
        </header>
        <div class="section__body">
            <div class="slider">
                <div class="slider__slides">
                    <ul class="slider__list">
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slider__card property-card">
                                <img src="../images/property-images/example.jpg" alt="" class="property-card__image">
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
                                    <address class="property-card__address">Kimberly St. 1234 Golden Beach 00-728
                                    </address>
                                </div>
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
            <a href="#" class="button">See more listings</a>
        </div>
    </section>

    <!--Recently popular-->
    <!--<section class="section container">
        <header class="section__header">
            <div class="section__header-main">
                <h2 class="section__title">Browse by categories</h2>
                <div class="section__description">
                    <p>Find the right offer from these hand-picked listings</p>
                </div>
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
            <a href="#" class="button">See more listings</a>
        </div>
    </section>-->

    <!--Locations-->
    <section class="section container">
        <header class="section__header">
            <div class="section__header-main">
                <h2 class="section__title">Top Miami locations</h2>
                <div class="section__description">
                    <p>Find your dream property here</p>
                </div>
            </div>
        </header>
        <div class="section__body">
            <div class="locations">
                <div class="locations__item locations__item--1">
                    <img src="../images/website-images/1.jpg" alt="" class="locations__image">
                    <a class="locations__title" href="/realto/pages/search-results.php?district=Coconut Grove">Coconut
                        Grove</a>
                </div>
                <div class="locations__item locations__item--2">
                    <img src="../images/website-images/3.jpg" alt="" class="locations__image">
                    <a class="locations__title" href="/realto/pages/search-results.php?district=Coral Gables">Coral
                        Gables</a>
                </div>
                <div class="locations__item locations__item--3">
                    <img src="../images/website-images/2.jpg" alt="" class="locations__image">
                    <a class="locations__title" href="/realto/pages/search-results.php?district=Wynwood">Wynwood</a>
                </div>
                <div class="locations__item locations__item--4">
                    <img src="../images/website-images/4.jpg" alt="" class="locations__image">
                    <a class="locations__title" href="/realto/pages/search-results.php?district=Pinecrest">Pinecrest</a>
                </div>
                <div class="locations__item locations__item--5">
                    <img src="../images/website-images/5.jpg" alt="" class="locations__image">
                    <a class="locations__title" href="/realto/pages/search-results.php?district=Brickell">Brickell</a>
                </div>
                <div class="locations__item locations__item--6">
                    <img src="../images/website-images/6.jpg" alt="" class="locations__image">
                    <a class="locations__title"
                        href="/realto/pages/search-results.php?district=Westchester">Westchester</a>
                </div>
            </div>
        </div>
    </section>
</main>


<?php
require_once '../blocks/footer.php';
?>