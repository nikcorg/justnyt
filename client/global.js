var _ = require("underscore");

// Older browsers (IE) doesn't understand HTML5 elements, unless we create them first
function createEl(el) {
    document.createElement(el);
}

_("header,footer,section,article,aside,nav,main".split(",")).map(createEl);
