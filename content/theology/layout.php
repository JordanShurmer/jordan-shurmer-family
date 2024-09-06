<!DOCTYPE html>
<html>
    <head>

        <?php

        $page->hero_image = "/static/heroes/pen.jpg";

        ?>

        <?php include "global_head.php"; ?>
    </head>

    <body class="">


        <?php include "header.php"; ?>

        <main id="main">

            <?php echo $main ?? "" ?>

        </main>

        <section id="footer">

            <span>Built by <a target="_blank" href="https://aule.technology">Aulë Tech</a></span>

        </section>




        <?php echo $body_last ?? "" ?>
    </body>

</html>
