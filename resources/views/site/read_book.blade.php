<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$book->name}}</title>
    <script type="text/javascript">
        document.showBookReaderSettings = function(){
            document.getElementById('book-settings').style.display = 'block';
        };
        document.hideBookReaderSettings = function(){
            document.getElementById('book-settings').style.display = 'none';
        };
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
        @foreach($book_pages as $page)
            {!! str_replace(['<body>', '</body>'],'',$page->content) !!}
            <hr>
        @endforeach
    </div>
</body>
</html>