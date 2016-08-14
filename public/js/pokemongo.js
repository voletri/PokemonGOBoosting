var baseUrl = window.location.protocol + '//' + window.location.host + '/';

var rankBoostPrices = null;

var perWinPrices = null;
//LOADING PRICES FROM SERVER
/*$.ajax({
    type: 'POST',
    url: baseUrl + 'getPrices',
    data: null,
    async: true,
    dataType: 'json',
    success: function (data) {
        rankBoostPrices = data['RankBoost'];
        perWinPrices = data['PerWinBoost'];
    }
});*/
//region CODE FOR RANK BOOST
var rankBoostPrice = 0;

var rankBoostFakePrice = 0;

var startRank = 0;

var desiredRank = 0;

var startRankImage;

var desiredRankImage;

var totalPriceRankBoostH2;

var fakePriceRankBoostH3;

var duoRankBoostCheckBox;

var payPalRankBoostButton;
//FUNCTION CALCULATING PRICE FOR START RANK CHANGED EVENT
function startRankChanged() {
    startRank = document.getElementById('start-rank-boost-select').selectedIndex;
    desiredRank = document.getElementById('desired-rank-boost-select').selectedIndex;

    startRankImage = document.getElementById('start-rank-image');
    startRankImage.src = 'img/ranks/' + startRank + '.png';

    totalPriceRankBoostH2 = document.getElementById('total-price-rank-boost-h2');
    fakePriceRankBoostH3 = document.getElementById('fake-price-rank-boost-h3');

    payPalRankBoostButton = document.getElementById('pay-pal-rank-boost-button');
    payPalRankBoostButton.src = 'img/payPalButton.png';
    payPalRankBoostButton.disabled = false;

    if (desiredRank > startRank) {

        duoRankBoostCheckBox = document.getElementById('duo-rank-boost-checkbox');

        rankBoostPrice = rankBoostPrices[startRank][desiredRank];
        rankBoostFakePrice = Math.round(rankBoostPrice * 1.2);
        if (duoRankBoostCheckBox.checked) {
            rankBoostPrice = Math.round(rankBoostPrice * 1.5);
            rankBoostFakePrice = Math.round(rankBoostFakePrice * 1.5);
        }
        totalPriceRankBoostH2.style.color = "#008000";
        totalPriceRankBoostH2.innerHTML = "€" + Math.round(rankBoostPrice);
        fakePriceRankBoostH3.innerHTML = "€" + rankBoostFakePrice;
    }
    else {
        rankBoostPrice = 0;
        rankBoostFakePrice = 0;
        totalPriceRankBoostH2.innerHTML = "€" + 0;
        totalPriceRankBoostH2.style.color = "#989da0";
        fakePriceRankBoostH3.innerHTML = "€" + 0;
        payPalRankBoostButton.src = 'img/payPalButtonDisabled.png';
        payPalRankBoostButton.disabled = true;
    }
}
//FUNCTION CALCULATING PRICE FOR DESIRED RANK CHANGED EVENT
function desiredRankChanged() {
    startRank = document.getElementById('start-rank-boost-select').selectedIndex;
    desiredRank = document.getElementById('desired-rank-boost-select').selectedIndex;

    desiredRankImage = document.getElementById('desired-rank-image');
    desiredRankImage.src = 'img/ranks/' + desiredRank + '.png';

    totalPriceRankBoostH2 = document.getElementById('total-price-rank-boost-h2');
    fakePriceRankBoostH3 = document.getElementById('fake-price-rank-boost-h3');

    payPalRankBoostButton = document.getElementById('pay-pal-rank-boost-button');
    payPalRankBoostButton.src = 'img/payPalButton.png';
    payPalRankBoostButton.disabled = false;

    if (desiredRank > startRank) {

        duoRankBoostCheckBox = document.getElementById('duo-rank-boost-checkbox');

        rankBoostPrice = rankBoostPrices[startRank][desiredRank];
        rankBoostFakePrice = Math.round(rankBoostPrice * 1.2);
        if (duoRankBoostCheckBox.checked) {
            rankBoostPrice = Math.round(rankBoostPrice * 1.5);
            rankBoostFakePrice = Math.round(rankBoostFakePrice * 1.5);
        }

        totalPriceRankBoostH2.style.color = "#008000";
        totalPriceRankBoostH2.innerHTML = "€" + Math.round(rankBoostPrice);
        fakePriceRankBoostH3.innerHTML = "€" + rankBoostFakePrice;
    }
    else {
        rankBoostPrice = 0;
        rankBoostFakePrice = 0;
        totalPriceRankBoostH2.innerHTML = "€" + 0;
        totalPriceRankBoostH2.style.color = "#989da0";
        fakePriceRankBoostH3.innerHTML = "€" + 0;
        payPalRankBoostButton.src = 'img/payPalButtonDisabled.png';
        payPalRankBoostButton.disabled = true;
    }
}
//FUNCTION CALCULATING PRICE FOR DUO CHECK CHANGED EVENT
function duoRankBoostCheckBoxChanged() {
    duoRankBoostCheckBox = document.getElementById('duo-rank-boost-checkbox');

    totalPriceRankBoostH2 = document.getElementById('total-price-rank-boost-h2');
    fakePriceRankBoostH3 = document.getElementById('fake-price-rank-boost-h3');

    rankBoostPrice = rankBoostPrices[startRank][desiredRank];
    rankBoostFakePrice = Math.round(rankBoostPrice * 1.2);
    if (duoRankBoostCheckBox.checked) {

        totalPriceRankBoostH2.innerHTML = "€" + Math.round(rankBoostPrice * 1.5);
        fakePriceRankBoostH3.innerHTML = "€" + Math.round(rankBoostFakePrice * 1.5);
    }
    else {
        totalPriceRankBoostH2.innerHTML = "€" + Math.round(rankBoostPrice);
        fakePriceRankBoostH3.innerHTML = "€" + rankBoostFakePrice;
    }

}
//endregion
//region CODE FOR PER WIN
var perWinPrice = 0;

var currentRank;

var currentRankImage;

var totalPricePerWinH2;

var duoPerWinCheckBox;

var amount;
//FUNCTION CALCULATING PRICE FOR CURRENT RANK CHANGED EVENT
function currentRankChanged() {
    currentRank = document.getElementById('current-per-win-select').selectedIndex;

    currentRankImage = document.getElementById('current-rank-image');

    totalPricePerWinH2 = document.getElementById('total-price-per-win-h2');

    duoPerWinCheckBox = document.getElementById('duo-per-win-checkbox');

    amount = document.getElementById('amount');

    currentRankImage.src = 'img/ranks/' + currentRank + '.png';

    perWinPrice = perWinPrices[currentRank] * amount.value;

    if (duoPerWinCheckBox.checked) {
        perWinPrice = perWinPrice * 1.5;
    }
    totalPricePerWinH2.innerHTML = "€" + Math.round(perWinPrice);

}
//FUNCTION CALCULATING PRICE FOR DUO CHECK CHANGED EVENT
function duoPerWinCheckBoxChanged() {
    duoPerWinCheckBox = document.getElementById('duo-per-win-checkbox');

    totalPricePerWinH2 = document.getElementById('total-price-per-win-h2');

    currentRank = document.getElementById('current-per-win-select').selectedIndex;

    amount = document.getElementById('amount');

    perWinPrice = perWinPrices[currentRank];

    if (duoPerWinCheckBox.checked) {
        totalPricePerWinH2.innerHTML = "€" + Math.round(perWinPrice * 1.5 * amount.value);
    }
    else {
        totalPricePerWinH2.innerHTML = "€" + Math.round(perWinPrice * amount.value);
    }
}
//CODE FOR SLIDER
$(function () {
    var sliderRangeMin = $('#slider-range-min');
    var amount = $('#amount');
    sliderRangeMin.slider({
        range: 'min',
        value: 1,
        min: 1,
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
//endregion
function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog"),
        offset = ($(window).height() - $dialog.height()) / 2,
        bottomMargin = parseInt($dialog.css('marginBottom'), 10);

    // Make sure you don't hide the top part of the modal w/ a negative margin
    // if it's longer than the screen height, and keep the margin equal to
    // the bottom margin of the modal
    if (offset < bottomMargin) offset = bottomMargin;
    $dialog.css("margin-top", offset);
}


function readResponseMessage(messages) {
    var text = '';
    for (var i = 0; i < messages.length; i++) {
        text = text + messages[i];
    }
    return text;
}

function showPopUp(title, type, text) {
    swal({
        title: title,
        text: text,
        type: type,
        allowEscapeKey: true,
        allowOutsideClick: true,
        showCancelButton: false,
        showConfirmButton: true,
        confirmButtonText: 'Close',
        confirmButtonColor: '#ffa500',
        closeOnConfirm: true,
        animation: true
    });
}

$(document).ready(function () {
    //MODALS
    var paymentSuccessfulModal =$('#paymentSuccessfulModal');
    var paymentFailureModal = $('#paymentFailureModal');
    var confirmOrderModal = $('#confirmOrderModal');
    var registerModal = $('#registerModal');
    var loginModal = $('#loginModal');
    //region Showing modals after page load
    paymentSuccessfulModal.on('show.bs.modal', centerModal);
    setTimeout(function () {
        paymentSuccessfulModal.modal({backdrop: "static"});
    }, 1500);
    paymentFailureModal.on('show.bs.modal', centerModal);
    setTimeout(function () {
        paymentFailureModal.modal('show');
    }, 1500);
    confirmOrderModal.on('show.bs.modal', centerModal);
    setTimeout(function () {
        confirmOrderModal.modal({backdrop: 'static'})
    }, 1500);
    registerModal.on('show.bs.modal', centerModal);
    setTimeout(function () {
        registerModal.modal('show');
    }, 1500);
    loginModal.on('show.bs.modal', centerModal);
    setTimeout(function () {
        loginModal.modal('show');
    }, 1500);
    //endregion

    //region Code for modals(sending data from forms to server and handling responses)
    //FOR CONTACT MODAL
    var contactSubmit = $('#contactSubmit');
    contactSubmit.click(function () {

        var contactName = $('#contactName');
        var contactEmail = $('#contactEmail');
        var contactMessage = $('#contactMessage');
        //disable editing until response
        contactSubmit.html('<i id="sendingIcon" class="fa fa-circle-o-notch fa-spin"></i>');
        contactSubmit.prop('disabled', true);
        contactName.prop('disabled', true);
        contactEmail.prop('disabled', true);
        contactMessage.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: baseUrl + 'contact',
            dataType: 'json',
            async: true,
            data: {name: contactName.val(), email: contactEmail.val(), message: contactMessage.val()},
            success: function (response) {
                //enable after response
                contactSubmit.html('Submit');
                contactSubmit.prop('disabled', false);
                contactName.prop('disabled', false);
                contactEmail.prop('disabled', false);
                contactMessage.prop('disabled', false);
                switch (response['status']) {
                    case 'successful':
                        $('#contactModal').modal('hide');
                        setTimeout(showPopUp('Message sent', 'success', readResponseMessage(response['msg'])), 750);
                        break;
                    case 'error':
                        showPopUp('Warning!', 'warning', readResponseMessage(response['msg']));
                        break;
                    case 'critical_error':
                        showPopUp('Oops...', 'error', readResponseMessage(response['msg']));
                        break;
                }
            },
            error: function () {
                contactSubmit.html('Submit');
                contactSubmit.prop('disabled', false);
                contactName.prop('disabled', false);
                contactEmail.prop('disabled', false);
                contactMessage.prop('disabled', false);
                showPopUp('Oops...', 'error', 'Server not responding. Try again later.');
            }
        });
    });
    //FOR PAYMENT SUCCESSFUL MODAL
    var customerSubmit = $('#customerSubmit');
    customerSubmit.click(function () {
        var customerEmail = $('#customerEmail');
        var customerMessage = $('#customerMessage');
        customerSubmit.html('<i id="sendingIcon" class="fa fa-circle-o-notch fa-spin"></i>');
        customerSubmit.prop('disabled', true);
        customerEmail.prop('disabled', true);
        customerMessage.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: baseUrl + 'addCustomer',
            dataType: 'json',
            async: true,
            data: {customerEmail: customerEmail.val(), customerMessage: customerMessage.val()},
            success: function (response) {
                customerSubmit.html('Submit');
                customerSubmit.prop('disabled', false);
                customerEmail.prop('disabled', false);
                customerMessage.prop('disabled', false);

                switch (response['status']) {
                    case 'successful':
                        paymentSuccessfulModal.modal('hide');
                        setTimeout(showPopUp('Order has been completed', 'success', readResponseMessage(response['msg'])), 750);
                        break;
                    case 'error':
                        showPopUp('Warning!', 'warning', readResponseMessage(response['msg']));
                        break;
                    case 'critical_error':
                        showPopUp('Oops...', 'error', readResponseMessage(response['msg']));
                        break;
                }
            },
            error: function () {
                customerSubmit.html('Submit');
                customerSubmit.prop('disabled', false);
                customerEmail.prop('disabled', false);
                customerMessage.prop('disabled', false);
                showPopUp('Oops...', 'error', 'Server not responding. Try again later.');
            }
        });
    });
    //FOR ORDER CONFIRMATION MODAL
    var orderConfirm = $('#orderConfirm');
    orderConfirm.click(function () {
        var duo = $('#duo');
        var contactOption = $('#contactOption');
        var contact = $('#contact');
        var accountName = $('#accountName');
        var accountPassword = $('#accountPassword');
        orderConfirm.html('<i id="sendingIcon" class="fa fa-circle-o-notch fa-spin"></i>');
        contactOption.prop('disabled', true);
        contact.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: baseUrl + 'confirmation',
            dataType: 'json',
            async: true,
            data: {
                duo: duo.val(),
                contactOption: contactOption.val(),
                contact: contact.val(),
                accountName: accountName.val(),
                accountPassword: accountPassword.val()
            },
            success: function (response) {
                orderConfirm.html('Confirm');
                contactOption.prop('disabled', false);
                contact.prop('disabled', false);
                switch (response['status']) {
                    case 'successful':
                        confirmOrderModal.modal('hide');
                        setTimeout(showPopUp('Order has been completed', 'success', readResponseMessage(response['msg'])), 750);
                        break;
                    case 'error':
                        showPopUp('Warning!', 'warning', readResponseMessage(response['msg']));
                        break;
                    case 'critical_error':
                        showPopUp('Oops...', 'error', readResponseMessage(response['msg']));
                        break;
                }
            },
            error: function () {
                orderConfirm.html('Confirm');
                contactOption.prop('disabled', false);
                contact.prop('disabled', false);
                showPopUp('Oops...', 'error', 'Server not responding. Try again later.');
            }
        });
    });
    //FOR BOOSTER REGISTRATION MODAL
    var registerSubmit = $('#registerSubmit');
    registerSubmit.click(function () {

        var boosterName = $('#boosterName');
        var boosterEmail = $('#boosterEmail');
        var boosterPassword = $('#boosterPassword');
        var retypeBoosterPassword = $('#retypeBoosterPassword');


        registerSubmit.html('<i id="sendingIcon" class="fa fa-circle-o-notch fa-spin"></i>');
        boosterName.prop('disabled', true);
        boosterEmail.prop('disabled', true);
        boosterPassword.prop('disabled', true);
        retypeBoosterPassword.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: baseUrl + 'registerBooster',
            dataType: 'json',
            async: true,
            data: {
                boosterName: boosterName.val(),
                boosterEmail: boosterEmail.val(),
                boosterPassword: boosterPassword.val(),
                retypeBoosterPassword: retypeBoosterPassword.val()
            },
            success: function (response) {
                registerSubmit.html('Register');
                boosterName.prop('disabled', false);
                boosterEmail.prop('disabled', false);
                boosterPassword.prop('disabled', false);
                retypeBoosterPassword.prop('disabled', false);
                switch (response['status']) {
                    case 'successful':
                        registerModal.modal('hide');
                        setTimeout(showPopUp('Registration Successful!', 'success', readResponseMessage(response['msg'])), 750);
                        break;
                    case 'error':
                        showPopUp('Warning!', 'warning', readResponseMessage(response['msg']));
                        break;
                    case 'critical_error':
                        showPopUp('Oops...', 'error', readResponseMessage(response['msg']));
                        break;
                }
            },
            error: function () {
                registerSubmit.html('Register');
                boosterName.prop('disabled', false);
                boosterEmail.prop('disabled', false);
                boosterPassword.prop('disabled', false);
                retypeBoosterPassword.prop('disabled', false);
                showPopUp('Oops...', 'error', 'Server not responding. Try again later.');
            }
        });
    });
    //FOR BOOSTER LOGIN MODAL
    var loginSubmit = $('#loginSubmit');
    loginSubmit.click(function () {

        var boosterName = $('#boosterName');
        var boosterPassword = $('#boosterPassword');

        loginSubmit.html('<i id="sendingIcon" class="fa fa-circle-o-notch fa-spin"></i>');
        boosterName.prop('disabled', true);
        boosterPassword.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: baseUrl + 'login',
            dataType: 'json',
            async: true,
            data: {boosterName: boosterName.val(), boosterPassword: boosterPassword.val()},
            success: function (response) {
                loginSubmit.html('Login');
                boosterName.prop('disabled', false);
                boosterPassword.prop('disabled', false);
                switch (response['status']) {
                    case 'success':
                        console.log('success');
                        window.location.replace(readResponseMessage(response['msg']));
                        break;
                    case 'error':
                        showPopUp('Warning!', 'warning', readResponseMessage(response['msg']));
                        console.log('error');
                        break;
                    case 'critical_error':
                        break;
                }
            },
            error: function () {
                loginSubmit.html('Login');
                boosterName.prop('disabled', false);
                boosterPassword.prop('disabled', false);
                showPopUp('Oops...', 'error', 'Server not responding. Try again later.');
            }
        });
    });
    //endregion
});