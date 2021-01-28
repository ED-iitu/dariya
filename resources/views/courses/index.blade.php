<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('courses.styles');
    @include('courses.scripts');
    <title>Курсы</title>
    <style type="text/css">
        #page-content {
            font-family: SF UI Display;
            text-shadow: none;
            background-color: #FFFFFF;
        }


        .ui-tabs-panel {
            height: 80%;
            overflow-y: auto !important;
            padding: 16px 0px;
        }

        @media (min-width: 28em) {
            .ui-field-contain > label ~ [class*=ui-], .ui-field-contain .ui-controlgroup-controls {
                width: 100%;
            }

            .ui-field-contain > label, .ui-field-contain .ui-controlgroup-label, .ui-field-contain > .ui-rangeslider > label {
                width: 100%;
                margin: .5em 2% .5em 0;
            }
        }

        .card {
            padding: 0px;
            margin-right: 2px;
            margin-bottom: 15px;
            margin-left: 2px;
            overflow: hidden;
            background: #FFFFFF;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
        }

        .card h3 {
            margin: 0px;
            padding: 10px;
            padding-bottom: 0px;
        }

        .card p {
            margin: 0px;
            padding: 10px;
        }

        .card-image {
            width: 100%;
            height: 20em;
            padding: 0px;
            margin: 0px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #ccc;
            position: relative;
            overflow: hidden;
        }

        .card-image h1,
        .card-image h2,
        .card-image h3,
        .card-image h4,
        .card-image h5,
        .card-image h6 {
            position: absolute;
            bottom: 0px;
            width: 100%;
            color: white;
            background: rgba(0, 0, 0, 0.65);
            margin: 0px;
            padding: 6px;
            border: none;
        }

        div.holoPressEffectDiv {
            background-color: #CCCCCC;
        }

        .ui-header, .ui-footer {
            background-color: #FFFFFF !important;
            border: 0 !important;
        }

        .ui-input-text, .ui-input-search {
            margin: 1em;
            background: #ededed !important;
            border: 0;
        }

        .ui-shadow-inset {
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }

        .ui-navbar {
            margin: 0.5em 1em;
        }

        #navbar li:first-child .ui-btn {
            border-radius: 5px 0px 0px 5px;
        }

        #navbar li:last-child .ui-btn {
            border-radius: 0px 5px 5px 0px;
            margin-right: 0px;
        }

        #tabs .ui-content {
            padding: 0;
        }

        .detail-image {
            position: relative;
            height: 20em;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .detail-image h2 {
            position: absolute;
            bottom: 0;
            background-color: rgba(1, 1, 1, 0.5);
            left: 0;
            right: 0;
            margin: 0;
            text-shadow: none;
            color: #FFFFFF;
            padding: 10px 20px;
        }

        .detail-content {
            padding: 10px 20px;
        }

        .detail-content .ui-navbar {
            margin: 0;
        }

        .detail-content h3 {
            color: #00D1FF;
        }

        .detail-content p {
            font-size: 18px;
            color: black;
        }

        .close-btn {
            background-color: #FFFFFF !important;
            border: none;
            box-shadow: none;
            margin: 0 !important;
            padding: 10px 25px;
            color: #007AFF !important;
            font-size: 14px!important;
            font-weight: 100!important;
        }

        .close-btn:after {
            content: '';
            height: 14px;
            background-color: #007AFF;
            width: 3px;
            position: absolute;
            transform: rotate(-45deg);
            left: 10px;
            top: 14px;
            border-radius: 0 0px 5px 5px;
        }

        .close-btn:before {
            content: '';
            height: 14px;
            background-color: #007AFF;
            width: 3px;
            position: absolute;
            transform: rotate(45deg);
            left: 10px;
            top: 6px;
            border-radius: 5px 5px 0 0;
        }

        .courses ul {
            margin: 0;
            padding: 0;
        }

        .courses ul li {
            list-style-type: none;
            background-color: #ddd;
            margin-bottom: 10px;
            position: relative;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            border-radius: 15px;
        }
        .courses ul li.finished:after{
            content: '';
            height: 9px;
            background-color: #007AFF;
            width: 3px;
            position: absolute;
            transform: rotate(
                    -43deg
            );
            right: 22px;
            top: 23px;
            border-radius: 0 0px 5px 5px;
        }
        .courses ul li.finished:before{
            content: '';
            height: 16px;
            background-color: #007AFF;
            width: 3px;
            position: absolute;
            transform: rotate(
                    35deg
            );
            top: 16px;
            right: 15px;
            border-radius: 5px 5px 0 0;
        }
        .courses ul li a{
            display: block;
            width: 100%;
            height: 100%;
            padding: 10px 30px;
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }
        .lesson-content {
            margin-top: 2.5em;
            padding: 20px;
        }

        #lesson .btn {
            width: 86%;
            background-color: #007AFF;
            color: #FFFFFF;
            text-shadow: none;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div data-role="page" id="home" data-theme="a" data-fullscreen="true">
    @if(\Illuminate\Support\Facades\Auth::check())
        <input type="hidden" name="course_key" value="{{\Illuminate\Support\Facades\Auth::user()->course_key}}">
    @endif
    <div data-role="header" data-position="fixed">
        @if(\Illuminate\Support\Facades\Auth::check())
            <label for="search-4" class="ui-hidden-accessible">Search Input:</label>
            <input type="search" name="search-4" id="search-4" value="" placeholder="Курсы, уроки ил по авторам ...">
        @endif
            <div data-role="navbar" id="navbar" data-iconpos="top">
                <ul>
                    <li><a href="#one" data-ajax="false" class="tabButton">Общие курсы</a></li>
                    <li><a href="#two" data-ajax="false" class="tabButton">Мои курсы</a></li>
                </ul>
            </div>
    </div>
    <div data-role="main" id="page-content" class="ui-content" data-theme="a" data-full="false">
        <div data-role="tabs" id="tabs">
            <div id="one" class="ui-body-d ui-content tabView">
                @foreach($courses as $course)
                    <div class="card course" data-page="#detail_{{ $course->id }}">
                        <div class="card-image" style="background-image: url({{ url($course->image_link) }});">
                        </div>
                        <h3>{{ $course->name }}</h3>
                        <p>{{ $course->author }}</p>
                    </div>
                @endforeach
            </div>
            <div id="two" class="tabView">
                @if(\Illuminate\Support\Facades\Auth::check())
                    @foreach($my_courses as $course)
                        <div class="card course" data-page="#detail_{{ $course->id }}">
                            <div class="card-image" style="background-image: url({{ url($course->image_link) }});">
                            </div>
                            <h3>{{ $course->name }}</h3>
                            <p>{{ $course->author }}</p>
                        </div>
                    @endforeach
                @else
                    <p>Чтобы получить доступ к курсам авторизуйтесь!</p>
                @endif
            </div>
        </div>

    </div>
</div>
@php
   $courses = $courses->merge($my_courses);
@endphp
@foreach($courses as $course)
    <div data-role="page" id="detail_{{ $course->id }}" data-theme="a">
        <div data-role="header" data-fullscreen="true">
            <a href="#" id="close-detail" class="close-btn">Назад</a>
            <h1>{{ $course->name }}</h1>
        </div>
        <div data-role="main" id="page-detail_{{ $course->id }}" class="ui-content" data-theme="a">
            <div class="detail-image" style="background-image: url({{ url($course->image_link) }});">
            </div>
            <div class="detail-content">
                <div data-role="tabs" id="detail-tabs">
                    <div data-role="navbar">
                        <ul>
                            <li><a href="#courses-{{ $course->id }}" data-ajax="false" style="-webkit-border-radius: 15px 0 0 15px;-moz-border-radius: 15px 0 0 15px;border-radius: 15px 0 0 15px;">Уроки</a></li>
                            <li><a href="#course-info-{{ $course->id }}" data-ajax="false" style="-webkit-border-radius: 0px 15px 15px 0;-moz-border-radius: 0px 15px 15px 0;border-radius: 0px 15px 15px 0;">Информация</a></li>
                        </ul>
                    </div>
                    <div id="courses-{{ $course->id }}" class="courses ui-body-d ui-content">
                        <p>Завершено {{ $course->getFinishedCount() }} из {{ $course->lessons()->count() }}</p>
                        <ul>
                            @foreach($course->lessons as $lesson)
                                @php
                                $url = '/api/courses/lesson/' . $lesson->id;
                                if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->course_key){
                                    $url .= '?course_key=' . \Illuminate\Support\Facades\Auth::user()->course_key;
                                }
                                @endphp
                                <li class="view-lesson @if($lesson->is_finished()) finished @endif" data-lesson-id="{{ $lesson->id }}">
                                    <a href="{{ $url }}">{{ $lesson->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="course-info-{{ $course->id }}" class="course-info">
                        {!! $course->description !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach
<script type="text/javascript">
    $(document).on("pagecreate", "#home", function () {
        //start with only viewone visible
        $(".tabButton").removeClass("ui-btn-active");
        $(".tabView").hide();
        $(".tabButton").eq(0).addClass("ui-btn-active");
        var viewHref = $(".tabButton").eq(0).prop("href");
        $(viewHref.substr(viewHref.indexOf('#'))).show();

        $(".tabButton").on("click", function () {
            $(".tabButton").removeClass("ui-btn-active");
            $(".tabView").hide();
            var href = $(this).prop("href");
            $(href.substr(href.indexOf('#'))).show();
            $(this).addClass("ui-btn-active");
            return false;
        });
    });
    var b = $('body');
    b.on('click', '.close-btn', function () {
        let activePageId = $.mobile.activePage.attr('id');
        if (activePageId === 'home') {
            if (typeof window.ReactNativeWebView !== 'undefined') {
                window.ReactNativeWebView.postMessage(JSON.stringify({"action": "close"}));
            }
        } else {
            $.mobile.back();
        }
    });
    b.on('click', '.show-tariff', function () {
        if (typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(JSON.stringify({"action": "pay"}));
        }
    });
    document.addEventListener("message", message => {
        var event = JSON.parse(message.data);
        if (event.action === 'back') {
            let activePageId = $.mobile.activePage.attr('id');
            if (activePageId === 'home') {
                if (typeof window.ReactNativeWebView !== 'undefined') {
                    window.ReactNativeWebView.postMessage(JSON.stringify({"action": "close"}));
                }
            } else {
                $.mobile.back();
            }
        }
    });
    $(".course").on("click", function (event) {
        event.preventDefault();
        $.mobile.navigate($(this).data('page'));
        // alterContent( this.attr( "href" ) );
    });
    b.on("click", ".finish-lesson", function (event) {
        let lesson_id = $(this).data('lesson-id');
        let course_key = $('input[name="course_key"]').val();
        if(course_key.length > 0){
            lesson_id = lesson_id + '?course_key=' + course_key;
        }
        //let token = $(this).closest('.row').find('input[name="_token"]').val();
        $.post('/api/courses/finish_lesson/' + lesson_id, function (data) {
            location.reload();
            $.mobile.back();
        });
    });
</script>
</body>
</html>