jQuery(function ($) {
    "use strict";
    // Window Load
    $(window).load(function () {
        // Preloader
        $('.intro-tables, .parallax, header').css('opacity', '0');
        $('.preloader').addClass('animated fadeOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $('.preloader').hide();
            $('.parallax, header').addClass('animated fadeIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $('.intro-tables').addClass('animated fadeInUp').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            });
        });
        // Header Init
        if ($(window).height() > $(window).width()) {
            var ratio = $('.parallax').width() / $('.parallax').height();
            $('.parallax img').css('height', ($(window).height()) + 'px');
            $('.parallax img').css('width', $('.parallax').height() * ratio + 'px');
        }

        $('header').height($(window).height() + 80);
        $('section .cut').each(function () {
            if ($(this).hasClass('cut-top'))
                $(this).css('border-right-width', $(this).parent().width() + "px");
            else if ($(this).hasClass('cut-bottom'))
                $(this).css('border-left-width', $(this).parent().width() + "px");
        });

        // Sliders Init
        $('.owl-schedule').owlCarousel({
            singleItem: true,
            pagination: true
        });
        $('.owl-testimonials').owlCarousel({
            singleItem: true,
            pagination: true
        });
        $('.owl-twitter').owlCarousel({
            singleItem: true,
            pagination: true
        });

        // Navbar Init
        $('nav').addClass('original').clone().insertAfter('nav').addClass('navbar-fixed-top').css('position', 'fixed').css('top', '0').css('margin-top', '0').removeClass('original');
        $('.mobile-nav ul').html($('nav .navbar-nav').html());
        $('nav.navbar-fixed-top .navbar-brand img').attr('src', $('nav.navbar-fixed-top .navbar-brand img').data("active-url"));

        // Typing Intro Init
        $(".typed").typewriter({
            speed: 60
        });

        // Popup Form Init
        var i = 0;
        var interval = 0.15;
        $('.popup-form .dropdown-menu li').each(function () {
            $(this).css('animation-delay', i + "s");
            i += interval;
        });
        $('.popup-form .dropdown-menu li a').click(function (event) {
            event.preventDefault();
            $(this).parent().parent().prev('button').html($(this).html());
        });

        // Onepage Nav
        $('.navbar.navbar-fixed-top .navbar-nav').onePageNav({
            currentClass: 'active',
            changeHash: false,
            scrollSpeed: 400,
            filter: ':not(.btn)'
        });
    });
    // Window Scroll
    function onScroll() {
        if ($(window).scrollTop() > 50) {
            $('nav.original').css('opacity', '0');
            $('nav.navbar-fixed-top').css('opacity', '1');
        } else {
            $('nav.original').css('opacity', '1');
            $('nav.navbar-fixed-top').css('opacity', '0');
        }
    }

    window.addEventListener('scroll', onScroll, false);

    // Window Resize
    $(window).resize(function () {
        $('header').height($(window).height());
    });

    // Pricing Box Click Event
    $('.pricing .box-main').click(function () {
        $('.pricing .box-main').removeClass('active');
        $('.pricing .box-second').removeClass('active');
        $('.pricing .box-second').contents().hide();
        $('.box-main .h3').addClass('white');
        $('.box-main .rankpngbig').css("content", "url(img/ranks/0.png");
        $('.box-main .perwinpngbig').css("content", "url(img/perwinboostimage.png");
        $(this).addClass('active');
        $(this).next($('.box-second')).addClass('active');
        $(this).next($('.box-second')).contents().show();
        $(this).find('h3').removeClass('white');
        $(this).find('img').css("content", "url(img/ranks/17.png");
        $(this).find('.perwinpngbig').css("content", "url(img/perwinboostactiveimage.png");
        $('#boost').css("background-image", "url(" + $(this).data('img') + ")");
        $('#boost').css("background-size", "cover");
    });

    // Mobile Nav
    $('body').on('click', 'nav .navbar-toggle', function () {
        event.stopPropagation();
        $('.mobile-nav').addClass('active');
    });
    $('.btn.btn-white-fill.expand').click(function(event){
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top
        }, 1000);
    });

    $('#rankBoostButton').click(function (event) {
       event.preventDefault();
        var perWinBoostImage = $('#perWinBoostImage');
        var rankBoostImage= $('#rankBoostImage');

        var perWinBoostBoxMain = $('#perWinBoostBoxMain');
        var perWinBoostBoxSecond = $('#perWinBoostBoxSecond');
        var perWinBoostBoxMainH3 = $('#perWinBoostBoxMainH3');

        var rankBoostBoxMain = $('#rankBoostBoxMain');
        var rankBoostBoxSecond = $('#rankBoostBoxSecond');
        var rankBoostBoxMainH3 = $('#rankBoostBoxMainH3');

        perWinBoostImage.css('content','url(img/perWinBoostImage.png)');
        rankBoostImage.css('content','url(img/ranks/17.png)');

        perWinBoostBoxMain.removeClass('active');
        perWinBoostBoxSecond.removeClass('active');
        perWinBoostBoxSecond.contents().hide();
        perWinBoostBoxMainH3.addClass('white');

        rankBoostBoxMain.addClass('active');
        rankBoostBoxSecond.addClass('active');
        rankBoostBoxSecond.contents().show();
        rankBoostBoxMainH3.removeClass('white');
    });
    $('#perWinButton').click(function (event) {
        event.preventDefault();

        var perWinBoostImage = $('#perWinBoostImage');
        var rankBoostImage= $('#rankBoostImage');

        var perWinBoostBoxMain = $('#perWinBoostBoxMain');
        var perWinBoostBoxSecond = $('#perWinBoostBoxSecond');
        var perWinBoostBoxMainH3 = $('#perWinBoostBoxMainH3');

        var rankBoostBoxMain = $('#rankBoostBoxMain');
        var rankBoostBoxSecond = $('#rankBoostBoxSecond');
        var rankBoostBoxMainH3 = $('#rankBoostBoxMainH3');

        perWinBoostImage.css('content','url(img/perWinBoostActiveImage.png)');
        rankBoostImage.css('content','url(img/ranks/0.png)');

        perWinBoostBoxMain.addClass('active');
        perWinBoostBoxSecond.addClass('active');
        perWinBoostBoxSecond.contents().show();
        perWinBoostBoxMainH3.removeClass('white');

        rankBoostBoxMain.removeClass('active');
        rankBoostBoxSecond.removeClass('active');
        rankBoostBoxSecond.contents().hide();
        rankBoostBoxMainH3.addClass('white');

    });
    $(window).resize(function () {
        if ($(window).width() <= 991) {
            var perWinBoostImage = $('#perWinBoostImage');
            var rankBoostImage= $('#rankBoostImage');

            var perWinBoostBoxMain = $('#perWinBoostBoxMain');
            var perWinBoostBoxSecond = $('#perWinBoostBoxSecond');
            var perWinBoostBoxMainH3 = $('#perWinBoostBoxMainH3');

            var rankBoostBoxMain = $('#rankBoostBoxMain');
            var rankBoostBoxSecond = $('#rankBoostBoxSecond');
            var rankBoostBoxMainH3 = $('#rankBoostBoxMainH3');

            perWinBoostImage.css('content','url(img/perWinBoostImage.png)');
            rankBoostImage.css('content','url(img/ranks/17.png)');

            perWinBoostBoxMain.removeClass('active');
            perWinBoostBoxSecond.removeClass('active');
            perWinBoostBoxSecond.contents().show();
            perWinBoostBoxMainH3.addClass('white');

            rankBoostBoxMain.addClass('active');
            rankBoostBoxSecond.addClass('active');
            rankBoostBoxSecond.contents().show();
            rankBoostBoxMainH3.removeClass('white');

        }
    });

    $('body').on('click', '.mobile-nav a', function (event) {
        $('.mobile-nav').removeClass('active');
        if (!this.hash) return;
        event.preventDefault();
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            event.stopPropagation();
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

    $('body').on('click', '.mobile-nav a.close-link', function (event) {
        $('.mobile-nav').removeClass('active');
        event.preventDefault();
    });

    $('body').on('click', 'nav.original .navbar-nav a:not([data-toggle])', function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            event.stopPropagation();
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

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

    $('.modal').on('show.bs.modal', centerModal);
    
    $('.modal-popup .close-link').click(function (event) {
        event.preventDefault();
        $('.modal').modal('hide');
    });
    $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
    });
    //my added function

});
