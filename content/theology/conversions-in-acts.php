<?php
include "init.php";
$page->title = "Conversions in Acts";

?>
<?php ob_start() ?>
<article itemscope itemtype="https://schema.org/Article">


    <h1 itemprop="headline name">Conversions in Acts</h1>


    <div id="metadata">


    </div>

    <p itemprop="description">
        List of conversions in the book of Acts
    </p>




    <section itemprop="articleBody">
        <p><scripture-list
            api="crosswayApi"
            reference-list='[&quot;Acts 2:37–41&quot;,&quot;Acts 3:19–20, 4:4&quot;,&quot;Acts 5:12–14&quot;,&quot;Acts 6:7&quot;,&quot;Acts 8:12–13&quot;,&quot;Acts 8:35–38&quot;,&quot;Acts 9:17–19&quot;,&quot;Acts 9:31&quot;,&quot;Acts 9:32–35&quot;,&quot;Acts 9:40–42&quot;,&quot;Acts 10:43–48, 11:13-18,15:7–11&quot;,&quot;Acts 11:21–24&quot;,&quot;Acts 13:7–12&quot;,&quot;Acts 13:38,43&quot;,&quot;Acts 13:47–49&quot;,&quot;Acts 14:1&quot;,&quot;Acts 16:4–5&quot;,&quot;Acts 16:13–15&quot;,&quot;Acts 16:29–34&quot;,&quot;Acts 17:2–4&quot;,&quot;Acts 17:10–12&quot;,&quot;Acts 17:32–34&quot;,&quot;Acts 18:8&quot;]'></scripture-list></p>

    </section>
</article>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
