/**
 * Created by Klinek on 16.08.2016.
 */
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-min');
    var amount = $('#amount');
    sliderRangeMin.slider({
        range: 'min',
        value: 10,
        min: 10,
        max: 10,
        slide: function (event, ui) {
            amount.val(ui.value);

            currentRank = $('#current-per-win-select').prop('selectedIndex');
            perWinPrice = perWinPrices[currentRank] * ui.value;
            if ($('#duo-per-win-checkbox').is(':checked')) {
                perWinPrice = perWinPrice * 1.5;
            }
            $('#total-price-per-win-h2').text("€" + Math.round(perWinPrice));
        }
    });
    amount.val(sliderRangeMin.slider('value'));
});

/**
 * Created by Klinek on 16.08.2016.
 */
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-start');
    var amount = $('#amount-start');
    sliderRangeMin.slider({
        range: 'min',
        value: 1,
        min: 1,
        max: 24,
        step: 1,
        slide: function (event, ui) {
            amount.val(ui.value);
        }
    });
    amount.val(sliderRangeMin.slider('value'));
});
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-end');
    var amount = $('#amount-end');
    sliderRangeMin.slider({
        range: 'min',
        value: 2,
        min: 1,
        max: 25,
        step: 1,
        slide: function (event, ui) {
            amount.val(ui.value);
        }
    });
    amount.val(sliderRangeMin.slider('value'));
});
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-pokemon');
    var amount = $('#amount-pokemon');
    sliderRangeMin.slider({
        range: 'min',
        value: 10,
        min: 10,
        max: 100,
        step: 10,
        slide: function (event, ui) {
            amount.val(ui.value);

            var PokemonPrice = ui.value*0.4;
            $('#total-price-per-pokemon-h2').text("€" + Math.round(PokemonPrice));

        }
    });
    amount.val(sliderRangeMin.slider('value'));
});



