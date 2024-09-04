<section id="site-header">
    
        <!-- A div for the "hero" section.. the large visual at the top -->
        <div id="hero">
            <a href="/">
                
            <img src="<?= $page->hero_image ?: "/static/heroes/default.jpg" ?>" alt="Home"/>
                
                <h1>JS</h1>
            </a>
        </div>

        <!-- A nav for the site navigation -->
        <nav>
            <ul>
            <li class="<?= active('/theology') ?>">
                    <a href="/theology">Theology</a>
                </li>
                <li class="<?= active('/dev') ?> ">
                    <a href="/dev">Software</a>
                </li>
                <li class="<?= active('/media') ?> ">
                    <a href="/media">Media</a>
                </li>
                <li class="<?= active('/me') ?> ">
                    <a href="/me">About</a>
                </li>
            </ul>
        </nav>
    
</section>

<?php
function active($section) {
    echo str_starts_with($_SERVER['REQUEST_URI'], $section) ? 'active' : '';
}
?>
