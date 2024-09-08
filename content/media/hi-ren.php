<?php
include "init.php";
$page->title = "Hi Ren";
$page->wip = true;
?>
<?php ob_start() ?>

<article itemscope itemtype="https://schema.org/Article">

    <h1 itemprop="headline name">Hi Ren</h1>


    <section itemprop="articleBody">
        <p>Watch <a href="https://www.youtube.com/watch?v=s_nc1IVoMxc">the video</a></p>
        <p>Then, watch <a href="https://www.youtube.com/watch?v=s_nc1IVoMxc">the video</a> twice.</p>
        <p>5 parts</p>
        <ol>
            <li>the dance</li>
            <li>the battle</li>
            <li>fear and hope</li>
            <li>the dance again</li>
            <li>the monologue</li>
        </ol>
        <p>In the monoluge Ren explains his view on the old battle of good vs evil. He says that he used to think of it like a battle, like david vs goliath, inside himself. Now he views it more like a dance.</p>
        <p>You can see these ideas play out through thte course of the song.</p>
        <p>The falcetto voice represents him embracing the &quot;dance&quot; aspect.</p>
        <p>The lyrical part shows the battle aspect. The good voice starts calm and clear, countering every criticism with its own valid remarks. As they progress, however, the calm voice becomes more intense and ends up loosing all control with descriptive threats of death and lossing the ability to speak clearly.</p>

    </section>
</article>

<?php $main = ob_get_clean() ?>

<?php include "layout.php" ?>
