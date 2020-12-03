<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$book->name}}</title>
    <script type="text/javascript">
        var page = 1;
        window.addEventListener("message", message => {
            if (message.data.text === 'setting') {
                document.showBookReaderSettings();
            }
            if (message.data.text === 'setting_close') {
                document.hideBookReaderSettings();
            }
            if (message.data.text === 'init') {
                page = message.data.page;
            }
        });
        document.showBookReaderSettings = function(){
            document.getElementById('book-settings').style.display = 'block';
        };
        document.hideBookReaderSettings = function(){
            document.getElementById('book-settings').style.display = 'none';
        };
        function setReadPage(element){
            let currentPage = element.parentElement.getAttribute('data-page');
            page = currentPage;
            console.log(page);
            if(typeof window.ReactNativeWebView !== 'undefined') {
                window.ReactNativeWebView.postMessage(
                    JSON.stringify({  "page": page }));
            }
        }

        document.addEventListener("DOMContentLoaded", function(event) {

        });


        function checkVisible(elm) {
            var rect = elm.getBoundingClientRect();
            var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
            return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
        }
    </script>
</head>
<body>
    <style type="text/css">
        .book_content{
            position: relative;
        }
        #book-settings{
            text-align: center;
            position: fixed;
            background: #c0c0c0;
            height: 40%;
            left: 0;
            right: 0;
            bottom: 0;
            font-size: 22px;
            padding: 15px;
            display: none;
        }
    </style>
    <div class="book_content">
        <div id="book-settings">
            Настройки <div id="book-settings-close" onclick="document.hideBookReaderSettings()">[закрыть]</div>
        </div>
        @foreach($book_pages as $k=>$page)
            <div id="page_{{$page->page}}" data-page="{{$page->page}}" class="page">
                {!! str_replace(['<body>', '</body>'],'',$page->content) !!}
                <button onclick="setReadPage(this)">сохранить старницу</button>
                <hr>
            </div>
        @endforeach
    </div>
</body>
</html>