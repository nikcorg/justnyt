// Older browsers (IE) doesn't understand HTML5 elements, unless we create them first
var i, elems = "section,nav,article,aside,header,footer,main".split(",");

function createEl(el) {
    document.createElement(el);
}

for (i in elems) createEl(elems[i]);

/* Webfonts */

var WebFontConfig = window.WebFontConfig = {
    google: { families: [ 'Special+Elite::latin' ] }
};
(function() {
var wf = document.createElement('script');
wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
wf.type = 'text/javascript';
wf.async = 'true';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(wf, s);
})();

if (process.env.NODE_ENV !== "production") {
    // Enable all debug output
    require("./tracking");
}
