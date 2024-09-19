        <footer class="footer">
            <div class="footer__inner container section">
                <div class="footer__main">
                    <div class="footer__cell">
                        <a href="/realto/pages/home.php" class="footer__logo logo">
                            <img src="/realto/images/website-images/icons/logo.svg" alt="Realto" loading="lazy">
                        </a>
                        <div class="footer__text">
                            <p>Realto is a real estate listing platform serving Miami, FL. From small apartments for daily rent to luxury villas for sale, find it here. </p>
                        </div>
                    </div>
                    <div class="footer__cell">
                        <h4 class="footer__navigation-title">Quick links</h4>
                        <nav class="footer__navigation">
                            <ul class="footer__navigation-list">
                                <li class="footer__navigation-item">
                                    <a href="/realto/pages/search-results.php?offer-type=buy&property-type=houses" class="footer__navigation-link link">Houses for sale</a>
                                </li>
                                <li class="footer__navigation-item">
                                    <a href="/realto/pages/search-results.php?offer-type=rent&property-type=apartments" class="footer__navigation-link link">Apartments for rent</a>
                                </li>
                                <li class="footer__navigation-item">
                                    <a href="/realto/pages/search-results.php?offer-type=rent&property-type=houses" class="footer__navigation-link link">Houses for rent</a>
                                </li>
                                <li class="footer__navigation-item">
                                    <a href="/realto/pages/search-results.php?offer-type=buy&property-type=apartments" class="footer__navigation-link link">Apartments for sale</a>
                                </li>
                                <li class="footer__navigation-item">
                                    <a href="/realto/pages/search-results.php?property-type=all" class="footer__navigation-link link">Search all</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="footer__cell">
                        <h4 class="footer__navigation-title">Search by district</h4>
                        <nav class="footer__navigation">
                            <ul class="footer__navigation-list" data-districts>
                                
                            </ul>
                        </nav>
                    </div>
                    <div class="footer__cell">
                        <h4 class="footer__navigation-title">Get help</h4>
                        <nav class="footer__navigation">
                            <ul class="footer__navigation-list">
                                <li class="footer__navigation-item">
                                    <a href="/" class="footer__navigation-link link">Contact support</a>
                                </li>
                                <li class="footer__navigation-item">
                                    <a href="/" class="footer__navigation-link link">Useful information</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="footer__bottom">
                    <span class="footer__copyright">2024 © Realto. All rights reserved.</span>
                    <nav class="footer__policies">
                        <ul class="footer__policies-list">
                            <li class="footer__policies-item">
                                <a href="/" class="footer__policies-link">Privacy policy</a>
                            </li>
                            <li class="footer__policies-item">
                                <a href="/" class="footer__policies-link">Terms of service</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </footer>

        <dialog class="mobile-overlay hidden-desktop" id="mobileOverlay">
            <div class="mobile-overlay__inner">
                <form class="mobile-overlay__top-wrapper" method="dialog">
                    <a href="./home.php" class="mobile-overlay__logo logo">
                        <img src="../images/website-images/icons/logo.svg" alt="Realto" loading="lazy">
                    </a>
                    <button class="mobile-overlay__close-button cross-button">
                        <span class="visually-hidden">Close navigation menu</span>
                    </button>
                </form>
                <div class="mobile-overlay__body">
                    <ul class="mobile-overlay__list">
                        <li class="mobile-overlay__item">
                            <a href="/realto/pages/search-results.php?offer-type=buy" class="mobile-overlay__link">Buy</a>
                        </li>
                        <li class="mobile-overlay__item">
                            <a href="/realto/pages/add-listing.php" class="mobile-overlay__link">Sell</a>
                        </li>
                        <li class="mobile-overlay__item">
                            <a href="/realto/pages/search-results.php?offer-type=rent" class="mobile-overlay__link" id="mobile-overlay__item-rent">Rent</a>
                            <!--<div class="header__popup-window popup-window">
                                <ul class="mobile-overlay__list mobile-overlay__list--vertical">
                                    <li class="mobile-overlay__item">
                                        <a href="#" class="mobile-overlay__link">Find a rental</a>
                                    </li>
                                    <li class="mobile-overlay__item">
                                        <a href="#" class="mobile-overlay__link">Rent your property</a>
                                    </li>
                                </ul>
                            </div>-->
                        </li>
                        <li class="mobile-overlay__item">
                            <a href="/realto/pages/search-results.php" class="mobile-overlay__link">Latest listings</a>
                        </li>
                        <li class="mobile-overlay__item">
                            <a href="#" class="mobile-overlay__link">Support</a>
                        </li>
                    </ul>
                </div>
            </div>
        </dialog>
        <?php 
        require_once '../scripts/javascript/js-scripts.php';
        require_once '../blocks/search-filters.php';
        require_once '../blocks/sign-in-popup.php';
        require_once '../blocks/chats-popup.php';
        require_once '../blocks/support-tickets-popup.php';
        ?>
    </body>
</html>