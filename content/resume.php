<?php
include "init.php";
$page->title = "Resume";
?>

<head>

    <meta charset="utf-8"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/static/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/favicon/favicon-16x16.png">
    <link rel="manifest" href="/static/favicon/site.webmanifest">

    <title>Jordan Shurmer&apos;s Resume</title>

    <style>
    @import 'theme.css';
    body {
        font-family: 'Berkeley Mono', monospace, monospace, sans-serif;
        margin: 0;
        padding: 0;
        color: var(--color);
        background-color: var(--bg-alt);
    }


    .container {
        max-width: 72ch;
        margin-block: 2ch;
        margin-inline: auto;
        padding: 2ch;
        border-radius: 1ch;
        background-color: var(--bg-color);
    }

    section { margin-block-end: 1.5em; }

    h2 { border-bottom: 2px solid rgb(from var(--color) r g b /  0.5); }

    p, blockquote { text-align: justify; }

    cite { font-style: inherit; }

    a { color: inherit; }
    a[href*=mailto] { text-decoration: none; }

    </style>


    <script>
// 🌘 CSS Scope Inline (https://github.com/gnat/css-scope-inline)
window.cssScopeCount ??= 1 // Let extra copies share the scope count.
window.cssScope ??= new MutationObserver(mutations => { // Allow 1 observer.
    document?.body?.querySelectorAll('style:not([ready])').forEach(node => { // Faster than walking MutationObserver results when recieving subtree (DOM swap, htmx, ajax, jquery).
        var scope = 'me__'+(window.cssScopeCount++) // Ready. Make unique scope, example: .me__1234
        node.parentNode.classList.add(scope)
        node.textContent = node.textContent
            .replace(/(?:^|\.|(\s|[^a-zA-Z0-9\-\_]))(me|this|self)(?![a-zA-Z])/g, '$1.'+scope) // Can use: me this self
            .replace(/((@keyframes|animation:|animation-name:)[^{};]*)\.me__/g, '$1me__') // Optional. Removes need to escape names, ex: "\.me"
            .replace(/(?:@media)\s(xs-|sm-|md-|lg-|xl-|sm|md|lg|xl|xx)/g, // Optional. Responsive design. Mobile First (above breakpoint): 🟢 None sm md lg xl xx 🏁  Desktop First (below breakpoint): 🏁 xs- sm- md- lg- xl- None 🟢 *- matches must be first!
                (match, part1) => { return '@media '+({'sm':'(min-width: 640px)','md':'(min-width: 768px)', 'lg':'(min-width: 1024px)', 'xl':'(min-width: 1280px)', 'xx':'(min-width: 1536px)', 'xs-':'(max-width: 639px)', 'sm-':'(max-width: 767px)', 'md-':'(max-width: 1023px)', 'lg-':'(max-width: 1279px)', 'xl-':'(max-width: 1535px)'}[part1]) }
            )
        node.setAttribute('ready', '')
    })
}).observe(document.documentElement, {childList: true, subtree: true})
    </script>
</head>

<body>
    <div class="container">

        <header>
            <style>
            this { text-align: center; }
            this h1 { margin: 0; }
            </style>

            <h1 class="mono">Jordan Shurmer</h1>

            <ul>

                <style>
                this { list-style: none; margin: 1ch 0; padding: 0; }
                </style>

                <li>Software Development.</li>
                <li>
                    &lt;<a href="mailto:resume@shurmer.family">resume@shurmer.family</a>&gt;
                </li>
            </ul>

        </header>

        <section>
        </section>

        <section>

            <h2>Who Am I</h2>

            <p>

                A software engineer, application architect, and tinkerer.
                I have done Software Development in various capicities for over 12 years.
                I am also a father of 4 and husband of 1.

            <blockquote>
                <style>this { padding-inline: 4ch; }</style>
                <em>the delight and pride of Aulë is in the deed of making, and in the 
                    thing made, and neither in possession nor in his own mastery.</em>
                <br><cite><strong> &mdash; The Silmarillion</strong> by J.R.R Tolkien</cite>
            </blockquote>

        </section>

        <section>
            <h2>Work Experience</h2>

            <p>
                <strong>Software Engineer</strong> - Warner Bros. Discovery (June 2012 - Present)
            </p>

            <style>
            this p:not(:first-of-type) {padding-inline-start: 3ch;}
            this ul {padding-inline-start: 6ch;}
            this p:not(:first-of-type) { margin-block-end: 3ch; }

            this ul { margin: 2ch; }
            </style>


            <p>

                I have had the joy of working here for over a decade doing Full-Stack
                web development in many different environments. I have created succesful
                projects from scratch, created failing projects from scratch, maintained
                decades old projects, decommessioned projects, mentored other engineers,
                advised other teams, scaled applications horizontally and vertically, and
                generally try to improve everything that I can get my hands on.

            </p>

            <p>

                Some languages and frameworks I have developed with:

                <ul>
                    <li>The web (i.e. HTML, CSS, Javascript, and HTTP)</li>
                    <li>Java</li>
                    <li>HTMX</li>
                    <li>React, Svelte, <strong>and</strong> Vue</li>
                    <li>Kotlin</li>
                    <li>Make, Maven, Grunt, Gulp, Webpack, Rollup, Gradle, and other build systems</li>
                    <li>Bash, zsh, <strong>and</strong> pwsh</li>
                    <li>Apache Sling</li>
                    <li>Function-based routing frameworks (e.g Express JS)</li>
                    <li>File-based routing frameworks (e.g. SvelteKit)</li>
                    <li>MySQL, and Oracle SQL</li>
                    <li>AWS S3, Lambda, DynamoDB, EC2, Cloud*, Route53, &hellip;</li>
                    <li>Ruby on Rails</li>
                </ul>

            </p>

            <p>

                Some projects I have worked on:

                <ul>

                    <li>popular website
                        (e.g. <a href="https://www.hgtv.com">hgtv.com</a>,
                        <a href="https://www.food.com">food.com</a>,
                        <a href="https://www.discovery.com">discovery.com</a>)
                    </li>
                    <li>JSON APIs for web and mobile</li>
                    <li>internal tools for non-developers</li>
                    <li>user generated content workflows</li>
                    <li>internal tools for developers</li>
                    <li>Hypermedia APIs (e.g. dynamically loading
                        <a href="https://www.hgtv.com/design/ultimate-house-hunt/2023/countryside-retreats/historic-asheville-home">
                            photo</a>
                        <a href="https://www.foodnetwork.com/recipes/photos/prime-rib-recipes">
                            galleries</a>)
                    </li>
                    <li>continuous deployment piplines</li>
                    <li>technical documentation</li>
                    <li>custom Content Management Systems</li>
                    <li>declarative data fetching apis</li>
                    <li>3rd party integrations of various kinds</li>
                    <li>etc.</li>
                </ul>

            </p>
        </section>

        <section>
            <h2>Other Work &amp; Side Projects</h2>

            I spend some of my free time tinkering with all kinds of software.

            Here are a few completed examples:

            <ul>
                <li><a href="https://jordan.shurmer.family">jordan.shurmer.family</a>:
                    a handcrafted nginx/php website
                </li>
                <li>Various <a href="https://solidproject.org/about">SoLiD</a> projects
                    (e.g. <a href="https://github.com/JordanShurmer/vue-solid-plugin">vue-solid-plugin</a>)
                </li>
                <li>Eleventy plugin for <a href="https://github.com/JordanShurmer/eleventy-plugin-nesting-toc">
                    nested table of contents</a>
                </li>
                <li>A Noita <a href="https://gitlab.com/jshurmer/noita-hitless-runs-mod">
                    mod</a> for attempting a hitless run</li>
                <li>Making <a href="https://git.sr.ht/~jshurmer/the-game">
                    a game<a> from scratch using Odin and Raylib</li>

            </ul>

        </section>


        <section>
            <h2>Education</h2>
            <ul>
                <li><strong>Bachelor of Science in Computer Science</strong> - University of Tennessee</li>
            </ul>
        </section>

        <p><small>I use neovim btw&hellip;</small></p>

    </div>
</body>
