import { addScript, isScriptPresent, removeScript, replaceScript } from "./scriptLoader.js";


export async function fetchPage(page) {
    try {
        let response;
        if (page === "settings") {
            response = await fetch("pages/public/settings.php");
        } else {
            response = await fetch(`pages/public/${page}.html`);
        }
        const content = await response.text();
        return content;
    } catch (error) {
        console.error("Error fetching page:", error);
    }
}

export async function loadContent(page, contentElement) {
    const webPage = await fetchPage(page);
    if (webPage) {
        contentElement.innerHTML = webPage;
        if (page === "tournaments") {
            let src = "assets/public/js/carouselLoader.js";
            
            if (!isScriptPresent(src)) {
                addScript(src);
            } else {
                replaceScript(src, src);
            }
        }
    } else {
        console.error("Failed to load page content.");
    }
}