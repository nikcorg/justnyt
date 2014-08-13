// Older browsers (IE) doesn't understand HTML5 elements, unless we create them first
var i, elems = "section,nav,article,aside,header,footer,main".split(",");

function createEl(el) {
    document.createElement(el);
}

for (i in elems) createEl(elems[i]);
