<dialog class="search-filters" id="searchFilters">
    <div class="search-filters__header">
        <h3 class="search-filters__title h4">Filters</h3>
        <form method="dialog" class="search-filters__cross-button-wrapper">
            <button class="search-filters__cross-button cross-button cross-button--thick">
                <span class="visually-hidden">Close filters window</span>
            </button>
        </form>
    </div>
    <form class="search-filters__form" id="search-filters-form">
        <div class="search-filters__form-inner">
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label field__label--required">Property type
                    </legend>
                    <div class="search-filters__field-row field__row">
                        <label class="search-filters__field-input field__input button">Houses
                            <input type="radio" name="property-type" class="field__input--radio" value="houses"
                                required>
                        </label>
                        <label class="search-filters__field-input field__input button">Apartments
                            <input type="radio" name="property-type" class="field__input--radio" value="apartments"
                                required>
                        </label>
                        <label class="search-filters__field-input field__input button">All types
                            <input type="radio" name="property-type" class="field__input--radio" value="all" required>
                        </label>
                    </div>
                </fieldset>
            </div>
            <!--
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field" id="house-floors-field search-filters__fieldset--universal">
                    <legend class="search-filters__field-label field__label">House floors</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="building-floors-min" class="search-filters__input field__input" placeholder="From..." min="1" max="199">
                        <input type="number" name="building-floors-max" class="search-filters__input field__input" placeholder="Up to..." min="1" max="199">
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field" id="lot-size-field search-filters__fieldset--universal">
                    <legend class="search-filters__field-label field__label">Lot size in sq ft</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="lot-size-min" class="search-filters__input field__input" placeholder="From..." min="500" max="150000">
                        <input type="number" name="lot-size-max" class="search-filters__input field__input" placeholder="Up to..." min="500" max="150000">
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field search-filters__fieldset--universal">
                    <legend class="search-filters__field-label field__label">Floor</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="floor-min" class="search-filters__input field__input" placeholder="From..." min="1" max="120">
                        <input type="number" name="floor-max" class="search-filters__input field__input" placeholder="Up to..." min="1" max="120">
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field search-filters--universal">
                    <legend class="search-filters__field-label field__label">Parking spots</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="parking-spots-min" class="search-filters__input field__input" placeholder="From..." min="0" max="30">
                        <input type="number" name="parking-spots-max" class="search-filters__input field__input" placeholder="Up to..." min="0" max="30">
                    </div>
                </fieldset>
            </div>
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field search-filters__fieldset--universal">
                    <legend class="search-filters__field-label field__label">Footage in sq ft</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="footage-min" class="search-filters__input field__input" placeholder="From..." min="0" max="30000">
                        <input type="number" name="footage-max" class="search-filters__input field__input" placeholder="Up to..." min="0" max="30000">
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field search-filters__fieldset--universal">
                    <legend class="search-filters__field-label field__label">Bedrooms</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="bedrooms-min" class="search-filters__input field__input" placeholder="From..." min="1" max="30">
                        <input type="number" name="bedrooms-max" class="search-filters__input field__input" placeholder="Up to..." min="1" max="30">
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field search-filters__fieldset--universal">
                    <legend class="search-filters__field-label field__label">Bathrooms</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="bathrooms-min" class="search-filters__input field__input" placeholder="From..." min="1" max="30">
                        <input type="number" name="bathrooms-max" class="search-filters__input field__input" placeholder="Up to..." min="1" max="30">
                    </div>
                </fieldset>
            </div>
-->
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label field__label--required">Offer type</legend>
                    <div class="search-filters__field-row field__row">
                        <label class="search-filters__field-input field__input button">For sale
                            <input type="radio" name="offer-type" class="field__input--radio" value="for-sale" required>
                        </label>
                        <label class="search-filters__field-input field__input button">For rent
                            <input type="radio" name="offer-type" class="field__input--radio" value="for-rent" required>
                        </label>
                        <label class="search-filters__field-input field__input button">All types
                            <input type="radio" name="offer-type" class="field__input--radio" value="all" required>
                        </label>
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label field__label--required">Select district
                    </legend>
                    <div class="search-filters__field-row field__row">
                        <select class="search-filters__field-input field__input field__input--select" name="district"
                            id="search-filters-district" required data-districts>
                            <option value="all">All districts</option>
                        </select>
                    </div>
                </fieldset>
            </div>
            <!--
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label">Sale price</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="sale-price-min" class="search-filters__input search-filters__input--long field__input field__input--long" placeholder="Starts from..." min="1" max="99999999">
                        <input type="number" name="sale-price-max" class="search-filters__input field__input" placeholder="Up to..." min="1" max="99999999">
                    </div>
                </fieldset>
            </div>
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label">Rent details</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="rent-days-min" class="search-filters__input--long field__input--long search-filters__input field__input" placeholder="Min. time (days)" min="1" max="9999">
                    </div>
                </fieldset>
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label">Price/mo</legend>
                    <div class="search-filters__field-row field__row">
                        <input type="number" name="rent-price-min" class="search-filters__input field__input" placeholder="From..." min="1" max="999999">
                        <input type="number" name="rent-price-max" class="search-filters__input field__input" placeholder="Up to..." min="1" max="999999">
                    </div>
                </fieldset>
            </div>
-->
            <!--
            <div class="search-filters__fieldset-row field__fieldset-row">
                <fieldset class="search-filters__field field">
                    <legend class="search-filters__field-label field__label field__label--required">Pet-friendly</legend>
                    <div class="search-filters__field-row field__row">
                        <label class="search-filters__field-input field__input button">Yes
                            <input type="radio" name="pet-friendly" class="field__input--radio" value="yes" required>
                        </label>
                        <label class="search-filters__field-input field__input button">Doesn't matter
                            <input type="radio" name="pet-friendly" class="field__input--radio" value="not-specified" required>
                        </label>
                    </div>
                </fieldset>
            </div>
-->
        </div>
        <div class="search-filters__buttons-container">
            <button class="search-filters__button--ghost search-filters__button button--ghost button" type="reset">Reset
                filters</button>
            <button class="search-filters__button button">Search</button>
        </div>
    </form>
</dialog>