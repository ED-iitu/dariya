<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <title>Document</title>
</head>
<body>
<div data-role="page" id="home" data-theme="a" data-fullscreen="true">
    <div data-role="main" class="ui-content" data-theme="a">
        <div id="page-1">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, ad commodi cupiditate deleniti dolor fugit
            id ipsam necessitatibus nostrum numquam provident, quae quidem quo totam voluptatum! Asperiores delectus
            eum iste natus nemo nihil praesentium quasi. Doloribus harum non quos vero. Aliquid aspernatur beatae
            blanditiis consequuntur cumque dignissimos distinctio dolorem doloremque eum excepturi expedita, fugiat
            hic incidunt ipsa iste iusto maiores maxime minima necessitatibus nesciunt, numquam placeat quas quia
            ratione repudiandae ut veniam vitae! Ab aliquam animi aperiam beatae cumque doloribus ea eius enim eum
            fugit impedit incidunt libero modi mollitia necessitatibus neque nobis obcaecati odio officiis perspiciatis
            placeat quaerat quas qui quia quo, recusandae repellendus sed sunt, tempore vel veniam veritatis voluptatem
            voluptatibus! Deleniti excepturi odio quos. Aspernatur, corporis ducimus facilis illo impedit inventore
            minus modi, nihil, nobis officiis tempore tenetur voluptate. Autem eius facilis iusto labore sit!
            Cupiditate dignissimos eaque illum laudantium nostrum officiis pariatur quis repellendus! Accusantium amet
            asperiores autem hic maxime, necessitatibus possimus quas quasi unde ut? Aliquam cupiditate et laboriosam libero
            odio tempora velit voluptate? Ab architecto, at atque aut autem cupiditate facilis fugiat impedit ipsa iure
            maiores maxime modi mollitia nemo nesciunt obcaecati odit perspiciatis quia quidem quos rerum sit temporibus
            velit! Accusamus consequuntur distinctio doloribus dolorum enim et eum, expedita facere fugit in iste iusto
            libero maiores maxime odio odit, qui rerum sed similique ullam. Ab aut consectetur cupiditate delectus eos
            explicabo facere, fugiat hic incidunt laboriosam laudantium magni minima mollitia officiis placeat possimus
            quasi repellat sit sunt tempora ullam velit vitae voluptatibus. Culpa debitis error expedita facere illo iste
            magni maxime molestias nihil nobis odio optio, reprehenderit repudiandae tenetur, voluptatem! Dolor dolorem
            doloribus eaque modi recusandae ut veritatis voluptatibus. Corporis delectus excepturi ipsam nihil vel? Eius,
            fugiat, impedit! Alias atque corporis debitis deleniti dignissimos dolores dolorum et eveniet explicabo facere
            facilis id inventore ipsum laborum maxime, minima nam nostrum nulla optio perferendis placeat porro praesentium
            quae quam quia quidem reiciendis repudiandae rerum suscipit totam. Architecto enim itaque molestias nisi
            pariatur sequi tempore? Asperiores aspernatur doloremque excepturi explicabo fugiat illum incidunt molestiae.
        </div>
        <div id="page-2">
            <h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores assumenda consectetur cum eum ipsam
                iusto maiores perferendis, quos repellendus suscipit!
            </h3>
        </div>
    </div>
    <div data-role="footer" data-id="main-menu" data-position="fixed"  data-theme="a">
        <div data-role="navbar">
            <ul>
                <li>
                    <a href="#home" data-icon="home" data-transition="slide" class="ui-btn-active ui-state-persist">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#quations" data-icon="grid" data-transition="slide">
                        Q
                    </a>
                </li>
                <li>
                    <a href="#about" data-icon="info" data-transition="slide">
                        About
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="about" data-theme="a">
    <div data-role="header" data-position="fixed" data-add-back-btn="true" data-theme="a">
        <h1>Book</h1>
    </div>
    <div data-role="main" class="ui-content" data-theme="a">
        <div data-role="tabs" id="tabs">
            <div data-role="navbar">
                <ul>
                    <li><a href="#one" data-ajax="false">one</a></li>
                    <li><a href="#two" data-ajax="false">two</a></li>
                </ul>
            </div>
            <div id="one" class="ui-body-d ui-content">
                <ul data-role="listview" data-inset="true">
                        <li><a href="home#page-1">Acura</a></li>
                        <li><a href="home#page-2">Audi</a></li>
                        <li><a href="#">BMW</a></li>
                        <li><a href="#">Cadillac</a></li>
                        <li><a href="#">Ferrari</a></li>
                </ul>
            </div>
            <div id="two">
                <h1>Second tab contents</h1>
            </div>
        </div>
    </div>
    <div data-role="footer" data-id="main-menu" data-position="fixed"  data-theme="a">
        <div data-role="navbar">
            <ul>
                <li>
                    <a href="#home" data-icon="home" data-transition="slide" class="ui-btn-active ui-state-persist">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#quations" data-icon="grid" data-transition="slide">
                        Q
                    </a>
                </li>
                <li>
                    <a href="#about" data-icon="info" data-transition="slide">
                        About
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
