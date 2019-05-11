function smallifyLORD(node) {
    node.innerHTML = node.innerHTML.replace(/LORD/g, 'L<small>ORD</small>');
}

function smallifyAllLORD() {
    document.querySelectorAll('p, dd')
        .forEach(smallifyLORD);
}

/**
 * Clone the Table of Contents to create the fixed one (i.e. the left-rail
 * on desktop, bottom drawer on mobile)
 **/
function cloneTOC() {
    const TOC = document.querySelector("nav.toc");
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
    const tocBounds = document.querySelector("nav.toc:not(#fixed-toc)").getBoundingClientRect();
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
smallifyAllLORD();
cloneTOC();
window.addEventListener('scroll', fixedTOCAvailability);

