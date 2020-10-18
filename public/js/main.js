$(function () {
    // Start home page ----------
    // banner-main
    $('#banner-main .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        dots:true,
        nav: true,
        autoplay:true,
        autoplayTimeout:7000,
        navText: ''
    });

    // tabs_box
    $('#tabs_box ul li').on('click', function (){
        $('#tabs_box ul li').removeClass('active');
        $(this).addClass('active');

        var content_box = "#"+$(this).data('tab-content-box');
        $("[id^='content_item_']").removeClass('active');
        $(content_box).addClass('active');
    });

    // slider
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
                items: 1
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
                items: 1
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
                items: 1
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
                items: 1
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
                items: 1
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
    // ---------- End home page
});
