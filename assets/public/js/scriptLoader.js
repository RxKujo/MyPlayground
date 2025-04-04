export function isScriptPresent(scriptSrc) {
    return !!document.querySelector(`script[src="${scriptSrc}"]`);
}

export function addScript(scriptSrc) {
    if (!isScriptPresent(scriptSrc)) {
        const script = document.createElement("script");
        script.src = scriptSrc;
        document.body.appendChild(script);
    }
}

export function removeScript(scriptSrc) {
    const script = document.querySelector(`script[src="${scriptSrc}"]`);
    if (script) script.remove();
}