<!DOCTYPE html>
<html>
    <head>
        <?php

        class Page {
            public string $hero_image = "";
            public string $title = "";
        }
        $page = new Page();
        $page->title = "Welcome";

        include("global_head.php");

        ?>
    </head>

    <body class="">

        <?php include "header.php" ?>

        <main id="main">

            <h1>Welcome</h1>
            <p>Welcome to my site. Have a look around.</p>

        </main>

        <section id="footer">

            <span>Built by <a target="_blank" href="https://aule.technology">Aulë Tech</a></span>

        </section>

    </body>

</html>
