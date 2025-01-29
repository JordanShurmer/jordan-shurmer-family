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

    a { color: inherit; }

    .container {
        max-width: 72ch;
        margin-block: 2ch;
        margin-inline: auto;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        background-color: var(--bg-color);
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    header h1 {
        margin: 0;
        font-size: 2em;
    }

    header p {
        margin: 5px 0;
    }

    section {
        margin-bottom: 20px;
    }

    section h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
        border-bottom: 2px solid #333;
        padding-bottom: 5px;
    }

    section p, section ul {
        margin: 0 0 10px 0;
    }

    ul {
        padding-left: 20px;
    }

    ul li {
        margin-bottom: 5px;
    }

    .contact-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .contact-info div {
        margin-bottom: 10px;
        flex: 1 1 45%;
    }

    @media (max-width: 600px) {
        .contact-info div {
            flex: 1 1 100%;
        }
    }
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

            <h1 class="mono">Jordan Shurmer</h1>

            <ul>
                <style>
                me { list-style: none;   margin: 1ch 0;  padding: 0; }
                me { text-align: center; line-height: 1; }
                </style>
                <li>Software Development.</li>
                <li>
                    &lt;<a href="mailto:resume@shurmer.family">resume@shurmer.family</a>&gt;
                </li>
            </ul>

        </header>

        <section>
            <blockquote>
                <style> me { text-align: justify } </style>

                the delight and pride of Aulë is in the deed of making, and in the 
                thing made, and neither in possession nor in his own mastery.
                <br><cite> &mdash; The Silmarillion by J.R.R Tolkien</cite>
            </blockquote>
        </section>

        <section>

            <h2>Who Am I</h2>

            <p>

                An experienced software engineer, application architect, and tinkerer.
                I have done Software Development in various capicities for over 12 years.

            </p>

        </section>

        <section>
            <h2>Work Experience</h2>

            <p>
                <strong>Software Engineer</strong> - Warner Bros. Discovery (June 2012 - Present)
            </p>

            <style>
            me p:not(:first-of-type) {padding-inline: 1ch;}
            me p:not(:first-of-type) {text-align: justify;}
            me p:not(:first-of-type) { margin-block-end: 3ch; }

            me ul { margin: 2ch; }
            </style>


            <p>

                I have had the joy of working here for over a decade doing Full-Stack
                web development in many different environments. I have created succesful
                projects from scratch, created failing projects from scratch, maintained
                decades old projects, decommessioned projects, mentored other engineers,
                advised other teams, scaled applications horizontally and vertically, and
                generally try to improve things that I can get my hands on.

            </p>

            <p>

                Some languages and frameworks I am comfortable with:

                <ul>
                    <li>The web (i.e. HTML, CSS, Javascript, and HTTP)</li>
                    <li>Java</li>
                    <li>HTMX</li>
                    <li>React, Svelte, <strong>and</strong> Vue</li>
                    <li>Kotlin</li>
                    <li></li>
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
                            photo galleries</a>)
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
            <h2>Education</h2>
            <ul>
                <li><strong>Bachelor of Science in Computer Science</strong> - University of Example (2012 - 2016)</li>
            </ul>
        </section>

        <section>
            <h2>Skills</h2>
            <ul>
                <li>Programming Languages: JavaScript, Python, Java</li>
                <li>Frameworks: React, Django, Node.js</li>
                <li>Tools: Git, Docker, Jenkins</li>
            </ul>
        </section>

        <section>
            <h2>Contact</h2>
            <div class="contact-info">
                <div><strong>Email:</strong> john.doe@example.com</div>
                <div><strong>Phone:</strong> (123) 456-7890</div>
                <div><strong>LinkedIn:</strong> linkedin.com/in/johndoe</div>
                <div><strong>GitHub:</strong> github.com/johndoe</div>
            </div>
        </section>
    </div>
</body>
