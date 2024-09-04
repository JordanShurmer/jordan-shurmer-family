<!DOCTYPE html>
<html>
    <head>

        <?php

        class Page {
            public string $hero_image = "";
            public string $title = "";
        }
        $page = new Page();
        $page->hero_image = "/static/heroes/pen.jpg";
        $page->title = "Theology";

        include("global_head.php")

        ?>

    </head>

    <body class="">


        <?php include("header.php") ?>

        <main id="main">

            <h1>Theology Notes</h1>
            <p>Some of my notes and musings on theological topics can be found here</p>

            <ul>
                <li><a href="god/sovereignty.md">God's sovereignty</a></li>
                <li><a href="atonement.md">The Atonement</a></li>
                <li><a href="baptism.md">Baptism</a></li>
                <li><a href="regeneration.md">Regeneration</a></li>
                <li><a href="conversions-in-acts.md">Church Growth in Acts</a></li>
                <li><a href="god/gods-two-wills.md">God's two wills?</a></li>
            </ul>


        </main>

        <section id="footer">

            <span>Built by <a target="_blank" href="https://aule.technology">Aulë Tech</a></span>

        </section>




    </body>

</html>
