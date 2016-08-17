
/**
 * Created by Klinek on 16.08.2016.
 */
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-start');
    var amount = $('#amount-start');
    var pic = $('#start-rank-image');
    sliderRangeMin.slider({
        range: 'min',
        value: 1,
        min: 1,
        max: 24,
        step: 1,
        slide: function (event, ui) {
            amount.val(ui.value)

            switch (true){
                case (ui.value >= 10 && ui.value <20):
                    pic.css('content','url(img/Ivysaur.png')
                    break;
                case (ui.value >= 20):
                    pic.css('content','url(img/Venusaur.png')
                    break;
                default:
                    pic.css('content','url(img/BulbasaurReal.png')
            }
        }
    });
    amount.val(sliderRangeMin.slider('value'));
});
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-end');
    var amount = $('#amount-end');
    var picEnd = $('#desired-rank-image');
    sliderRangeMin.slider({
        range: 'min',
        value: 2,
        min: 1,
        max: 25,
        step: 1,
        slide: function (event, ui) {
            amount.val(ui.value);

            switch (true){
                case (ui.value >= 10 && ui.value <20):
                    picEnd.css('content','url(img/Charmeleon.png');
                    break;
                case (ui.value >= 20):
                    picEnd.css('content','url(img/Charizard.png)');
                    break;
                default:
                    picEnd.css('content','url(img/CharmanderReal.png)');
            }


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



