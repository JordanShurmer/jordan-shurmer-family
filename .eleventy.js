module.exports = function (eleventyConfig) {
    // Satic things
    eleventyConfig.addPassthroughCopy("static");
    eleventyConfig.addPassthroughCopy("legero.js");

    eleventyConfig.addPassthroughCopy("android-chrome-192x192.png");
    eleventyConfig.addPassthroughCopy("android-chrome-512x512.png");
    eleventyConfig.addPassthroughCopy("apple-touch-icon.png");
    eleventyConfig.addPassthroughCopy("favicon-16x16.png");
    eleventyConfig.addPassthroughCopy("favicon-32x32.png");
    eleventyConfig.addPassthroughCopy("site.webmanifest");


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
