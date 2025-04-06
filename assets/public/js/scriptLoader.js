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

export function replaceScript(oldSrc, newSrc) {
    const oldScript = document.querySelector(`script[src="${oldSrc}"]`);
    if (oldScript) {
        let newScript = document.createElement("script");
        newScript.src = newSrc;
        oldScript.replaceWith(newScript);
    }
}

export function removeScript(scriptSrc) {
    const script = document.querySelector(`script[src="${scriptSrc}"]`);
    if (script) script.remove();
}