document.querySelectorAll('pre>code')
    .forEach(function (codeElement) {
        codeElement = codeElement.parentElement;
        //the language is configured on a <meta> tag just before the <pre> block (which is, unfortunately, wrapped in a p tag by the markdown)
        const conf = codeElement.previousElementSibling.querySelector('meta');
        let mode = "";
        if (conf && conf.name === 'lang') {
            mode = `ace/mode/${conf.content}`;
        }

        const editor = ace.edit(codeElement, {
            readOnly: true,
            maxLines: 30, //make sure the editor has a height
            theme: "ace/theme/monokai",
            mode: mode,
        });
    });
