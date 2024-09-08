<!DOCTYPE html>
<html>

    <head>
        <?php include "global_head.php"; ?>
    </head>

    <body class="">


        <?php include "header.php"; ?>


        <?php if ($page->wip): ?>
            <aside class="wip">
                <em>Note:</em> This page is a work in progress.
            </aside>
        <?php endif; ?>


        <main id="main">
            <?php echo $main ?? "" ?>
        </main>


        <section id="footer">
            <span>Built by <a target="_blank" href="https://aule.technology">Aulë Tech</a></span>
        </section>



        <?php if (isset($body_last)): ?>
            <?php echo $body_last ?>
        <?php else: ?>
            <!-- Load the crossway API (or provide your own, see below) -->
            <script src="https://cdn.jsdelivr.net/npm/web-components-scripture@1/crossway.js"></script>
            <script>
                //create the 'crosswayApi' object being referenced
                const crosswayApi = new Crossway('a0e122c0b20aee5601d9a6ea50e16194f5131eda');
            </script>
            <!-- Load the web components -->
            <script src="https://cdn.jsdelivr.net/npm/web-components-scripture@1/scripture.js"></script>
        <?php endif; ?>


    </body>

</html>
