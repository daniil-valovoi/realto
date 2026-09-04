<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script type="module">
        import { displayLoggedInUserData } from "/realto/scripts/javascript/functions/user-data.js";
        document.addEventListener('DOMContentLoaded', displayLoggedInUserData);
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realto - Miami real estate platform</title>
    <link rel="stylesheet" href="/realto/styles/styles.css">
</head>

<body>
    <header class="header">
        <div class="header__inner container">
            <a href="/realto/pages/home.php" class="header__logo logo">
                <img src="/realto/images/website-images/icons/logo.svg" alt="Realto" loading="lazy">
            </a>
            <nav class="header__menu visible-desktop">
                <ul class="header__menu-list">
                    <li class="header__menu-item">
                        <a href="/realto/pages/search-results.php?offer-type=buy&property-type=houses"
                            class="header__menu-link">Buy</a>
                    </li>
                    <li class="header__menu-item">
                        <a href="/realto/pages/add-listing.php" class="header__menu-link">Sell</a>
                    </li>
                    <li class="header__menu-item header__menu-item--dropdown">
                        <a href="#" class="header__menu-link">Rent
                            <svg class="header__menu-link--dropdown-icon chevron-icon" width="11" height="7"
                                viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.5 1.91138L5.5 5.91138L9.5 1.91138" stroke="none" stroke-width="none"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <ul class="header__menu-list header__menu-list--dropdown">
                            <li class="header__menu-item">
                                <a href="/realto/pages/search-results.php?property-type=houses&offer-type=for-rent&district=all"
                                    class="header__menu-link">Find a rental</a>
                            </li>
                            <li class="header__menu-item">
                                <a href="/realto/pages/add-listing.php" class="header__menu-link">Rent your property</a>
                            </li>
                        </ul>
                    </li>
                    <li class="header__menu-item">
                        <a href="/realto/pages/search-results.php" class="header__menu-link">Latest listings</a>
                    </li>
                    <!-- <li class="header__menu-item">
                        <a href="#" class="header__menu-link">Support</a>
                    </li> -->
                </ul>
            </nav>
            <nav class="header__menu">
                <ul class="header__menu-list">
                    <li class="header__menu-item">
                        <button class="header__menu-link link restricted-content--not-auth sign-in-button"
                            onclick="signInPopup.showModal()">Sign in</button>
                        <a href="dashboard.php" class="header__menu-link link restricted-content--auth">Your account</a>
                    </li>
                    <li class="header__menu-item visible-desktop">
                        <a href="/realto/pages/add-property.php" class="header__button button">List your property</a>
                    </li>
                    <li class="header__menu-item  hidden-desktop">
                        <button class="header__burger-button burger-button" type="button"
                            onclick="mobileOverlay.showModal()">
                            <span class="visually-hidden">Open navigation menu</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </header>