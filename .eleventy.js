module.exports = function (eleventyConfig) {
    // copy "static" as is
    eleventyConfig.addPassthroughCopy("static");
    eleventyConfig.addPassthroughCopy("legero.js");

    // a TOC
    // {{ content | toc | safe }}
    const toc = require('eleventy-plugin-toc');
    eleventyConfig.addPlugin(toc);

    // Markdown (including adding IDs to the headers)
    const markdownIt = require('markdown-it');
    const markdownItAnchor = require('markdown-it-anchor');

    // Date filter
    // https://www.npmjs.com/package/nunjucks-date
    const nunjucksDate = require('nunjucks-date');
    nunjucksDate.setDefaultFormat('MMMM Do YYYY');
    eleventyConfig.addFilter('date', nunjucksDate);


    eleventyConfig.setLibrary("md",
        markdownIt({
            html: true,
            linkify: true,
            typographer: true,
        }).use(markdownItAnchor, {})
    );

    return {
        jsDataFileSuffix: ".metadata",
        passthroughFileCopy: true,
        markdownTemplateEngine: "njk",
    }
};