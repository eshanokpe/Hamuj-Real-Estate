import { fireEvent } from '@testing-library/dom';
export function triggerScriptOnLoad(name) {
    var script = document.querySelector("script[src*=\"" + name + "\"]");
    if (!script) {
        throw new Error("Script with source containing \"" + name + "\" was not found in the document");
    }
    fireEvent.load(script);
}
export function triggerScriptOnError(name) {
    var script = document.querySelector("script[src*=\"" + name + "\"]");
    if (!script) {
        throw new Error("Script with source containing \"" + name + "\" was not found in the document");
    }
    fireEvent.error(script);
}
export function settleVersionScript(settledCallback) {
    var params = [];
    for (var _i = 1; _i < arguments.length; _i++) {
        params[_i - 1] = arguments[_i];
    }
    return new Promise(function (resolve) {
        setTimeout(function () {
            settledCallback.apply(void 0, params);
            // Resolve only when embed is injected as we are attaching listeners to the script element
            // Since version script load errors are ignored, embed is being injected for both onload and onerror
            var observer = new MutationObserver(function () {
                if (document.querySelector('script[src*="embed.js"]')) {
                    observer.disconnect();
                    resolve();
                }
            });
            observer.observe(document, {
                childList: true,
                subtree: true,
            });
        });
    });
}
