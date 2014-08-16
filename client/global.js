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

/* Tracking */

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-374430-6', 'auto');
ga('send', 'pageview');
