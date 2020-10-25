$(function () {
    // Start home page ----------
    // header-profile-menu
    $('#profile_dropdown').on('click', function(){
        if ($(this).hasClass('show')) {
            $(this).removeClass('show');
        } else {
            $(this).addClass('show');
        }
    });
    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $("#profile_dropdown"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $(div).removeClass('show'); // скрываем его
        }
    });
    //site_search
    $('.search__active').on('click', function(){
        $('#site_search').addClass('show');
    });
    $('#site_search .close').on('click', function() {
        $('#site_search').removeClass('show');
    });
    // tabs_box
    $('#tabs_box ul li').on('click', function (){
        $('#tabs_box ul li').removeClass('active');
        $(this).addClass('active');

        var content_box = "#"+$(this).data('tab-content-box');
        $("[id^='content_item_']").removeClass('active');
        $(content_box).addClass('active');
    });
    // sliders
    $('#banner-main .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        dots:true,
        nav: true,
        autoplay:true,
        autoplayTimeout:7000,
        navText: ''
    });
    $("#articles_slider .owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
        autoplayTimeout:7000,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480 : {
                items: 2
            },
            // breakpoint from 768 up
            768 : {
                items: 3
            },
            // breakpoint from 997 up
            997 : {
                items: 4
            }
        }
    });
    $("#books_slider .owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
        autoplayTimeout:7000,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480 : {
                items: 2
            },
            // breakpoint from 768 up
            768 : {
                items: 3
            },
            // breakpoint from 997 up
            997 : {
                items: 4
            }
        }
    });
    $("#audios_books_slider .owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
        autoplayTimeout:7000,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480 : {
                items: 2
            },
            // breakpoint from 768 up
            768 : {
                items: 3
            },
            // breakpoint from 997 up
            997 : {
                items: 4
            }
        }
    });
    $("#videos_slider .owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
        autoplayTimeout:7000,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480 : {
                items: 2
            },
            // breakpoint from 768 up
            768 : {
                items: 3
            },
            // breakpoint from 997 up
            997 : {
                items: 4
            }
        }
    });
    $("#my_books_slider .owl-carousel").owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
        autoplayTimeout:7000,
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480 : {
                items: 2
            },
            // breakpoint from 768 up
            768 : {
                items: 3
            },
            // breakpoint from 997 up
            997 : {
                items: 2
            }
        }
    });
    $('#advertisings .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        dots:true,
        nav: true,
        navText: ''
    });
    // about
    $('#about a.show-btn').on('click', function () {
        $('#about .content-box').addClass('show');
    });
    // ---------- End home page
});
