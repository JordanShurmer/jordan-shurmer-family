const ESV_TEXT_ONLY = {
    'include-passage-references': false,
    'include-verse-numbers': false,
    'include-first-verse-numbers': false,
    'include-footnotes': false,
    'include-footnote-body': false,
    'include-headings': false,
    'include-chapter-numbers': false,
    'include-audio-link': false
}

function loadReferenceText(referenceElement) {
    const reference = referenceElement.textContent;
    const textElement = referenceElement.nextElementSibling;
    //no <dd> for this <dt> let's fetch it!
    if (textElement.classList.contains('loading')) {
        const params = new URLSearchParams({...ESV_TEXT_ONLY, q: referenceElement.textContent});
        console.debug(`fetching ${referenceElement.textContent}`);
        return fetch('https://api.esv.org/v3/passage/html/?'+params.toString(), {
            method: 'GET',
            headers: new Headers({'Authorization': 'Token a0e122c0b20aee5601d9a6ea50e16194f5131eda'})
        })
            .then(response => {
                return response.json();
            })
            .then(esvJson => {
                const theText = esvJson.passages.join('');
                textElement.classList.remove('loading');
                textElement.innerHTML = `${theText} <small><a href="//esv.to/${encodeURIComponent(esvJson.query)}" target="_blank">see context</a></small>`;
                smallifyLORD(textElement);
                console.debug({esvJson, theText, textElement, referenceElement});
            });
    } else {
        return Promise.resolve()
    }
}


function smallifyLORD(node) {
    node.innerHTML = node.innerHTML.replace(/LORD/g, 'L<small>ORD</small>');
}

function smallifyAllLORD() {
    document.querySelectorAll('p, dd')
        .forEach(smallifyLORD);
}

function toggleReferenceText(reference, expand) {
    let sibling = reference.nextElementSibling;

    //Add a delay before expanding, to alleviate the loading flash
    setTimeout(() => {
        console.debug("expanding a reference", {reference, expand, sibling});
        reference.classList.toggle('expanded', expand);
        //Loop over all nextSibling <dd> elements
        for (let sibling = reference.nextElementSibling; sibling !== null && "DD" === sibling.tagName; sibling = sibling.nextElementSibling) {
            sibling.classList.toggle('visible', expand);
        }
    }, 175);
}

function clickifyScripture() {

    document.querySelectorAll('dl.scripture')
        .forEach((scriptureList) => {

            //add the loading-state <dd> elements
            scriptureList.querySelectorAll('dt')
                .forEach((reference) => {
                    const textElement = reference.nextElementSibling;
                    if (textElement === null || "DD" !== textElement.tagName) {
                        reference.insertAdjacentHTML('afterend', `<dd class="loading"><p>loading&hellip;</p></dd>`);
                    }
                });

            //fetch the verse on mousedown, toggle the display on mouseup
            scriptureList.addEventListener('mousedown', (event) => {
                //only responde to left mouse click
                if (event.button === 0) {

                    //if a reference text is clicked
                    if ("DT" === event.target.tagName) {
                        loadReferenceText(event.target);
                    }

                    //this means the 'expand all' text is clicked
                    if (scriptureList === event.target) {
                        scriptureList.classList.toggle('expanded');
                        scriptureList.querySelectorAll('dt')
                            .forEach((reference) => {
                                loadReferenceText(reference);
                            });
                    }
                }
            });

            //using 'mouseup' here so that selection text within the dl doesn't trigger the 'expand all' click
            scriptureList.addEventListener('mouseup', (event) => {
                //only responde to left mouse click
                if (event.button === 0) {

                    //if a reference text is clicked
                    if ("DT" === event.target.tagName) {
                        toggleReferenceText(event.target);
                    }

                    //this means the 'expand all' text is clicked
                    if (scriptureList === event.target) {
                        scriptureList.classList.toggle('expanded');
                        scriptureList.querySelectorAll('dt')
                            .forEach((reference) => {
                                toggleReferenceText(reference, scriptureList.classList.contains('expanded'))
                            });
                    }

                }
            });
        });
}

/**
 * Clone the Table of Contents to create the fixed one (i.e. the left-rail
 * on desktop, bottom drawer on mobile)
 **/
function cloneTOC() {
    const TOC = document.getElementById("toc");
    if (TOC) {
        console.debug("cloning TOC", {TOC});
        let fixedTOC = TOC.cloneNode(true);
        fixedTOC.id = "fixed-toc";
        console.debug("cloned TOC", {TOC, fixedTOC});
        fixedTOC = TOC.insertAdjacentElement("beforebegin", fixedTOC);
        fixedTOC.classList.add("fixed");

        //Add the floating action button to toggle the TOC
        fixedTOC.insertAdjacentHTML("beforebegin", `<button id="fab"><i class="icon-up-open-big"></i></button>`);
        const fab = document.getElementById("fab");
        fab.addEventListener('click', (event) => {
            fixedTOC.classList.toggle("toggled");
            if (fixedTOC.classList.contains("toggled")) {
                fab.innerHTML = `<i class="icon-down-open-big"></i>`;
            } else {
                fab.innerHTML = `<i class="icon-up-open-big"></i>`;
            }
        });

    }
}

function fixedTOCAvailability(event) {
    const fixedTOC = document.getElementById("fixed-toc");
    const fab = document.getElementById("fab");
    const tocBounds = document.getElementById("toc").getBoundingClientRect()
    if (tocBounds.top < 0 && tocBounds.bottom < (tocBounds.height/3)) {
        fixedTOC.classList.add("available");
        fab.classList.add("available");
    } else {
        fixedTOC.classList.remove("available");
        fab.classList.remove("available");
    }
}

/**
 *
 * MAIN
 *
 * **/
clickifyScripture();
smallifyAllLORD();
cloneTOC();
window.addEventListener('scroll', fixedTOCAvailability);

