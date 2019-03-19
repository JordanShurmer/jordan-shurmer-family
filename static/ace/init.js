document.querySelectorAll('pre>code')
    .forEach(function (codeElement) {
        console.group();
        console.debug("initializing ace for", codeElement);
        const classMatch = /language-(\w+)/.exec(codeElement.className);
        const mode = classMatch && `ace/mode/${classMatch[1]}` || undefined;
        console.debug({classMatch, "className": codeElement.className, mode});

        const editor = ace.edit(codeElement.parentElement, {
            readOnly: true,
            maxLines: 30, //make sure the editor has a height
            theme: "ace/theme/monokai",
            mode: mode,
        });
        console.groupEnd();
    });
