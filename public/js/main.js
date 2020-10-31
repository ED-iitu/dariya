$(function () {
    // Start home page ----------
    // header-profile-menu
    $('#profile_dropdown').on('click', function () {
        if ($(this).hasClass('show')) {
            $(this).removeClass('show');
        } else {
            $(this).addClass('show');
        }
    });
    $(document).mouseup(function (e) { // событие клика по веб-документу
        var div = $("#profile_dropdown"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $(div).removeClass('show'); // скрываем его
        }
    });
    //site_search
    $('.search__active').on('click', function () {
        $('#site_search').addClass('show');
<<<<<<< Updated upstream
        $('#site_search').find('input[type="text"]').focus();
=======
        $('#blackout-box').removeClass('d-none');
>>>>>>> Stashed changes
    });
    $('#site_search .close').on('click', function () {
        $('#site_search').removeClass('show');
        $('#blackout-box').addClass('d-none');

        $('.results-box').html('');
        $('#site_search input[name="search"]').val('');
    });
    $('#site_search input[name="search"]').on('input',function(){
        var url = 'http://127.0.0.1:8000/';
        var obj = {
            text: $(this).val()
        };
        if ($(this).val().length >= 3) {
            $('.results-box').removeClass('d-none');

            var html = "";
            html += "<div style='height: 60px;text-align: center;padding: 15px;border-top: 1px solid #e4e4e4;'><img src='../../images/icons/load.gif' style='height: 100%;'></div>";
            $('.results-box').html(html);

            $.ajax({
                url,
                type: 'POST',
                data: obj,
                success: function (data) {
                    data = [
                        {
                            link: 'item link',
                            image: '/images/bg/7.jpg',
                            label: 'Label',
                            title: 'Title',
                            text: 'Lorem ipsum dolor sit amet, consectetur adipisicing.',
                            price: '1 599',
                        },
                    ];

                    var html = "";
                    if (data.length != 0) {
                        $.each(data, function(key, value){
                            var link = value.link;
                            var image = value.image;
                            var label = value.label;
                            var title = value.title;
                            var text = value.text;
                            var price = value.price;
                            html += "<a href='"+link+"' class='result p-2 p-md-3'>";
                            html += "<div class='image mr-3' style='background-image: url("+image+");'></div>";
                            html += "<div class='content'><div class='info'><h6 class='title mb-1'>"+title+"</h6><span class='label'>"+label+"</span><p class='text mb-0'>"+text+"</p></div><div class='price'><span>"+price+" ₸</span></div></div>";
                            html += "</a>";
                        });
                        if (data.length >= 5) {
                            html += "<div class='p-2' style='border-top: 1px solid #e4e4e4;text-align:center;'><a href='#' style='text-align: center;background: #0091ff;color: #fff;' class='btn'>Все результаты</a></div>";
                        }
                    } else {
                        html += "<div style='height: 100px;' class='d-flex align-items-center justify-content-center p-3'><h6>Ничего не найдено</h6></div>";
                    }
                    $('.results-box').html(html);
                },
                error: function (msg) {
                    alert('Ajax error');
                    // $('.results-box').html('');
                }
            });
        }
    })
    // tabs_box
    $('#tabs_box ul li').on('click', function () {
        $('#tabs_box ul li').removeClass('active');
        $(this).addClass('active');

        var content_box = "#" + $(this).data('tab-content-box');
        $("[id^='content_item_']").removeClass('active');
        $(content_box).addClass('active');
    });
    // sliders
    $('#banner-main .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        nav: true,
<<<<<<< Updated upstream
        autoplay: true,
        autoplayTimeout: 7000,
        navText: ''
=======
        navText: '',
        autoplay:true,
        autoplayTimeout:7000,
        animateOut: 'fadeOut',
>>>>>>> Stashed changes
    });
    $("#articles_slider .owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
<<<<<<< Updated upstream
        autoplayTimeout: 5000,
=======
        autoplay:true,
        autoplayTimeout:5000,
>>>>>>> Stashed changes
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480: {
                items: 2,
                autoplayTimeout: 5000,
            },
            // breakpoint from 768 up
            768: {
                items: 3,
                autoplayTimeout: 5000,
            },
            // breakpoint from 997 up
            997: {
                items: 4,
                autoplayTimeout: 5000,
            }
        }
    });
    $("#books_slider .owl-carousel").owlCarousel({
        items: 4,
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
<<<<<<< Updated upstream
        autoplayTimeout: 5000,
=======
        autoplay:true,
        autoplayTimeout:5000,
>>>>>>> Stashed changes
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480: {
                items: 2
            },
            // breakpoint from 768 up
            768: {
                items: 3
            },
            // breakpoint from 997 up
            997: {
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
<<<<<<< Updated upstream
        autoplayTimeout: 7000,
=======
        autoplay:true,
        autoplayTimeout:5000,
>>>>>>> Stashed changes
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480: {
                items: 2
            },
            // breakpoint from 768 up
            768: {
                items: 3
            },
            // breakpoint from 997 up
            997: {
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
<<<<<<< Updated upstream
        autoplayTimeout: 7000,
=======
        autoplay:true,
        autoplayTimeout:5000,
>>>>>>> Stashed changes
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480: {
                items: 2
            },
            // breakpoint from 768 up
            768: {
                items: 3
            },
            // breakpoint from 997 up
            997: {
                items: 4
            }
        }
    });
    $("#my_books_slider .owl-carousel").owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        navText: '',
<<<<<<< Updated upstream
        autoplayTimeout: 7000,
=======
        autoplay:true,
        autoplayTimeout:5000,
>>>>>>> Stashed changes
        responsive: {
            // breakpoint from 0 up
            0: {
                items: 2
            },
            // breakpoint from 480 up
            480: {
                items: 2
            },
            // breakpoint from 768 up
            768: {
                items: 3
            },
            // breakpoint from 997 up
            997: {
                items: 2
            }
        }
    });
    $('#advertisings .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
<<<<<<< Updated upstream
        dots: true,
        nav: true,
=======
        dots:true,
        autoplay:true,
        autoplayTimeout:5000,
>>>>>>> Stashed changes
        navText: ''
    });
    // about
    $('#about a.show-btn').on('click', function () {
        $('#about .content-box').addClass('show');
    });
    // ---------- End home page

    $('.shop__sidebar h3').on('click', function () {
        $(this).siblings('ul').toggle();
    });
    $('.shop__sidebar li').on('click', function () {
        $(this).toggleClass('active');
        let count = $('.shop__sidebar li.active').length;
        if (count > 0) {
            $('.shop__sidebar button').addClass('btn-primary');
        } else {
            $('.shop__sidebar button').removeClass('btn-primary');
        }
        if ($(this).find('input[type="checkbox"]').attr("checked") != 'checked') {
            $(this).find('input[type="checkbox"]').attr("checked", "checked");
        } else {
            $(this).find('input[type="checkbox"]').removeAttr("checked");
        }
    });

    $('.book-filter-clear').on('click', function () {
        let form = $('form[name="book_filter"]');
        form.find('input[type="checkbox"]').each(function () {
            $(this).removeAttr("checked");
        });
        form.find('li').each(function () {
            $(this).removeClass('active');
        });
        form.submit();
    })
});
