<?php
include "init.php";
$page->title = "Good and Angry";
$page->wip = true;
?>
<?php ob_start() ?>

<article itemscope itemtype="https://schema.org/Article">


    <h1 itemprop="headline name">Good and Angry</h1>


    <div id="metadata">


    </div>

    <p itemprop="description">

    </p>




    <section itemprop="articleBody">
        <blockquote>
            <p>anger is the emotion of &quot;I stand against that&quot;</p>
        </blockquote>
        <p>I used to not get anger, but it was because I used to not stand against anything</p>

    </section>
</article>





<!-- Load the crossway API (or provide your own, see below) -->
<script src="https://cdn.jsdelivr.net/npm/web-components-scripture@1/crossway.js"></script>
<script>
//create the 'crosswayApi' object being referenced
const crosswayApi = new Crossway('a0e122c0b20aee5601d9a6ea50e16194f5131eda');
</script>
<!-- Load the web components -->
<script src="https://cdn.jsdelivr.net/npm/web-components-scripture@1/scripture.js"></script>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
