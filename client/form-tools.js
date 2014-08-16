function setBlocker(form) {
    form.querySelector(".form-blocker").classList.remove("hidden");
}

function clearBlocker(form) {
    form.querySelector(".form-blocker").classList.add("hidden");
}

function clearErrorMessages(form) {
    var container = form.querySelector(".error-container");
    container.classList.add("hidden");

    [].slice.call(container.childNodes).forEach(function (node) {
        node.parentNode.removeChild(node);
    });
}

function flashErrorMessage(form, msg) {
    var container = form.querySelector(".error-container");
    var errorMsg = this["err" + msg] || (this["err" + msg] = (function (node) {
        node.className = "notify";
        node.innerHTML = msg;

        return node;
    }(document.createElement("p"))));

    container.appendChild(errorMsg);
    container.classList.remove("hidden");
}

function findInput(form, name) {
    if (this[name]) {
        return this[name];
    }

    return form.querySelector(["input", "select", "textarea", "button"].map(function (type) {
        return type + "[name=" + name + "]";
    }).join(","));
}

function init(formNode) {
    var scopeCache = {};

    return {
        node: formNode,
        addEventListener: formNode.addEventListener.bind(formNode),
        findInput: findInput.bind(scopeCache, formNode),
        setBlocker: setBlocker.bind(scopeCache, formNode),
        clearBlocker: clearBlocker.bind(scopeCache, formNode),
        flashErrorMessage: flashErrorMessage.bind(scopeCache, formNode),
        clearErrorMessages: clearErrorMessages.bind(scopeCache, formNode)
    };
}

module.exports = init;
