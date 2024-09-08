<?php
include "init.php";
$page->title = "The Liberal Arts Tradition";
$page->wip = true;
?>
<?php ob_start() ?>

<article itemscope itemtype="https://schema.org/Article">


    <h1 itemprop="headline name">The Liberal Arts Tradition</h1>


    <section itemprop="articleBody">

        <p>Great overview of what Classical Education is.</p>
        <p>In particular, the chapter about Musical Education. Learning from a place of wonder rather than criticism.</p>
        <blockquote>
            <p>He that breaks a thing to find out what it is has left the path of wisdom — J.R.R. Tolkien</p>
        </blockquote>

    </section>

</article>
<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>

